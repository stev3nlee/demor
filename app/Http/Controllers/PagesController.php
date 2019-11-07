<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\General;
use App\Http\Models\Page;
use GuzzleHttp\Client;
/*Rian*/
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailContact;
use App\Mail\EmailExchange;
use App\Mail\EmailAdminExchange;
use App\Mail\EmailAdminContact;
/*end Rian */
class PagesController extends Controller
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
	public function showPopup()
	{
		$page = new Page;
		return view('pop-index')->with(["popup"=>$page->getPopup()[0]]);
	}
	public function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

    public function contact(Request $request)
    {
		$general = new General;
		$page = new Page;
        return view('contact', ['general'=>$general->getAll($request), 'contact'=>$page->getContact()[0]]);
    }
    public function addContact(Request $request)
    {
		$page = new Page;
		$validation = [];
		$name = $request->input('name');
		$email = $request->input('email');
		$subject = $request->input('subject');
		$messages = $request->input('messages');
		$captcha = $request->input('g-recaptcha-response');

		if($name == '')
		{
			$this->validationPush($validation, 'name', 'Please fill in the name field.');
		}
		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the email address field.');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address.');
		}
		if($messages == '')
		{
			$this->validationPush($validation, 'messages', 'Please fill in the messages field.');
		}
		if($captcha == '')
		{
			$this->validationPush($validation, 'captcha', 'Please tick if you are not robot.');
		}

		if(count($validation) == 0){
			$page->addMessages($name, $email, $subject, $messages);
			$data = (object)[
				'name' =>$name,
				'email' =>$email,
				'subject' =>$subject,
				'messages' =>$messages
			];
			Mail::to('cs@demorboutique.com')->send(new EmailAdminContact($data));
			//Mail::to($email)->send(new EmailAdminContact($data));
			Mail::to($email)->send(new EmailContact());
		}
        return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
    }

    public function working(Request $request)
    {
		$general = new General;
		$page = new Page;

		return view('working', ['general'=>$general->getAll($request), 'career'=>$page->getCareer()[0], 'detailCareers'=>$page->getDetailPublishCareer()]);
    }
    public function about(Request $request)
    {
		$general = new General;
		$page = new Page;

		return view('about', ['general'=>$general->getAll($request), 'page'=>$page->getPagesById(1)[0]]);
    }
    public function termConditions(Request $request)
    {
		$general = new General;
		$page = new Page;

		return view('terms', ['general'=>$general->getAll($request), 'page'=>$page->getPagesById(5)[0]]);
    }
    public function shippingExchange(Request $request)
    {
		$general = new General;
		$page = new Page;

		return view('shipping', ['general'=>$general->getAll($request), 'exchange'=>$page->getPagesById(2)[0], 'shipping'=>$page->getPagesById(3)[0]]);
    }
	public function submitExchange(Request $request)
	{
		$page = new Page;
		$validation = [];

		$fullName = $request->input('fullName');
		$emailAddress = $request->input('emailAddress');
		$invoiceNumber = $request->input('invoiceNumber');
		$productName = $request->input('productName');
		$detailProduct = $request->input('detailProduct');
		$reason = $request->input('reason');
		$captcha = $request->input('g-recaptcha-response');

		if($fullName == '')
		{
			$this->validationPush($validation, 'fullName', 'Please fill in the full name field.');
		}
		if($emailAddress == '')
		{
			$this->validationPush($validation, 'emailAddress', 'Please fill in the email address field.');
		}
		else if(!$this->validateEmail($emailAddress))
		{
			$this->validationPush($validation, 'emailAddress', 'Please enter a valid email address.');
		}
		if($invoiceNumber == '')
		{
			$this->validationPush($validation, 'invoiceNumber', 'Please fill in the order number field.');
		}
		if($productName == '')
		{
			$this->validationPush($validation, 'productName', 'Please fill in the product name field.');
		}
		if($detailProduct == '')
		{
			$this->validationPush($validation, 'detailProduct', 'Please fill in the product details field.');
		}
		if($reason == '')
		{
			$this->validationPush($validation, 'reason', 'Please fill in the reason field.');
		}
		if($captcha == '')
		{
			$this->validationPush($validation, 'captcha', 'Please tick if you are not robot.');
		}

		if(count($validation) == 0){
			$page->submitExchange($fullName, $emailAddress, $invoiceNumber, $productName, $detailProduct, $reason);

			$data = (object)[
				'fullName' =>$fullName,
				'emailAddress' =>$emailAddress,
				'invoiceNumber' =>$invoiceNumber,
				'productName' =>$productName,
				'detailProduct' =>$detailProduct,
				'reason' =>$reason,
			];
			Mail::to('cs@demorboutique.com')->send(new EmailAdminExchange($data));
			Mail::to($emailAddress)->send(new EmailExchange());
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
    public function privacyPolicy(Request $request)
    {
		$general = new General;
		$page = new Page;

		return view('privacy', ['general'=>$general->getAll($request), 'page'=>$page->getPagesById(4)[0]]);
    }
	public function viewBlog(Request $request)
	{
		$general = new General;
		$page = new Page;

		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>"World of De'mor", 'path'=>''],
		];

		$demors = $page->getAllDetailBlogList();
		foreach($demors as $demor)
		{
			if($demor->method == 'select-slider')
				$demor->filepath = $page->getDetailBlogListById($demor->blogid);
		}

		return view('worldofdemor', ['general'=>$general->getAll($request), 'demors'=>$demors, 'breadCrumb'=>$breadCrumb]);
	}
	public function viewBlogById(Request $request, $id)
	{
		$general = new General;
		$page = new Page;

		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>"World of De'mor", 'path'=>'pages/blog'],
			(object)['name' =>$page->getBlogCategoryById($id)[0]->categoryname, 'path'=>'']
		];

		$demors = $page->getCategoryDetailBlogList($id);

		foreach($demors as $demor)
		{
			if($demor->method == 'select-slider')
				$demor->filepath = $page->getDetailBlogListById($demor->blogid);
		}

		return view('worldofdemor', ['general'=>$general->getAll($request), 'demors'=>$demors, 'breadCrumb'=>$breadCrumb]);
	}
}
