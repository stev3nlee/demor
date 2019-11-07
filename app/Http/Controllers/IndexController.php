<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\General;
use App\Http\Models\Page;
use App\Http\Models\Product;
use App\Http\Models\Member;

class IndexController extends Controller
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

    public function index(Request $request)
    {
		$general = new General;
		$page = new Page;
		$product = new Product;
		$member = new Member;
		$other = $member->getOthers()[0];
        return view('index', [
			'general'=>$general->getAll($request),
			'sliders'=>$page->getAllActiveSlider(),
			/*rian 20170616*/
			'popup'=>$page->getPopup()[0],
			/*end rian*/
			//'populars'=>$product->getPopularSample(),
			'populars'=>($other->method == 1 ? $product->getPopularSampleByCategoryId($other->categoryid) : ($other->method == 2 ? $product->getPopularSampleByProductId(explode(":",$other->productid)) : "" )) ,
			'arrivals'=>$product->getArrivalSample(),
			'others'=>$other,
		]);
    }

	public function submitNewsletter(Request $request)
	{
		$page = new Page;
		$email = $request->input('email');
		$validation = [];

		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the email address field.');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address.');
		}
		else if(count($page->getNewsLetterEmail($email)) != 0)
		{
			$this->validationPush($validation, 'email', 'The email address has already been taken.');
		}
		else{
			$page->insertNewsLetterEmail($email);
		}

		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}

	//rian
	public function submitNewsletter2(Request $request)
	{
		$page = new Page;
		$email = $request->input('email');
		$page->insertNewsLetterEmail($email);
		return redirect()->back();
	}

	public function deleteNewsletter(Request $request)
	{
		$page = new Page;
		$email = $request->input('email');
		$page->deleteNewsletterByEmail($email);
		return redirect()->back();
	}
	//endrian
}
