<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\General;
use App\Http\Models\Member;

use GuzzleHttp\Client;
/*rian*/
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailForgotPassword;
use App\Mail\EmailRegister;
/*end rian*/
class LoginController extends Controller
{
    public function index(Request $request)
    {
		$general = new General;
        return view('login', ['general'=>$general->getAll($request)]);
    }
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
	public function validateAlpha($str)
	{
		$v = "/^\pL+$/u";
		return (bool)preg_match($v, $str);
	}
	public function doLogin(Request $request,$isconfirmpaymet="")
	{
		$member = new Member;
		$general = new General;
		$validation = [];

		$email = $request->input('email');
		$password = $request->input('password');

		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the email address field..');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address.');
		}
		if($password == '')
		{
			$this->validationPush($validation, 'password', 'Please fill in the password field.');
		}
		if(count($validation) == 0){
			$users = $member->doLogin($email, $password);
			if(count($users) != 1)
			{
				$this->validationPush($validation, 'password', '<br>The email address or password is invalid.');
			}
			else if($users[0]->active == 0)
			{
				$this->validationPush($validation, 'password', 'Please activate your account in your email');
			}
		}

		if(count($validation) == 0){
			$member = (object)["userid"=>$users[0]->userid, "email" => $users[0]->emailaddress, "fullname" => $users[0]->firstname.' '.$users[0]->lastname];
			$request->session()->put('member', $member);
      $request->session()->save();
		}
		return ['success' => (count($validation) == 0 ? json_encode(array(true,($isconfirmpaymet != "" ? 2 : ($general->getAll($request)->cartinfo == "" ? 0 : 1)))) : false), 'validation' => $validation];
	}
	public function doLogout(Request $request)
	{
		$request->session()->forget('member');
		$request->session()->flush();

		return redirect('/');
	}

    public function register(Request $request)
    {
		$general = new General;
        return view('register', ['general'=>$general->getAll($request)]);
    }
	public function submitRegister(Request $request)
	{
		$member = new Member;
		$validation = [];

		$firstName = $request->input('firstName');
		$lastName = $request->input('lastName');
		$email = $request->input('email');
		$date   = $request->input('date');
		$month  = $request->input('month');
		$year   = $request->input('year');
		$gender = $request->input('gender');
		$password1 = $request->input('password1');
		$password2 = $request->input('password2');
		$terms = ($request->input('terms') == "" ? 0 : 1);
		$newsletter = ($request->input('newsletter') == "" ? 0 : 1);

		if($firstName == '')
		{
			$this->validationPush($validation, 'firstName', 'Please fill in the first name field.');
		}
		else if(!$this->validateAlpha($firstName))
		{
			$this->validationPush($validation, 'firstName', 'The first name contains alphabet only.');
		}
		if($lastName == '')
		{
			$this->validationPush($validation, 'lastName', 'Please fill in the last name field.');
		}
		else if(!$this->validateAlpha($lastName))
		{
			$this->validationPush($validation, 'lastName', 'The last name contains alphabet only.');
		}
		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the email address.');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address field.');
		}
		else if(count($member->getMemberByEmail2($email)) > 0)
		{
			$this->validationPush($validation, 'email', 'Your email already registered on De\'mor Boutique');
		}
		if($password1 == '')
		{
			$this->validationPush($validation, 'password1', 'Please fill in the password field.');
		}
		else if(strlen($password1) < 8 || strlen($password1) > 12)
		{
			$this->validationPush($validation, 'password1', 'Please insert the password length between 8 and 12 for all characters.');
		}
		if($password2 == '')
		{
			$this->validationPush($validation, 'password2', 'Please fill in the confirmation password.');
		}
		else if($password1 != $password2)
		{
			$this->validationPush($validation, 'password2', 'The password and confirmation password do not match.');
		}
		if($terms == '')
		{
			$this->validationPush($validation, 'terms', 'Please tick the terms and conditions');
		}
    /*rian validasi tanggal*/
    if($date == '' || $month == "" || $year == "")
		{
			$this->validationPush($validation, 'date', 'Please select date of birth.');
      $this->validationPush($validation, 'month', '');
      $this->validationPush($validation, 'year', '');
		}elseif(checkdate($month,$date,$year) == false)
    {
      $this->validationPush($validation, 'date', 'Please select valid date.');
      $this->validationPush($validation, 'month', '');
      $this->validationPush($validation, 'year', '');
    }
    /*end rian*/
		if(count($validation) == 0){
			$member->insertMember($firstName, $lastName, $email, $date.'/'.$month.'/'.$year, $gender, $password1, $newsletter);

			$data = $member->getMemberLastId();

			$client = new Client();
      Mail::to($email)->send(new EmailRegister($data));
      /* rian
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'register',
					'emailFrom' => $email,
					'data' => $data
				]
			]);
      */
		}

		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
	public function activateRegister(Request $request, $id, $token)
	{
		$member = new Member;

    /*rian
		$mmbr = $member->getMemberById($id);
    */
    $mmbr = $member->getMemberByIdNotActive($id);
		if(count($mmbr) != 1)
			return redirect('login');
		else if($mmbr[0]->ischange != $token)
		{
			return redirect('login');
		}

		$member->activateMember($id);

		return redirect('login');
	}

    public function forgot(Request $request)
    {
		$general = new General;
        return view('forgot', ['general'=>$general->getAll($request)]);
    }

	public function submitForgot(Request $request)
	{
		$validation = [];
		$member = new Member;

		$email = $request->input('email');
		if($email == '')
		{
			$this->validationPush($validation, 'email', 'Please fill in the email address.');
		}
		else if(!$this->validateEmail($email))
		{
			$this->validationPush($validation, 'email', 'Please enter a valid email address field.');
		}
		else
		{
			$member->forgotPassword($email);
			$data = $member->getMemberByEmail($email);
			if(count($data) != 1)
			{
				$this->validationPush($validation, 'email', 'The email address is not registered in De\'mor Boutique.');
			}
			else
			{
				$data = $data[0];
			}
		}

		if(count($validation) == 0){
      Mail::to($email)->send(new EmailForgotPassword($data));
      	/*rian comment
			$client = new Client();
			$res = $client->request('POST', 'http://localhost/mail/index.php', [
				'form_params' => [
					'cons' => 'forgot',
					'emailFrom' => $email,
					'data' => $data
				]
			]);
      */
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}

	public function forgotNewPassword(Request $request, $id, $token)
	{
		$general = new General;
		$member = new Member;

		$mmbr = $member->getMemberById($id);
		if(count($mmbr) != 1)
			return redirect('login');
		else if($mmbr[0]->ischange != $token)
		{
			return redirect('login');
		}

        return view('newpassword', ['general'=>$general->getAll($request), 'id'=>$id, 'token'=>$token]);
	}

	public function submitForgotNewPassword(Request $request)
	{
		$member = new Member;
		$validation = [];

		$id = $request->input('id');
		$newPassword = $request->input('newPassword');
		$confirmPassword = $request->input('confirmPassword');

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
			$member->clearToken($id);
			$member->updatePassword($id, $newPassword);
		}
		return ['success' => (count($validation) == 0 ? true : false), 'validation' => $validation];
	}
}
