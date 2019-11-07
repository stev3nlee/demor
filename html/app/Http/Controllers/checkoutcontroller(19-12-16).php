<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Member;
use App\Http\Models\Order;
use App\Http\Models\General;

use App\Veritrans\Veritrans;
use SoapClient;
use GuzzleHttp\Client;

class CheckoutController extends Controller
{
	public function validationPush(&$arr, $data, $msg)
	{
		$flag = true;
		for($i=0; $i<count($arr); $i++)
		{
			if($arr[$i]->form == $data){
				array_push($arr[$i]->msg, $msg);
				$flag = false;
				break;
			}
		}
		if(count($arr) == 0 || $flag){
			array_push($arr, (object)['form'=>$data, 'msg'=>[$msg]]);	
		}
	}
	public function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	public function validateVoucher(Request $request)
	{
		$validation = [];
		
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null)
			return ['success' => false];
		else
		{
			$vouchers = $request->input('voucher');
			$this->addDetailCart($request, $vouchers);
			return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'vouchers' => $vouchers];
		}
	}
	public function checkout(Request $request)
	{
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null)
			return redirect('login');
		else
		{
			$mmbr = $member->getMemberByEmail($all->member->email)[0];
			return view('checkout/checkout_info', [
				'general'=>$all,
				'memberDetail'=>$mmbr,
				'countries'=>$member->getAllCountry(),
				'states'=>$member->getStateById($mmbr->country),
				'cities'=>$member->getCityById($mmbr->state),
				'postalcodes'=>$member->getPostCodeById($mmbr->city)
			]);
		}
	}
	
	public function checkoutSubmitInfo(Request $request)
	{
		$validation = [];
		
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('email');
		$address = $request->input('address');
		$country = $request->input('country');
		$state = $request->input('state');
		$city = $request->input('city');
		$zipcode = $request->input('postcode');
		$telephoneNumber = $request->input('telephoneNumber');
		$mobileNumber = $request->input('mobileNumber');
		$sameAddress = ($request->input('same_address') == "" ? 0 : 1);
		$note = $request->input('note');
		if($sameAddress == 0)
		{
			$bfname = $request->input('bfname');
			$blname = $request->input('blname');
			$bemail = $request->input('bemail');
			$baddress = $request->input('baddress');
			$bcountry = $request->input('bcountry');
			$bstate = $request->input('bstate');
			$bcity = $request->input('bcity');
			$bzipcode = $request->input('bpostcode');
			$btelephoneNumber = $request->input('btelephoneNumber');
			$bmobileNumber = $request->input('bmobileNumber');
		}
		else
		{
			$bfname = $fname;
			$blname = $lname;
			$bemail = $email;
			$baddress = $address;
			$bcountry = $country;
			$bstate = $state;
			$bcity = $city;
			$bzipcode = $zipcode;
			$btelephoneNumber = $telephoneNumber;
			$bmobileNumber = $mobileNumber;
		}
		if($fname == '')
		{
			$this->validationPush($validation, 'fname', 'Please fill in the billing first name field.');
		}
		if($lname == '')
		{
			$this->validationPush($validation, 'lname', 'Please fill in the billing last name field.');
		}
		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the billing email address field.');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address.');
		}
		if($address == '')
		{
			$this->validationPush($validation, 'address', 'Please fill in the billing address field.');
		}
		if($zipcode == '')
		{
			$this->validationPush($validation, 'zipcode', 'Please fill in the billing ZIP code field.');
		}
		if($telephoneNumber == '')
		{
			$this->validationPush($validation, 'telephoneNumber', 'Please fill in the telephone number field.');
		}
		if($mobileNumber == '')
		{
			$this->validationPush($validation, 'mobileNumber', 'Please fill in the mobile number field.');
		}
		if($sameAddress == 0)
		{
			if($bfname == '')
			{
				$this->validationPush($validation, 'bfname', 'Please fill in the shipping first name field.');
			}
			if($blname == '')
			{
				$this->validationPush($validation, 'blname', 'Please fill in the shipping last name field.');
			}
			if($bemail == '')
			{
				$this->validationPush($validation, 'bemail', 'Please fill in the shipping email address field.');
			}
			else if(!$this->validateEmail($bemail))
			{
				$this->validationPush($validation, 'bemail', 'Please enter a valid email address');
			}
			if($baddress == '')
			{
				$this->validationPush($validation, 'baddress', 'Please fill in the shipping address field.');
			}
			if($bzipcode == '')
			{
				$this->validationPush($validation, 'bzipcode', 'Please fill in the shipping ZIP code field.');
			}
			if($btelephoneNumber == '')
			{
				$this->validationPush($validation, 'btelephoneNumber', 'Please fill in the shipping telephone number field.');
			}
			if($bmobileNumber == '')
			{
				$this->validationPush($validation, 'bmobileNumber', 'Please fill in the shipping mobile number field.');
			}
		}
		if(count($validation) == 0){
			$info = $request->session()->get('cartinfo');
			
			$wsdl="http://api.rpxholding.com/wsdl/rpxwsdl.php?wsdl";
			try {
				$client = new \SoapClient($wsdl);
				$username = "demorboutique";
				$password  = "demorrpxpsw";
				$result = $client->getRatesPostalCode($username,$password, '14430', $bzipcode, 'RGP', 1, 0, 'JSON');
				
				$shipping = json_decode($result)->RPX->DATA->PRICE;
			}
			catch ( Exception $e ) {
				echo $e->getMessage();
			}
			$info->Shipping = (object)["bfname"=>$bfname, "blname"=>$blname, "bemail"=>$bemail, "baddress"=>$baddress, "bcountry"=>$bcountry, "bstate"=>$bstate, "bcity"=>$bcity, "bzipcode"=>$bzipcode, "btelephoneNumber"=>$btelephoneNumber, "bmobileNumber"=>$bmobileNumber];
			$info->Billing = (object)["fname"=>$fname, "lname"=>$lname, "email"=>$email, "address"=>$address, "country"=>$country, "state"=>$state, "city"=>$city, "zipcode"=>$zipcode, "telephoneNumber"=>$telephoneNumber, "mobileNumber"=>$mobileNumber];
			$info->Header->shipping = $shipping;
			$info->Header->note = $note;
			$request->session()->put('cartinfo', $info);
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
	
	public function checkoutPayment(Request $request)
	{
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		
		if($all->member == null)
			return redirect('login');
		else
		{
			return view('checkout/checkout_payment', [
				'general'=>$all,
				'paymenttype'=>$member->getAllPayment(),
				'payments'=>$member->getAllPublishBanks()
			]);
		}
	}
	
	public function checkoutConfirm(Request $request)
	{
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null)
			return redirect('login');
		else
		{
			return view('checkout/checkout_confirm', [
				'general'=>$all,
			]);
		}
	}
	
	public function checkoutTransferSubmit(Request $request)
	{
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null)
			return ['success' => false];
		else
		{
			$order = new Order;
			$validation = [];
			$lastno = $order->getLastOrderNo(date("dmy"));
			if(count($lastno) == 0){
				$lastno = date("dmy").'001';
			}
			else{
				$no = intval(substr($lastno[0]->orderno, 6)) + 1;
				$no = str_pad($no, 3, "0", STR_PAD_LEFT);
				$lastno = substr($lastno[0]->orderno, 0, 6).$no;
			}
			$order->insertOrder($lastno, $all, 'Bank Transfer');
			$data = (object)[
				'orderheader' =>$order->getOrderHeader($lastno),
				'orderdetail' =>$order->getOrderDetail($lastno)
			];
			$client = new Client();
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'order',
					'emailFrom' => $data->orderheader[0]->memberemail,
					'data' => $data
				]
			]);
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'orderAdmin',
					'emailFrom' => 'cs@demorboutique.com',
					'data' => $data
				]
			]);
			
			$request->session()->forget('cart');
			$request->session()->forget('cartinfo');
			
			return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'orderNo' => $lastno];
		}
	}
	
	public function checkoutTransferSuccess(Request $request, $orderNo)
	{
		$general = new General;
		$order = new Order;
		$all = $general->getAll($request);
		
		if($all->member == null)
			return redirect('login');
		else
		{
			return view('checkout/checkout_transfer_success', [
				'general'=>$all,
				'orderheader'=>$order->getOrderHeader($orderNo)[0],
				'orderdetail'=>$order->getOrderDetail($orderNo),
				'orderinfo'=>$order->getOrderInfo($orderNo)
			]);
		}
	}
	
	public function checkoutVtWeb(Request $request)
	{
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null)
			return redirect('login');
		else
		{
			Veritrans::$serverKey = 'VT-server-mY8kguFS9pW-i2_5uxZ6OrUO';
			Veritrans::$isProduction = false;
			$veritrans = new Veritrans;
			
			$order = new Order;
			$lastno = $order->getLastOrderNo(date("dmy"));
			if(count($lastno) == 0){
				$lastno = date("dmy").'001';
			}
			else{
				$no = intval(substr($lastno[0]->orderno, 6)) + 1;
				$no = str_pad($no, 3, "0", STR_PAD_LEFT);
				$lastno = substr($lastno[0]->orderno, 0, 6).$no;
			}
			$cartInfo = $request->session()->get('cartinfo');
			$cartInfo->Header->conveniencefee = (($all->cartinfo->Header->subtotal - $all->cartinfo->Header->vouchernominal + $all->cartinfo->Header->shipping + $all->cartinfo->Header->tax) * 3.2 / 100) + 3000;
			//var_dump($cartInfo);
			$request->session()->put('cartinfo', $cartInfo);
			
			$all = $general->getAll($request);
			
			$transaction_details = array(
				'order_id'      => $lastno,
				'gross_amount'  => $all->cartinfo->Header->subtotal - $all->cartinfo->Header->vouchernominal + $all->cartinfo->Header->shipping + $all->cartinfo->Header->tax + $all->cartinfo->Header->conveniencefee
			);
			
			// Populate items
			$items = [];
			foreach($all->cart as $cart)
			{
				$item = array(
					'id'       => $cart->productId,
					'price'    => $cart->productPrice,
					'quantity' => $cart->productQuantity,
					'name'     => $cart->productName
				);
				array_push($items, $item);
			}
			$tempItem = array(
					'id'       => 'fshipping',
					'price'    => $all->cartinfo->Header->shipping,
					'quantity' => 1,
					'name'     => 'Shipping Fee'
				);
			array_push($items, $tempItem);
			$tempItem = array(
					'id'       => 'fvoucher',
					'price'    => $all->cartinfo->Header->vouchernominal,
					'quantity' => 1,
					'name'     => 'Voucher'
				);
			array_push($items, $tempItem);
			$tempItem = array(
					'id'       => 'ftax',
					'price'    => $all->cartinfo->Header->tax,
					'quantity' => 1,
					'name'     => 'Tax'
				);
			array_push($items, $tempItem);
			$tempItem = array(
					'id'       => 'fconveniencefee',
					'price'    => $all->cartinfo->Header->conveniencefee,
					'quantity' => 1,
					'name'     => 'Convenience Fee'
				);
			array_push($items, $tempItem);
			// Populate customer's billing address
			$billing_address = array(
				'first_name'        => $all->cartinfo->Billing->fname,
				'last_name'         => $all->cartinfo->Billing->lname,
				'address'           => $all->cartinfo->Billing->address,
				'city'              => $all->cartinfo->Billing->city,
				'postal_code'       => $all->cartinfo->Billing->zipcode,
				'phone'             => $all->cartinfo->Billing->mobileNumber,
				'country_code'      => 'IDN'
				);
			// Populate customer's shipping address
			$shipping_address = array(
				'first_name'        => $all->cartinfo->Shipping->bfname,
				'last_name'         => $all->cartinfo->Shipping->blname,
				'address'           => $all->cartinfo->Shipping->baddress,
				'city'              => $all->cartinfo->Shipping->bcity,
				'postal_code'       => $all->cartinfo->Shipping->bzipcode,
				'phone'             => $all->cartinfo->Shipping->bmobileNumber,
				'country_code'=> 'IDN'
				);
			// Populate customer's Info
			$customer_details = array(
				'first_name'        => $all->cartinfo->Billing->fname,
				'last_name'         => $all->cartinfo->Billing->lname,
				'email'             => $all->cartinfo->Billing->email,
				'phone'             => $all->cartinfo->Billing->mobileNumber,
				'billing_address' => $billing_address,
				'shipping_address'=> $shipping_address
				);
			// Data yang akan dikirim untuk request redirect_url.
			// Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
			$transaction = array(
				'payment_type'          => 'vtweb', 
				'vtweb'                         => array(
					//'enabled_payments'    => [],
					'credit_card_3d_secure' => true
				),
				'transaction_details'=> $transaction_details,
				'item_details'           => $items,
				'customer_details'   => $customer_details
			);
			
			try {
				// Redirect to Veritrans VTWeb page
				$vtweb_url = $veritrans->vtweb_charge($transaction);
				return redirect($vtweb_url);
			}
			catch (Exception $e) {
				$cartInfo = $request->session()->get('cartinfo');
				$cartInfo->Header->conveniencefee = 0;
				$request->session()->put('cartinfo', $cartInfo);
				return $e->getMessage();
			}
		}
	}
	
	public function checkoutVtWebSuccess(Request $request)
	{
		$orderid = $request->input('order_id');
		$statuscode = $request->input('status_code');
		$transactionstatus = $request->input('transaction_status');
        
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null)
			return ['success' => false];
		else if($statuscode != 200 || $transactionstatus != 'capture')
		{
			return ['success' => false];
		}
		else
		{
			$order = new Order;
			$validation = [];
			$lastno = $orderid;
			$order->insertOrder($lastno, $all, 'VT Web');
			$data = (object)[
				'orderheader' =>$order->getOrderHeader($lastno),
				'orderdetail' =>$order->getOrderDetail($lastno)
			];
			$client = new Client();
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'order',
					'emailFrom' => $data->orderheader[0]->memberemail,
					'data' => $data
				]
			]);
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'orderAdmin',
					'emailFrom' => 'cs@demorboutique.com',
					'data' => $data
				]
			]);
			$request->session()->forget('cart');
			$request->session()->forget('cartinfo');
			
			return redirect('checkout/transfersuccess/'.$lastno);
		}
	}
	
	public function cart(Request $request)
	{
		$general = new General;
		return view('product/cart', [
			'general'=>$general->getAll($request)
		]);
	}
	
	public function addDetailCart(Request $request, $vouchers)
	{
		$member = new Member;
		$subtotal = 0;
		$voucherId = "";
		$voucher = "";
		$vouchernominal = 0;
		$carts = ($request->session()->get('cart') == null ? [] : $request->session()->get('cart'));
		
		foreach($carts as $c)
		{
			$subtotal += $c->productPrice * $c->productQuantity;
		}
		if($vouchers != null)
		{
			$voucherId = $vouchers['voucherid'];
			$voucher = $vouchers['vouchername'];
			$vouchernominal = $vouchers['discount'];
		}
			
		$info = (object)[
			"Header"=>(object)["subtotal"=>$subtotal, "conveniencefee"=>0, "shipping"=>0, "voucherid"=>$voucherId, "voucher"=>$voucher, "vouchernominal"=>$vouchernominal, "tax"=>$subtotal * $member->getOthers()[0]->tax / 100, "note"=>""],
			"Shipping"=>null,
			"Billing"=>null
		];
		$request->session()->put('cartinfo', $info);
		return $info;
	}
	
	public function addVoucher(Request $request)
	{
		$validation = [];
		$member = new Member;
		$v = [];
		$voucher = $request->input('voucher');
		
		$vouchers = $member->getVoucherByName($voucher);
		if($voucher == '')
		{
			$this->validationPush($validation, 'voucher', 'Please fill in the voucher field name.');
		}
		else if(count($vouchers) == 0)
		{
			$this->validationPush($validation, 'voucher', 'The voucher is not existed or has expired.');
		}
		
		if(count($validation) == 0){
			$v = $vouchers[0];
			//$this->addDetailCart($request, $vouchers);
		}
		
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'vouchers' => $v];
	}
	
	public function addToCart(Request $request)
	{
		$productId = $request->input('productId');
		$productCode = $request->input('productCode');
		$productName = $request->input('productName');
		$productPrice = $request->input('productPrice');
		$productImage = $request->input('productImage');
		$productColor = $request->input('productColor');
		$productColorPath = $request->input('productColorPath');
		$productSize = $request->input('productSize');
		$productStock = $request->input('productStock');
		$productQuantity = $request->input('productQuantity');
		$carts = [];
		
		$cart = (object)[
			"productId"=>$productId, 
			"productCode"=>$productCode, 
			"productName"=>$productName, 
			"productPrice"=>$productPrice, 
			"productImage"=>$productImage, 
			"productColor"=>$productColor, 
			"productColorPath"=>$productColorPath, 
			"productSize"=>$productSize, 
			"productStock"=>$productStock, 
			"productQuantity"=>$productQuantity
		];
		
		$flag = true;
		$carts = ($request->session()->get('cart') == null ? [] : $request->session()->get('cart'));
		foreach($carts as $c)
		{
			if($c->productId == $cart->productId && $c->productColor == $cart->productColor && $c->productSize == $cart->productSize)
			{
				$c->productQuantity = $cart->productQuantity;
				$flag = false;
				break;
			}
		}
		if($flag || $request->session()->get('cart') == null)
			array_push($carts, $cart);
		
		$request->session()->put('cart', $carts);
		$info = $this->addDetailCart($request, null);
		return ['success' => true, 'cart'=>$carts, 'info'=>$info]; 
	}
	
	public function deleteCart(Request $request, $id, $color, $size)
	{
		$carts = ($request->session()->get('cart') == null ? [] : $request->session()->get('cart'));
		foreach($carts as $index => $c)
		{
			if($c->productId == $id && $c->productColor == $color && $c->productSize == $size)
			{
				unset($carts[$index]);
				$flag = false;
				break;
			}
		}
		$request->session()->put('cart', $carts);
		$this->addDetailCart($request, null);
		return redirect('cart');
	}
}