<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Member;
use App\Http\Models\Order;
use App\Http\Models\Product;
use App\Http\Models\Converter;
//use GuzzleHttp\Client;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailExchangeReply;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Member', 'path'=>'admin/commerce/member']
		];

		$member = new Member;
        return view('admin/commerce/member/index', ['admin'=>$admin, 'users' => $member->getAllMember(), 'breadCrumb' => $breadCrumb]);
    }

    public function view(Request $request, $userId)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Member', 'path'=>'admin/commerce/member'],
			(object)['name' =>'View Member', 'path'=>'admin/commerce/member/view/'.$userId]
		];

		$member = new Member;
		$order = new Order;
		$converter = new Converter;
		$userById = $member->getMemberById($userId)[0];
		$userById->dateofbirth = $converter->dateFormat($userById->dateofbirth);
		$orders = $order->getOrderHeaderByUser($userId);
		foreach($orders as $o)
		{
			$o->insertdate = $converter->dateFormat($o->insertdate);
			$o->updatedate = $converter->dateFormat($o->updatedate);
		}

		return view('admin/commerce/member/view', ['admin'=>$admin, 'user' => $userById, 'orders' => $orders, 'breadCrumb' => $breadCrumb]);
    }
	public function deleteById(Request $request)
	{
		$member = new Member;

		$id = $request->input('deleteId');
		$member->deleteMemberById($id);

        return redirect('meisjejongetje/commerce/member')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this member.']);
	}

	public function shipping(Request $request)
	{
		$member = new Member;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Shipping', 'path'=>'admin/commerce/shipping']
		];

		return view('admin/commerce/shipping/index', ['admin'=>$admin, 'shippings'=>$member->getAllShipping(), 'breadCrumb'=>$breadCrumb]);
	}
	public function payment(Request $request)
	{
		$member = new Member;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Payment', 'path'=>'admin/commerce/payment']
		];

		return view('admin/commerce/payment/index', ['admin'=>$admin, 'payments'=>$member->getAllPayment(), 'breadCrumb'=>$breadCrumb]);
	}
	public function viewCredit(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Payment', 'path'=>'admin/commerce/payment'],
			(object)['name' =>'Credit Card', 'path'=>'admin/commerce/payment/viewcredit']
		];

		return view('admin/commerce/payment/viewcredit', ['admin'=>$admin, 'breadCrumb'=>$breadCrumb]);
	}
	public function viewTransfer(Request $request)
	{
		$member = new Member;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Payment', 'path'=>'admin/commerce/payment'],
			(object)['name' =>'Bank Transfer', 'path'=>'admin/commerce/payment/viewtransfer']
		];

		return view('admin/commerce/payment/viewtransfer', ['admin'=>$admin, 'banks'=>$member->getAllBanks(), 'breadCrumb'=>$breadCrumb]);
	}
	public function savePublish(Request $request)
	{
		$member = new Member;
		$id = $request->input('showId');
		$isPublish = $request->input('ispublish');
		if(count($member->getAllPublishPayment()) == 1 && $isPublish == 0)
		{
			return redirect('meisjejongetje/commerce/payment')->with('message', (object)['type'=>'alert-warning', 'content'=>'You can not hide all payments.']);
		}

		$member->savePublish($id, $isPublish);

        return redirect('meisjejongetje/commerce/payment')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edit this information.']);
	}
	public function addTransfer(Request $request)
	{
		$member = new Member;

		$bank = $request->input('bank');
		$account = $request->input('account');
		$accountName = $request->input('accountName');
		$isPublish = ($request->input('isPublish') == null ? 0 : 1);

		$this->validate($request, [
			'account' => 'required|unique:payment_transfer,accountnumber',
		]);

		if($bank == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the bank name.']);
		}
		else if($account == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the account number.']);
		}
		else if($accountName == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the account name.']);
		}
		else if (count($member->getBanksByName(0, $account)))
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'The account number has already existed.']);
		}

		$member->addBankTransfer($bank, $account, $accountName, $isPublish);
        return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this bank transfer account.']);
	}
	public function editTransfer(Request $request)
	{
		$member = new Member;

		$id = $request->input('editTransferId');
		$bank = $request->input('editBank');
		$account = $request->input('editAccount');
		$accountName = $request->input('editAccountName');
		$isPublish = ($request->input('editIsPublish') == null ? 0 : 1);

		if($bank == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the bank name.']);
		}
		else if($account == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the account number.']);
		}
		else if($accountName == '')
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the account name.']);
		}
		else if (count($member->getBanksByName($id, $account)))
		{
			return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-warning', 'content'=>'The account number has already existed.']);
		}

		$member->editBankTransfer($id, $bank, $account, $accountName, $isPublish);
        return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this bank transfer account.']);
	}
	public function deleteTransfer(Request $request)
	{
		$member = new Member;

		$id = $request->input('deleteId');
		$member->deleteBankTransferById($id);

        return redirect('meisjejongetje/commerce/payment/viewtransfer')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this bank transfer account.']);
	}

	public function voucher(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		$member = new Member;
		$converter = new Converter;

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Voucher', 'path'=>'admin/commerce/voucher']
		];

		$vouchers = $member->getAllVoucher();
		foreach($vouchers as $voucher)
		{
			$voucher->discountbegin = ($voucher->isexpired == 1 ? $voucher->discountbegin : $converter->dateFormat($voucher->discountbegin));
			$voucher->discountend = ($voucher->isexpired == 1 ? $voucher->discountend : $converter->dateFormat($voucher->discountend));
			$voucher->insertdate = $converter->dateFormat($voucher->insertdate);
			$voucher->discount = $converter->thousandSepator($voucher->discount);
		}

		return view('admin/commerce/voucher/index', ['admin'=>$admin, 'vouchers'=>$vouchers, 'breadCrumb'=>$breadCrumb]);
	}
	public function addVoucher(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		$product = new Product;

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Voucher', 'path'=>'admin/commerce/voucher'],
			(object)['name' =>'Add Voucher', 'path'=>'admin/commerce/voucher/add']
		];

		return view('admin/commerce/voucher/add', ['admin'=>$admin, 'productCategories'=>$product->getAllProductCategory(), 'breadCrumb'=>$breadCrumb]);
	}
	public function viewVoucher(Request $request, $id)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		$member = new Member;
		$converter = new Converter;

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Voucher', 'path'=>'admin/commerce/voucher'],
			(object)['name' =>'View Voucher', 'path'=>'admin/commerce/voucher/view/'.$id]
		];
		$vouchers = $member->getAllOrderHeaderByVoucher($id);
		foreach($vouchers as $voucher)
		{
			$voucher->insertdate = $converter->dateFormat($voucher->insertdate);
			$voucher->subtotal = $converter->thousandSepator($voucher->subtotal);
			$voucher->vouchernominal = $converter->thousandSepator($voucher->vouchernominal);
			$voucher->total = $converter->thousandSepator($voucher->total);
		}

		return view('admin/commerce/voucher/view', ['admin'=>$admin, 'breadCrumb'=>$breadCrumb, 'members'=>$vouchers]);
	}
	public function deleteVoucher(Request $request)
	{
		$member = new Member;

		$id = $request->input('deleteId');
		$member->deleteVoucherById($id);

        return redirect('meisjejongetje/commerce/voucher')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully stop this voucher.']);
	}
	public function submitVoucher(Request $request)
	{
		$member = new Member;

		$voucherName = $request->input('voucherName');
		$vat = ($request->input('vat') == '' ? 0 : $request->input('vat'));
		$isLimited = ($request->input('isLimited') == null ? 0:1);
		$price = ($request->input('price') == '' ? 0 : $request->input('price'));
		$category = $request->input('category');
		$beginDate = $request->input('beginDate');
		$endDate = $request->input('endDate');
		$isExpired = ($request->input('isExpired') == null ? 0:1);

		if($voucherName == '')
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the voucher name.']);
		}
		else if(count($member->getVoucherByName($voucherName)) > 0)
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'The voucher name has already been existed.']);
		}
		else if($isLimited == 0 && $vat == 0)
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the times can be used.']);
		}
		else if($price == 0)
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the price field.']);
		}
		else if($isExpired == 0 && $beginDate == '')
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please insert the begin date.']);
		}
		else if($isExpired == 0 && $endDate == '')
		{
			return redirect('meisjejongetje/commerce/voucher/add')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please insert the end date.']);
		}

		$member->submitVoucher($voucherName, $vat, $isLimited, $price, $category, ($isExpired == 1 ? date("d/m/Y") : $beginDate), ($isExpired == 1 ? date("d/m/Y") : $endDate), $isExpired);
		return redirect('meisjejongetje/commerce/voucher')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added new voucher.']);
	}
	public function exchange(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Exchange', 'path'=>'admin/commerce/exchange']
		];

		$member = new Member;
		$converter = new Converter;
		$exchages = $member->getAllExchange();
		foreach($exchages as $exchange)
		{
			$exchange->exchangedate = $converter->dateFormat($exchange->exchangedate);
		}

		return view('admin/commerce/exchange/index', ['admin'=>$admin, 'exchages'=>$exchages, 'breadCrumb'=>$breadCrumb]);
	}
	public function deleteExchange(Request $request)
	{
		$member = new Member;

		$id = $request->input('deleteId');
		$member->deleteExchangeById($id);

        return redirect('meisjejongetje/commerce/exchange')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this list.']);
	}
	public function submitExchangeReply(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$exchangeId = $request->input('exchangeId');
		$exchangeEmail = $request->input('exchangeEmail');
		$orderNo = $request->input('orderNo');
		$productName = $request->input('productName');
		$size = $request->input('size');
		$colour = $request->input('colour');
		$quantity = $request->input('quantity');

		$data = (object)[
			'exchangeEmail' =>$exchangeEmail,
			'orderNo' =>$orderNo,
			'productName' =>$productName,
			'size' =>$size,
			'colour' =>$colour,
			'quantity' =>$quantity,
		];

		/*$client = new Client();
		$res = $client->request('POST', 'http://localhost/mail/index.php', [
			'form_params' => [
				'cons' => 'exchangeReply',
				'emailFrom' => $exchangeEmail,
				'data' => $data
			]
		]);*/
		Mail::to($exchangeEmail)->send(new EmailExchangeReply($data));
		return redirect('meisjejongetje/commerce/exchange')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully response to this product.']);
	}

	public function others(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Others', 'path'=>'admin/commerce/others']
		];

		$member = new Member;
    $product = new Product;
		return view('admin/commerce/others/index', [
      'admin'=>$admin
      , 'others'=>$member->getOthers()[0]
      , 'breadCrumb'=>$breadCrumb
      , 'categories'=>$product->getAllProductCategory()
      , 'products'=>$product->getAllProduct2()
    ]);
	}
	public function submitOthers(Request $request)
	{
    if($request->file('categoryBanner') != null && $request->file('collectionBanner') != null && $request->file('hidCategoryBanner') != null && $request->file('hidCollectionBanner') != null)
    {
      return redirect('meisjejongetje/commerce/others')->with('message', (object)['type'=>'alert-danger', 'content'=>'Category banner and product banner cannot empty.']);
    }

    $destinationFile = "collection"; $imageTemp=array(); $imageTemp2=array();
    if($request->file('categoryBanner') == null){
      $imageTemp=$request->input('hidCategoryBanner');
    }else{
      $categoryImages = $request->file('categoryBanner');
      foreach($categoryImages as $image){
        if ($image->isValid()) {
          $extension = $image->getClientOriginalExtension();
          $filename = rand(11111111,99999999).'.'.$extension;
          $image->move($destinationFile, "col1".$filename);
          $imageTemp[]=$destinationFile."/col1".$filename;
        }
      }
      $imageTemp=implode(":",$imageTemp);
    }

    if($request->file('collectionBanner') == null){
      $imageTemp2=$request->input('hidCollectionBanner');
    }else{
      $collectionImages = $request->file('collectionBanner');
      foreach($collectionImages as $image){
        if ($image->isValid()) {
          $extension = $image->getClientOriginalExtension();
          $filename = rand(11111111,99999999).'.'.$extension;
          $image->move($destinationFile, "col2".$filename);
          $imageTemp2[]=$destinationFile."/col2".$filename;
        }
      }
      $imageTemp2=implode(":",$imageTemp2);
    }

		$member = new Member;
		$tax = ($request->input('tax') == '' ? 0 : $request->input('tax'));
		$arrival = ($request->input('arrival') == '' ? 0 : $request->input('arrival'));
		$submenuname = ($request->input('submenuname') == '' ? "Empty" : $request->input('submenuname'));
		$withbanner = ($request->input('use_banner') == '' ? 0 : 1);
		$method = $request->input('select_method');
		$category = $request->input('category');
		$products=implode(":",$request->input('product'));
		$collectionProducts=implode(":",$request->input('collectionProduct'));
		$member->submitOthers($tax, $arrival,$submenuname,$method,$category,$withbanner,$imageTemp,$products,$collectionProducts,$imageTemp2);
		return redirect('meisjejongetje/commerce/others')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this information.']);
	}
}
