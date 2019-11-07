<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\Order;
use App\Http\Models\Member;
use App\Http\Models\Page;
use App\Http\Models\Converter;
//use GuzzleHttp\Client;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOrder;
use App\Mail\EmailPermit;
use App\Mail\EmailNotPermit;
use App\Mail\EmailOrderRefund;
use App\Mail\EmailOrderCancel;

class AdminOrderController extends Controller
{
	public function order(Request $request)
	{
		$order = new Order;
		$member = new Member;
		$converter = new Converter;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Order', 'path'=>'admin/commerce/order']
		];

		$orders = $order->getAllOrderTransaction();
		foreach($orders as $o)
		{
			$o->insertdate = $converter->dateFormat($o->insertdate);
			$o->updatedate = $converter->dateFormat($o->updatedate);
		}

        return view('admin/store/order/index', ['admin'=>$admin, 'orders'=>$orders, 'vouchers'=>$member->getAllActiveVoucher(), 'breadCrumb'=>$breadCrumb]);
	}
	public function submitConfirmPaid(Request $request)
	{
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('orderNo');

		$order->confirmPaid($orderNo);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo)
		];
		/*$client = new Client();
		$res = $client->request('POST', 'http://localhost/mail/index.php', [
			'form_params' => [
				'cons' => 'order',
				'emailFrom' => $data->orderheader[0]->memberemail,
				'data' => $data
			]
		]);*/
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data));
		return redirect('meisjejongetje/commerce/order')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully confirmed this order.']);
	}

	public function submitConfirmPaidTesting(Request $request,$orderNo)
	{
		$order= new Order;
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo)
		];
		/*$client = new Client();
		$res = $client->request('POST', 'http://localhost/mail/index.php', [
			'form_params' => [
				'cons' => 'order',
				'emailFrom' => $data->orderheader[0]->memberemail,
				'data' => $data
			]
		]);*/
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data));
	}
	public function submitShippingTracking(Request $request)
	{
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('trackingOrderNo');
		$tracking = $request->input('tracking');

		$order->confirmShippingTracking($orderNo, $tracking);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo)
		];
		/*$client = new Client();
		$res = $client->request('POST', 'http://localhost/mail/index.php', [
			'form_params' => [
				'cons' => 'order',
				'emailFrom' => $data->orderheader[0]->memberemail,
				'data' => $data
			]
		]);*/
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data));
		return redirect('meisjejongetje/commerce/order')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully inserted the tracking order.']);
	}
	public function deleteOrder(Request $request)
	{
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$id = $request->input('deleteId');
		$order->deleteOrder($id);
		return redirect('meisjejongetje/commerce/order')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this order.']);
	}
	public function cancelOrder(Request $request)
	{
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('cancelId');
		$order->updateExpireOrder2($orderNo);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo)
		];
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrderCancel($data));
		return redirect('meisjejongetje/commerce/order')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully cancel this order.']);
	}
	public function viewOrder(Request $request, $orderNo)
	{
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Order', 'path'=>'admin/commerce/order'],
			(object)['name' =>'View Order', 'path'=>'admin/commerce/order/view/'.$orderNo]
		];

        return view('admin/store/order/view', [
			'admin'=>$admin,
			'orderheader'=>$order->getOrderHeader($orderNo)[0],
			'orderdetail'=>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo),
			'orderhistory'=>$order->getOrderHistory($orderNo),
			'orderpayment'=>$order->getOrderPayment($orderNo),
			'breadCrumb'=>$breadCrumb
		]);
	}
	public function getOrderDetail(Request $request){
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('orderno');

		return ['orderdetail'=>$order->getOrderDetail($orderNo)];
	}

	public function recalculate($orderDetail, $data)
	{
		$ret = (object)['subtotal'=>0, 'shippingfee'=>false];
		$qty = 0; $detqty = 0;

		foreach($data as $d)
		{
			$ret->subtotal += ($d->productprice * $d->quantity);
			$qty += $d->quantity;
		}
		foreach($orderDetail as $detail)
		{
			$detqty += $detail->quantity;
		}
		if($qty == $detqty)
			$ret->shippingfee = true;

		return $ret;
	}

	public function submitPermit(Request $request){
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('orderno');
		$voucher = $request->input('voucher');
		$product = $request->input('product');
		$quantity = $request->input('quantity');

		if(count($order->getOrderPermit($orderNo)) > 0)
		{
			$request->session()->flash('message', (object)['type'=>'alert-warning', 'content'=>'Sorry, this order number has already set as Permit Status before.']);
			return ['success' => true];
		}

		$order->submitPermit($orderNo, $voucher, $product, $quantity);
		$permit = $order->getOrderPermit($orderNo)[0];
		$permit->permitdetail = $order->getOrderPermitDetail($orderNo);
		$orderDetail = $order->getOrderDetail($orderNo);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$orderDetail,
			'orderinfo'=>$order->getOrderInfo($orderNo),
			'orderpermit'=>$permit,
			'calculatepermit'=>$this->recalculate($orderDetail, $permit->permitdetail)
		];
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailPermit($data));

		$request->session()->flash('message', (object)['type'=>'alert-success', 'content'=>'You have successfully saved this order into Permit Status']);
		return ['success' => true];
	}

	public function submitNotPermit(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$order = new Order;
		$orderNo = $request->input('orderNo');
		$productName = $request->input('productName');
		$size = $request->input('size');
		$colour = $request->input('colour');
		$quantity = $request->input('quantity');
		$shippingCost = $request->input('shippingCost');

		if(count($order->getOrderNotPermit($orderNo)) > 0)
		{
			$request->session()->flash('message', (object)['type'=>'alert-warning', 'content'=>'Sorry, this order number has already set as Not Permitt Status before.']);
			return redirect('meisjejongetje/commerce/order');
		}

		$order->submitNotPermit($orderNo, $productName, $size, $colour, $quantity, $shippingCost);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'ordernotpermit' =>$order->getOrderNotPermit($orderNo)
		];
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailNotPermit($data));

		return redirect('meisjejongetje/commerce/order')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully saved this order into Not Permitted Status.']);
	}

	public function submitRefund(Request $request){
		$order = new Order;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$orderNo = $request->input('orderno');
		$product = $request->input('product');
		$quantity = $request->input('quantity');

		if(count($order->getOrderRefund($orderNo)) > 0)
		{
			$request->session()->flash('message', (object)['type'=>'alert-warning', 'content'=>'Sorry, this order number has already set as Refund Status before.']);
			return ['success' => true];
		}

		$order->submitRefund($orderNo, $product, $quantity);
		$orderDetail = $order->getOrderDetail($orderNo);
		$refund = $order->getOrderRefund($orderNo);
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($orderNo),
			'orderdetail' =>$orderDetail,
			'orderinfo'=>$order->getOrderInfo($orderNo),
			'orderrefund'=>$refund,
			'calculatepermit'=>$this->recalculate($orderDetail, $refund)
		];
		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrderRefund($data));

		$request->session()->flash('message', (object)['type'=>'alert-success', 'content'=>'You have successfully saved this order into Refund Status.']);
		return ['success' => true];
	}

	public function invoice(Request $request, $orderNo)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$order = new Order;
		$page = new Page;
		return view('admin/store/order/invoice', [
			'contact'=>$page->getContact()[0],
			'orderheader'=>$order->getOrderHeader($orderNo)[0],
			'orderdetail'=>$order->getOrderDetail($orderNo),
			'orderinfo'=>$order->getOrderInfo($orderNo),
			'orderhistory'=>$order->getOrderHistory($orderNo)
		]);
	}
}
