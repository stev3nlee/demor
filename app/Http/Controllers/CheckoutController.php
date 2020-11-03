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
//use GuzzleHttp\Client;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOrder;
use App\Mail\EmailOrderAdmin;
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
			return ['success' => "not-member"];
		else
		{
			$flag = false;
			$info = $request->session()->get('cartinfo');
			$cart = $request->session()->get('cart');
			$vouchers = $request->input('voucher');
			foreach($cart as $c)
			{
				if($c->productDiscount != 0 && $vouchers != null)
				{
					$flag = true;
					break;
				}
			}
			if($info->Header->subtotal + $info->Header->tax - $vouchers["discount"] < 0)
			{
				$this->validationPush($validation, 'voucher', 'Order Total cannot be less than 0.');
			}
			else if($flag)
			{
				$this->validationPush($validation, 'voucher', 'Voucher cannot be used for Sale Products.');
			}
			else{
				$this->addDetailCart($request, $vouchers);
			}
			return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'vouchers' => $vouchers];
		}
	}
	public function checkout(Request $request)
	{
		$general = new General;
		$member = new Member;
		$all = $general->getAll($request);
		if($all->member == null)
			return view('checkout/checkout_login', [
				'general'=>$all,
			]);
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
		$state = ($country == '102' ? $request->input('state'):$request->input('state2'));
		$city = ($country == '102' ? $request->input('city'):$request->input('city2'));
		$zipcode = ($country == '102' ? $request->input('postcode'):$request->input('postcode2'));
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
			$bstate = ($bcountry == '102' ? $request->input('bstate'):$request->input('bstate2'));
			$bcity = ($bcountry == '102' ? $request->input('bcity'):$request->input('bcity2'));
			$bzipcode = ($bcountry == '102' ? $request->input('bpostcode'):$request->input('bpostcode2'));
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
		if($zipcode == '')
		{
			$this->validationPush($validation, 'postcode', 'Please fill in the billing ZIP code field.');
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
			if($bcountry == '')
			{
				$this->validationPush($validation, 'bcountry', 'Please fill in the shipping country field.');
			}
			if($bstate == '')
			{
				$this->validationPush($validation, 'bstate', 'Please fill in the shipping state field.');
			}
			if($bcity == '')
			{
				$this->validationPush($validation, 'bcity', 'Please fill in the shipping city field.');
			}
			if($baddress == '')
			{
				$this->validationPush($validation, 'baddress', 'Please fill in the shipping address field.');
			}
			if($bzipcode == '')
			{
				$this->validationPush($validation, 'bpostcode', 'Please fill in the shipping ZIP code field.');
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
			$general = new General;
			$cartcount = $general->getAll($request)->cartcount;
			$info = $request->session()->get('cartinfo');
			$shipping = 0;
			$response = '';
			if($bcountry == '102'){
				$wsdl="http://api.rpxholding.com/wsdl/rpxwsdl.php?wsdl";
				try {
					$client = new \SoapClient($wsdl);
					$username = "demorboutique";
					$password  = "demorrpxpsw";
					$account = "803335443";
					$result = $client->getRatesPostalCode($username,$password,'10340', $bzipcode, 'RGP', $cartcount, 0, 'JSON',$account);
					$shipping = json_decode($result)->RPX->DATA[0]->PRICE;

				}
				catch ( Exception $e ) {
					echo $e->getMessage();
				}
			}
			else
			{
				$member = new Member;
				$bcountryCode = $member->getCountryByCountryId($bcountry)[0]->sortname;
				$wsdl= "https://demorboutique.com/fedex/RateService_v26.wsdl";
				//dd($wsdl);
				//$wsdl= "https://ws.fedex.com:443/web-services";
				try {
					ini_set("soap.wsdl_cache_enabled", "0");
					$contextOptions = array(
					    'ssl' => array(
					        'verify_peer' => false,
					        'verify_peer_name' => false,
					        'allow_self_signed' => true,
					     )
					);
					$sslContext = stream_context_create($contextOptions);
					$client = new \SoapClient($wsdl, array('stream_context' => $sslContext));

					$request_fedex['WebAuthenticationDetail'] = array(
						'ParentCredential' => array(
							//'Key' => $this->getProperty('parentkey'),
						  	//'Password' => $this->getProperty('parentpassword')
						  	'Key' => $this->getProperty('key'),
						  	'Password' => $this->getProperty('password')
						),
						'UserCredential' => array(
							'Key' => $this->getProperty('key'),
							'Password' => $this->getProperty('password')
						)
					);
					$request_fedex['ClientDetail'] = array(
						'AccountNumber' => $this->getProperty('shipaccount'),
						'MeterNumber' => $this->getProperty('meter')
					);
					$request_fedex['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
					$request_fedex['Version'] = array(
						'ServiceId' => 'crs',
						'Major' => '26',
						'Intermediate' => '0',
						'Minor' => '0'
					);
					$request_fedex['ReturnTransitAndCommit'] = true;
					$request_fedex['RequestedShipment'] = array(
						'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
						'ShipTimestamp' => date('c'),
						'ServiceType' => 'INTERNATIONAL_ECONOMY',
						'PackagingType' => 'YOUR_PACKAGING',
						'TotalInsuredValue' =>array('Ammount'=>100, 'Currency'=>'USD'),
						'Shipper' => $this->addShipper(),
						'Recipient' => $this->addRecipient($bfname, $baddress, $bcountryCode, $bcity, $btelephoneNumber, $bzipcode),
						'ShippingChargesPayment' => $this->addShippingChargesPayment(),
						'PackageCount' => '1',
						'RequestedPackageLineItems' => $this->addPackageLineItem1($cartcount)
					);
					/*$request['RequestedShipment']['REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
					$request['RequestedShipment']['ShipTimestamp'] = date('c');
					$request['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_ECONOMY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
					$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...

					$request['RequestedShipment']['Shipper'] = $this->addShipper();
					$request['RequestedShipment']['Recipient'] = $this->addRecipient();
					$request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment();
					$request['RequestedShipment']['PackageCount'] = '1';
					$request['RequestedShipment']['RequestedPackageLineItems'] = $this->addPackageLineItem1();*/

					if($this->setEndpoint('changeEndpoint')){
						$newLocation = $client->__setLocation($this->setEndpoint('endpoint'));
					}
					// dd($request_fedex);
					$response = $client->getRates($request_fedex);
					//dd($response);
					if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
						$rateReply = $response -> RateReplyDetails;
						if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)){
							$shipping = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
						}elseif($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)){
							$shipping = $rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount;
						}
					}
					else
					{
						$this->validationPush($validation, 'postcode', 'The transaction returned a Failure.');
						$this->validationPush($validation, 'bpostcode', 'The transaction returned a Failure.');
					}
				}
				catch ( Exception $e ) {
					$this->validationPush($validation, 'postcode', 'Country or shipping ZIP code field is invalid.');
					$this->validationPush($validation, 'bpostcode', 'Country or shipping ZIP code field is invalid.');
				}
			}
			$info->Shipping = (object)["bfname"=>$bfname, "blname"=>$blname, "bemail"=>$bemail, "baddress"=>$baddress, "bcountry"=>$bcountry, "bstate"=>$bstate, "bcity"=>$bcity, "bzipcode"=>$bzipcode, "btelephoneNumber"=>$btelephoneNumber, "bmobileNumber"=>$bmobileNumber];
			$info->Billing = (object)["fname"=>$fname, "lname"=>$lname, "email"=>$email, "address"=>$address, "country"=>$country, "state"=>$state, "city"=>$city, "zipcode"=>$zipcode, "telephoneNumber"=>$telephoneNumber, "mobileNumber"=>$mobileNumber];
			$info->Header->shipping = $shipping+($shipping*1/100);
			$info->Header->note = $note;
			$request->session()->put('cartinfo', $info);
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}

	public function setEndpoint($var){
		if($var == 'changeEndpoint') Return false;
		if($var == 'endpoint') Return 'XXX';
	}

	public function addShipper(){
		$shipper = array(
			'Contact' => array(
				'PersonName' => 'Dewi Tuhepaly',
				'CompanyName' => 'Demor Boutique',
				'PhoneNumber' => '9012638716'
			),
			'Address' => array(
				'StreetLines' => array('Thamrin Residence', 'Jalan Teluk Betung 1, Thamrin'),
				'City' => 'Jakarta',
				'StateOrProvinceCode' => '',
				'PostalCode' => '10340',
				'CountryCode' => 'ID'
			)
		);
		return $shipper;
	}
	public function addRecipient($bname, $baddress, $bcountryCode, $bcity, $btelephoneNumber, $bzipcode){
		$recipient = array(
			'Contact' => array(
				'PersonName' => $bname,
				'CompanyName' => '',
				'PhoneNumber' => $btelephoneNumber
			),
			'Address' => array(
				'StreetLines' => array($baddress),
				'City' => $bcity,
				'StateOrProvinceCode' => '',
				'PostalCode' => $bzipcode,
				'CountryCode' => $bcountryCode,
				'Residential' => false
			)
		);
		return $recipient;
	}
	public function addShippingChargesPayment(){
		$shippingChargesPayment = array(
			'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
			'Payor' => array(
				'ResponsibleParty' => array(
					'AccountNumber' => $this->getProperty('billaccount'),
					'CountryCode' => 'ID'
				)
			)
		);
		return $shippingChargesPayment;
	}
	public function addPackageLineItem1($weight){
		$packageLineItem = array(
			'SequenceNumber'=>1,
			'GroupPackageCount'=>1,
			'Weight' => array(
				'Value' => $weight,
				'Units' => 'KG'
			)
			/*,'Dimensions' => array(
				'Length' => 30,
				'Width' => 25,
				'Height' => 7,
				'Units' => 'IN'
			)*/
		);
		return $packageLineItem;
	}

	public function getProperty($var){
		//if($var == 'key') Return 'RgkF85Kf8yMjBXud';
		if($var == 'key') Return 'NZ4aa3mxYC5D0VJZ';
		if($var == 'password') Return 'MrvjKr7uaE5hyRazCIEqtmTg4';
		if($var == 'shipaccount') Return '803335443';
		if($var == 'billaccount') Return '803335443';
		if($var == 'dutyaccount') Return '803335443';
		if($var == 'freightaccount') Return '803335443';
		if($var == 'trackaccount') Return '803335443';
		if($var == 'dutiesaccount') Return '803335443';
		if($var == 'importeraccount') Return '803335443';
		if($var == 'brokeraccount') Return '803335443';
		if($var == 'distributionaccount') Return '803335443';
		if($var == 'locationid') Return 'PLBA';
		if($var == 'printlabels') Return false;
		if($var == 'printdocuments') Return true;
		if($var == 'packagecount') Return '4';
		
		//if($var == 'meter') Return '110603058';
		if($var == 'meter') Return '250594808';

		if($var == 'shiptimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));

		if($var == 'spodshipdate') Return '2014-07-21';
		if($var == 'serviceshipdate') Return '2017-07-26';

		if($var == 'readydate') Return '2014-07-09T08:44:07';
		//if($var == 'closedate') Return date("Y-m-d");
		if($var == 'closedate') Return '2014-07-17';
		if($var == 'pickupdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
		if($var == 'pickuptimestamp') Return mktime(8, 0, 0, date("m")  , date("d")+1, date("Y"));
		if($var == 'pickuplocationid') Return 'XXX';
		if($var == 'pickupconfirmationnumber') Return '1';

		if($var == 'dispatchdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
		if($var == 'dispatchlocationid') Return 'XXX';
		if($var == 'dispatchconfirmationnumber') Return '1';

		if($var == 'tag_readytimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));
		if($var == 'tag_latesttimestamp') Return mktime(20, 0, 0, date("m"), date("d")+1, date("Y"));

		if($var == 'expirationdate') Return date("Y-m-d", mktime(8, 0, 0, date("m"), date("d")+15, date("Y")));
		if($var == 'begindate') Return '2014-07-22';
		if($var == 'enddate') Return '2014-07-25';

		if($var == 'trackingnumber') Return 'XXX';

		if($var == 'hubid') Return '5531';

		if($var == 'jobid') Return 'XXX';

		if($var == 'searchlocationphonenumber') Return '5555555555';
		if($var == 'customerreference') Return 'Cust_Reference';

		if($var == 'shipper') Return array(
			'Contact' => array(
				'PersonName' => 'Sender Name',
				'CompanyName' => 'Sender Company Name',
				'PhoneNumber' => '1234567890'
			),
			'Address' => array(
				'StreetLines' => array('Address Line 1'),
				'City' => 'Collierville',
				'StateOrProvinceCode' => 'TN',
				'PostalCode' => '38017',
				'CountryCode' => 'US',
				'Residential' => 1
			)
		);
		if($var == 'recipient') Return array(
			'Contact' => array(
				'PersonName' => 'Recipient Name',
				'CompanyName' => 'Recipient Company Name',
				'PhoneNumber' => '1234567890'
			),
			'Address' => array(
				'StreetLines' => array('Address Line 1'),
				'City' => 'Herndon',
				'StateOrProvinceCode' => 'VA',
				'PostalCode' => '20171',
				'CountryCode' => 'US',
				'Residential' => 1
			)
		);

		if($var == 'address1') Return array(
			'StreetLines' => array('10 Fed Ex Pkwy'),
			'City' => 'Memphis',
			'StateOrProvinceCode' => 'TN',
			'PostalCode' => '38115',
			'CountryCode' => 'US'
		);
		if($var == 'address2') Return array(
			'StreetLines' => array('13450 Farmcrest Ct'),
			'City' => 'Herndon',
			'StateOrProvinceCode' => 'VA',
			'PostalCode' => '20171',
			'CountryCode' => 'US'
		);
		if($var == 'searchlocationsaddress') Return array(
			'StreetLines'=> array('240 Central Park S'),
			'City'=>'Austin',
			'StateOrProvinceCode'=>'TX',
			'PostalCode'=>'78701',
			'CountryCode'=>'US'
		);

		if($var == 'shippingchargespayment') Return array(
			'PaymentType' => 'SENDER',
			'Payor' => array(
				'ResponsibleParty' => array(
					'AccountNumber' => $this->getProperty('billaccount'),
					'Contact' => null,
					'Address' => array('CountryCode' => 'US')
				)
			)
		);
		if($var == 'freightbilling') Return array(
			'Contact'=>array(
				'ContactId' => 'freight1',
				'PersonName' => 'Big Shipper',
				'Title' => 'Manager',
				'CompanyName' => 'Freight Shipper Co',
				'PhoneNumber' => '1234567890'
			),
			'Address'=>array(
				'StreetLines'=>array(
					'1202 Chalet Ln',
					'Do Not Delete - Test Account'
				),
				'City' =>'Harrison',
				'StateOrProvinceCode' => 'AR',
				'PostalCode' => '72601-6353',
				'CountryCode' => 'US'
				)
		);
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
			$m = new Member;
			$all = $general->getAll($request);
			$data=(object)[
				"bcountry"=>$m->getCountryByCountryId($all->cartinfo->Billing->country)
				,"bstate"=>$m->getStateByStateId($all->cartinfo->Billing->state)
				,"bcity"=>$m->getCityByCityId($all->cartinfo->Billing->city)
				,"scountry"=>$m->getCountryByCountryId($all->cartinfo->Shipping->bcountry)
				,"sstate"=>$m->getStateByStateId($all->cartinfo->Shipping->bstate)
				,"scity"=>$m->getCityByCityId($all->cartinfo->Shipping->bcity)
			];

			return view('checkout/checkout_confirm', [
				'general'=>$all,"data"=>$data
			]);
		}
	}

	public function checkoutTransferSubmit(Request $request)
	{
		$general = new General;
		$payment = new Member;
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
				'orderdetail' =>$order->getOrderDetail($lastno),
				'orderinfo'=>$order->getOrderInfo($lastno)
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
					'cons' => 'orderAdmin',
					'emailFrom' => 'cs@demorboutique.com',
					'data' => $data
				]
			]);*/
			Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data,$payment->getAllBanks()));
			//Mail::to('cs@demorboutique.com')->send(new EmailOrderAdmin($data));
			//Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrderAdmin($data));
			$request->session()->forget('cart');
			$request->session()->forget('cartinfo');

			return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'orderNo' => $lastno];
		}
	}

	//fortesting
	public function checkoutTransferSubmitTestingEmail(Request $request,$lastno)
	{
		$general = new General;
		$payment = new Member;
		$order = new Order;
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($lastno),
			'orderdetail' =>$order->getOrderDetail($lastno),
			'orderinfo'=>$order->getOrderInfo($lastno)
		];
		Mail::to('rosamanullang@gmail.com')->send(new EmailOrder($data,$payment->getAllBanks()));
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
			// Production
			Veritrans::$serverKey = 'VT-server-kut3O0ypgj_KCUnzNqEPV2k4';
			Veritrans::$isProduction = true;

			// Sandbox
			//Veritrans::$serverKey = 'VT-server-mY8kguFS9pW-i2_5uxZ6OrUO';
			//Veritrans::$isProduction = false;
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
			//$lastno = date("dmy").'022';
			$cartInfo = $request->session()->get('cartinfo');
			$cartInfo->Header->conveniencefee = (($all->cartinfo->Header->subtotal - $all->cartinfo->Header->vouchernominal + $all->cartinfo->Header->shipping + $all->cartinfo->Header->tax) * 3.2 / 100) + 3000;
			//var_dump($cartInfo);
			$request->session()->put('cartinfo', $cartInfo);

			$all = $general->getAll($request);

			/*rian fix Bug Missing session*/
			$this->setTempSession($request,$lastno);
			/*End*/
			$transaction_details = array(
				'order_id'      => $lastno,
				'gross_amount'  => ceil($all->cartinfo->Header->subtotal - $all->cartinfo->Header->vouchernominal + $all->cartinfo->Header->shipping + $all->cartinfo->Header->tax + $all->cartinfo->Header->conveniencefee)
			);
			// Populate items
			$items = [];
			foreach($all->cart as $cart)
			{
				$item = array(
					'id'       => $cart->productId,
					'price'    => $cart->productPrice*$cart->productQuantity,
					'quantity' => 1,
					'name'     => $cart->productName
				);
				array_push($items, $item);
			}
			$tempItem = array(
					'id'       => 'footer',
					'price'    => ceil(- $all->cartinfo->Header->vouchernominal + $all->cartinfo->Header->shipping + $all->cartinfo->Header->tax + $all->cartinfo->Header->conveniencefee),
					'quantity' => 1,
					'name'     => 'Total Services'
				);
			array_push($items, $tempItem);
			/*$tempItem = array(
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
			array_push($items, $tempItem);*/
			// Populate customer's billing address
			$billing_address = array(
				'first_name'        => $all->cartinfo->Billing->fname,
				'last_name'         => $all->cartinfo->Billing->lname,
				'address'           => $all->cartinfo->Billing->address,
				'city'              => '',
				'postal_code'       => $all->cartinfo->Billing->zipcode,
				'phone'             => $all->cartinfo->Billing->mobileNumber,
				'country_code'      => 'IDN'
				);
			// Populate customer's shipping address
			$shipping_address = array(
				'first_name'        => $all->cartinfo->Shipping->bfname,
				'last_name'         => $all->cartinfo->Shipping->blname,
				'address'           => $all->cartinfo->Shipping->baddress,
				'city'              => '',
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
					'enabled_payments'    => array("credit_card"),
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

	public function VtWebNotification()
    {
		/*Veritrans::$serverKey = 'VT-server-mY8kguFS9pW-i2_5uxZ6OrUO';
		Veritrans::$isProduction = false;
		$notif = new Veritrans_Notification();

        $transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

        if($result){
			$notif = $vt->status($result->order_id);
			var_dump($notif);
        }
*/
        //error_log(print_r($result,TRUE));

        /*
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
          // For credit card transaction, we need to check whether transaction is challenge by FDS or not
          if ($type == 'credit_card'){
            if($fraud == 'challenge'){
              // TODO set payment status in merchant's database to 'Challenge by FDS'
              // TODO merchant should decide whether this transaction is authorized or not in MAP
              echo "Transaction order_id: " . $order_id ." is challenged by FDS";
              }
              else {
              // TODO set payment status in merchant's database to 'Success'
              echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
              }
            }
          }
        else if ($transaction == 'settlement'){
          // TODO set payment status in merchant's database to 'Settlement'
          echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
          }
          else if($transaction == 'pending'){
          // TODO set payment status in merchant's database to 'Pending'
          echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
          }
          else if ($transaction == 'deny') {
          // TODO set payment status in merchant's database to 'Denied'
          echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }*/
    }

	public function checkoutVtWebSuccess(Request $request)
	{
		$orderid = $request->input('order_id');
		$statuscode = $request->input('status_code');
		$transactionstatus = $request->input('transaction_status');

		$order = new Order;

		$general = new General;
		$all = $general->getAll($request);

		if($all->member == null){
			/*rian fixing bug missing session*/
			$this->restoreSession($request,$orderid);
			$all = $general->getAll($request);
			/*return ['success' => false, 'msg'=>'login gagal'];*/
			/*end rian*/
		}
		else if($statuscode != 200 || $transactionstatus != 'capture')
		{
			return ['success' => false, 'msg'=>$statuscode.' '.$transactionstatus];
		}
		else if(count($order->getOrderHeader($orderid)) > 0)
		{
			return ['success' => false, 'msg'=>'this order already generated.'];
		}

		$order = new Order;
		$validation = [];
		$lastno = $orderid;
		$order->insertOrder($lastno, $all, 'VT Web');
		$data = (object)[
			'orderheader' =>$order->getOrderHeader($lastno),
			'orderdetail' =>$order->getOrderDetail($lastno),
			'orderinfo'=>$order->getOrderInfo($lastno)
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
				'cons' => 'orderAdmin',
				'emailFrom' => 'cs@demorboutique.com',
				'data' => $data
			]
		]);*/

		Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrder($data));
		Mail::to('cs@demorboutique.com')->send(new EmailOrderAdmin($data));

		$request->session()->forget('cart');
		$request->session()->forget('cartinfo');
		return redirect('checkout/transfersuccess/'.$lastno);

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
		$general = new General;
		$all = $general->getAll($request);

		$v = [];
		$voucher = $request->input('voucher');

		$vouchers = $member->getVoucherByName($voucher);
		if(count($vouchers) == 0)
		{
			$this->validationPush($validation, 'voucher', 'The voucher is not existed or has expired.');
		}
		else if($all->member == null)
			return ['success' => "not-member"];

		if(count($validation) == 0){
			$v = $vouchers[0];
		}

		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation, 'vouchers' => $v];
	}

	public function addToCart(Request $request)
	{
		$validation = [];
		$productId = $request->input('productId');
		$productCode = $request->input('productCode');
		$productName = $request->input('productName');
		$productPrice = $request->input('productPrice');
		$productDiscount = $request->input('productDiscount');
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
			"productDiscount"=>$productDiscount,
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
		return ['success' => (count($validation) == 0 ? true : false), 'cart'=>$carts, 'info'=>$info];
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

	/*rian fix missing session*/
	private function setTempSession($request,$orderNo)
	{
		$order = new Order;
		if(count($order->getTempOrderNo($orderNo)) > 0){
			$order->deleteTempOrderNo($orderNo);
		}
		$popup = json_encode($request->session()->get('popup'));
		$cart = json_encode($request->session()->get('cart'));
		$cartinfo = json_encode($request->session()->get('cartinfo'));
		$member = json_encode($request->session()->get('member'));

		$order->insertTempOrder($orderNo,$cart,$cartinfo,$member,$popup);
	}

	private function restoreSession($request,$orderid)
	{
		$order = new Order;
		$tempOrder = $order->getTempOrderNo($orderid)[0];
		$request->session()->put("cart",json_decode($tempOrder->cart));
		$request->session()->put("cartinfo",json_decode($tempOrder->cartinfo));
		$request->session()->put("member",json_decode($tempOrder->member));
		$request->session()->put("popup",json_decode($tempOrder->popup));
		$order->deleteTempOrderNo($orderid);
		$request->session()->save();
		return;
	}
	/*end rian*/
}
