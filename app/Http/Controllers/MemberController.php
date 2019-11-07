<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\General;
use App\Http\Models\Member;
use App\Http\Models\Order;
use App\Http\Models\Converter;
//use GuzzleHttp\Client;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOrder;
use App\Mail\EmailConfirmPaymentAdmin;
use App\Mail\EmailConfirmExchangeAdmin;

class MemberController extends Controller
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
	public function validateAlpha($str)
	{
		$v = "/^\pL+$/u";
		return (bool)preg_match($v, $str);
	}

	//tambahkan route untuk confirm_exchange
	public function confirmPaymentShipping(Request $request)
	{
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		return view('member/confirm_exchange', ['general'=>$all, 'banks'=>$member->getAllPublishBanks()]);
	}

    public function index(Request $request)
    {
		$general = new General;
		$member = new Member;

		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$mmbr = $member->getMemberByEmail($all->member->email)[0];
        return view('member/personal', [
			'general'=>$all,
			'member'=>$mmbr,
			'countries'=>$member->getAllCountry(),
			'states'=>$member->getStateById($mmbr->country),
			'cities'=>$member->getCityById($mmbr->state),
			'postalcodes'=>$member->getPostCodeById($mmbr->city)
		]);
    }
	public function getState(Request $request, $country)
	{
		$general = new General;
		$member = new Member;

		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		return ['success' =>  true, 'states' => $member->getStateById($country)];
	}
	public function getCity(Request $request, $state)
	{
		$general = new General;
		$member = new Member;

		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		return ['success' =>  true, 'cities' => $member->getCityById($state)];
	}
	public function getPostCode(Request $request, $city)
	{
		$general = new General;
		$member = new Member;

		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		return ['success' =>  true, 'postcodes' => $member->getPostCodeById($city)];
	}

	public function submitPersonal(Request $request)
	{
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$member = new Member;
		$validation = [];

		$id = $request->input('id');
		$firstName = $request->input('firstName');
		$lastName = $request->input('lastName');
		$email = $request->input('email');
		$date = $request->input('date');
		$month = $request->input('month');
		$year = $request->input('year');
		$gender = $request->input('gender');
		$country = $request->input('country');
		$city = ($country == '102' ? $request->input('city'):$request->input('city2'));
		$state = ($country == '102' ? $request->input('state'):$request->input('state2'));
		$postcode = ($country == '102' ? $request->input('postcode'):$request->input('postcode2'));
		$address = $request->input('address');
		$telphoneNumber = $request->input('telphoneNumber');
		$mobileNumber = $request->input('mobileNumber');

		if($firstName == '')
		{
			$this->validationPush($validation, 'firstName', 'Please fill in the first name field.');
		}
		else if(!$this->validateAlpha($firstName))
		{
			$this->validationPush($validation, 'firstName', 'First name field contains alphabet only.');
		}
		if($lastName == '')
		{
			$this->validationPush($validation, 'lastName', 'Please fill in the last name field.');
		}
		else if(!$this->validateAlpha($lastName))
		{
			$this->validationPush($validation, 'lastName', 'Last name field contains alphabet only.');
		}
		if($country == '')
		{
			$this->validationPush($validation, 'country', 'Please fill in the country field.');
		}
		if($state == '')
		{
			$this->validationPush($validation, 'state', 'Please fill in the state field.');
		}
		if($city == '')
		{
			$this->validationPush($validation, 'city', 'Please fill in the city field.');
		}
		if($address == '')
		{
			$this->validationPush($validation, 'address', 'Please fill in the billing address field.');
		}
		if($postcode == '')
		{
			$this->validationPush($validation, 'postcode', 'Please fill in the billing ZIP code field.');
		}
		if($telphoneNumber == '')
		{
			$this->validationPush($validation, 'telphoneNumber', 'Please fill in the telephone number field.');
		}
		if($mobileNumber == '')
		{
			$this->validationPush($validation, 'mobileNumber', 'Please fill in the mobile number field.');
		}

		if(count($validation) == 0){
			$member->updateMember($id, $firstName, $lastName, $email, $date.'/'.$month.'/'.$year, $gender, $country, $city, $state, $postcode, $address, $telphoneNumber, $mobileNumber);
			$mmbr = $all->member;
			$mmbr->fullname = $firstName .' '. $lastName;

			$request->session()->put('member', $mmbr);
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
    public function changePassword(Request $request)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

        return view('member/changepassword', ['general'=>$all]);
    }
	public function submitChangePassword(Request $request)
	{
		$member = new Member;
		$validation = [];

		$id = $request->input('id');
		$oldPassword = $request->input('oldPassword');
		$newPassword = $request->input('newPassword');
		$confirmPassword = $request->input('confirmPassword');

		if($oldPassword == '')
		{
			$this->validationPush($validation, 'oldPassword', 'Please fill in the old password field.');
		}
		else if(count($member->isOldPassword($id, $oldPassword)) == 0)
		{
			$this->validationPush($validation, 'oldPassword', 'You need to input the correct old password.');
		}
		if($newPassword == '')
		{
			$this->validationPush($validation, 'newPassword', 'Please fill in the new password field.');
		}
		else if(strlen($newPassword) < 8 || strlen($newPassword) > 12)
		{
			$this->validationPush($validation, 'newPassword', 'Please insert the password length between 8 and 12 for all characters.');
		}
		if($confirmPassword == '')
		{
			$this->validationPush($validation, 'confirmPassword', 'Please fill in the confirmation password field.');
		}
		else if($newPassword != $confirmPassword)
		{
			$this->validationPush($validation, 'confirmPassword', 'New password and confirmation password does not match.');
		}

		if(count($validation) == 0){
			$member->updatePassword($id, $newPassword);
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
    public function confirmPayment(Request $request)
    {
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/login/confirmpayment');

        return view('member/confirmpayment', ['general'=>$all, 'banks'=>$member->getAllPublishBanks()]);
    }
    public function submitConfirmPayment(Request $request)
    {
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$orderNo = $request->input('orderNo');
		$accountNo = $request->input('accountNo');
		$accountName = $request->input('accountName');
		$paymentTo = $request->input('paymentTo');
		$totalAmmount = $request->input('totalAmmount');
		$pictureEvidence = $request->file('pictureEvidence');
		$picturePath='';
		if($pictureEvidence != null){
			if ($pictureEvidence->isValid()) {
				$destinationFile = "productimage/transfer/";
				$extension = $pictureEvidence->getClientOriginalExtension();
				$filename = rand(11111111,99999999).'.'.$extension;
				$pictureEvidence->move($destinationFile, $filename);
				$picturePath = $destinationFile.$filename;
			}
			$order = new Order;
			$member->confirmPayment($orderNo, $accountNo, $accountName, $paymentTo, $totalAmmount, $picturePath);
			$data = (object)[
				'orderheader' =>$order->getOrderHeader($orderNo),
				'orderdetail' =>$order->getOrderDetail($orderNo),
				'orderinfo'=>$order->getOrderInfo($orderNo),
				'paymentto' =>$order->getOrderPaymentTo($orderNo)
			];
			/*$client = new Client();
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'order',
					'emailFrom' => $data->orderheader[0]->memberemail,
					'data' => $data
				]
			]);
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'orderConfirmPayment',
					'emailFrom' => 'frankykwek@gmail.com',
					'data' => $data
				]
			]);*/
			Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data));
			Mail::to('cs@demorboutique.com')->send(new EmailConfirmPaymentAdmin($data));
			//Mail::to($data->orderheader[0]->memberemail)->send(new EmailConfirmPaymentAdmin($data));
		}
		return redirect('member/confirmpayment');
    }
	public function submitConfirmExchange(Request $request)
    {
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$orderNo = $request->input('orderNo');
		$accountNo = $request->input('accountNo');
		$accountName = $request->input('accountName');
		$paymentTo = $request->input('paymentTo');
		$totalAmmount = $request->input('totalAmmount');
		$pictureEvidence = $request->file('pictureEvidence');
		$picturePath='';
		if($pictureEvidence != null){
			if ($pictureEvidence->isValid()) {
				$destinationFile = "productimage/transfer/";
				$extension = $pictureEvidence->getClientOriginalExtension();
				$filename = rand(11111111,99999999).'.'.$extension;
				$pictureEvidence->move($destinationFile, $filename);
				$picturePath = $destinationFile.$filename;
			}
			$order = new Order;
			$member->confirmExchange($orderNo, $accountNo, $accountName, $paymentTo, $totalAmmount, $picturePath);
			$data = (object)[
				'orderheader' =>$order->getOrderHeader($orderNo),
				'orderpayment' =>$order->getOrderPayment($orderNo)[0],
				'paymentto' =>$order->getOrderPaymentExchangeTo($orderNo)
			];
			//Mail::to($data->orderheader[0]->memberemail)->send(new EmailConfirmExchangeAdmin($data));
			Mail::to('cs@demorboutique.com')->send(new EmailConfirmExchangeAdmin($data));
		}
		return redirect('member/confirmpaymentshipping');
    }
    public function validateConfirmPayment(Request $request)
    {
		$general = new General;
		$member = new Member;
		$order = new Order;
		$validation = [];
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$orderNo = $request->input('orderNo');
		$accountNo = $request->input('accountNo');
		$accountName = $request->input('accountName');
		$paymentTo = $request->input('paymentTo');
		$totalAmmount = $request->input('totalAmmount');
		$pictureEvidence = $request->file('pictureEvidence');
		$exchange = $request->input('isexchange');
		$exchange = !isset($exchange);

		if($orderNo == '')
		{
			$this->validationPush($validation, 'orderNo', 'Please fill in order number field.');
		}
		else if(count($order->getPendingOrderByUser($all->member->userid, $orderNo)) == 0 && $exchange)
		{
			$this->validationPush($validation, 'orderNo', 'Order Number is not found.');
		}
		else if(count($order->getDetailOrderByUser($all->member->userid, $orderNo)) == 0 && !$exchange)
		{
			$this->validationPush($validation, 'orderNo', 'Order Number is not found.');
		}
		if($accountNo == '')
		{
			$this->validationPush($validation, 'accountNo', 'Please fill in the account number field.');
		}
		if($accountName == '')
		{
			$this->validationPush($validation, 'accountName', 'Please fill in the account name field.');
		}
		if($paymentTo == '')
		{
			$this->validationPush($validation, 'paymentTo', 'Please select the payment you are sending to.');
		}
		if($totalAmmount == '')
		{
			$this->validationPush($validation, 'totalAmmount', 'Please fill in the total amount in the field.');
		}

		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
    }
    public function newsletter(Request $request)
    {
		$general = new General;
		$all = $general->getAll($request);
		//rian
		$issubscribe = $general->getSubscriber($all->member->email);
		//endirian
		if($all->member == null) return redirect('/');

			//rian return view('member/newsletter', ['general'=>$all]);
      return view('member/newsletter', ['general'=>$all,'issubscribe'=>$issubscribe]);
    }
    public function order(Request $request)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$order = new Order;
		$converter = new Converter;

		$orders = $order->getOrderHeaderByUser($all->member->userid);
		foreach($orders as $o)
		{
			$o->insertdate = $converter->dateFormat($o->insertdate);
			$o->updatedate = $converter->dateFormat($o->updatedate);
		}
        return view('member/order', ['general'=>$all, 'orders'=>$orders]);
    }

	public function exchangeDetail(Request $request, $id)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$orderNo = $id;
		$order = new Order;
		$converter = new Converter;
		$permit = $order->getOrderPermit($orderNo);
		if(count($permit) != 0){
			$permit = $permit[0];
			$permit->permitdetail = $order->getOrderPermitDetail($orderNo);
		}
		$notpermit = $order->getOrderNotPermit($orderNo);
		if(count($notpermit) != 0){
			$notpermit = $notpermit[0];
		}
		$refund = $order->getOrderRefund($orderNo);
        return view('member/order_refund', ['general'=>$all, 'permit'=>$permit, 'notpermit'=>$notpermit, 'refund'=>$refund]);
    }

    public function viewOrder(Request $request, $id)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

		$order = new Order;

		$orderheader = $order->getDetailOrderByUser($all->member->userid, $id);
		if(count($orderheader) == 0) return redirect('/');
        return view('member/orderdetail', [
			'general'=>$all,
			'orderheader'=>$orderheader[0],
			'orderinfo'=>$order->getOrderInfo($id),
			'orderdetail'=>$order->getOrderDetail($id),
		]);
    }
    public function orderHistoryBankTransfer(Request $request)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

        return view('member/orderhistorybanktransfer', ['general'=>$all]);
    }
    public function orderHistoryCreditCard(Request $request)
    {
		$general = new General;
		$all = $general->getAll($request);
		if($all->member == null) return redirect('/');

        return view('member/orderhistorycreditcard', ['general'=>$all]);
    }
}
