<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Page;
use App\Http\Models\User;

class AdminSettingController extends Controller
{
    public function socialMedia(Request $request)
    {
		$page = new Page;
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'Social Media', 'path'=>'admin/settings/socialmedia']
		];
		
        return view('admin/settings/socialmedia/index', ['admin'=>$admin, 'detailFooter' => $page->getFooter()[0], 'breadCrumb'=>$breadCrumb]);
    }
	
	public function changePassword(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'Change Password', 'path'=>'admin/settings/changepassword']
		];
			
        return view('admin/settings/changepassword/index', ['admin'=>$admin, 'breadCrumb'=>$breadCrumb]);
	}
	public function submitChangePassword(Request $request)
	{
		$admin = $request->session()->get('admin');
		$user = new User;
		$oldPassword = $request->input('oldPassword');
		$newPassword = $request->input('newPassword');
		$confirmPassword = $request->input('confirmPassword');
		
		if($newPassword != $confirmPassword){
			return redirect('meisjejongetje/settings/changepassword')->with('message', (object)['type'=>'alert-warning', 'content'=>'The new password and confirmation password does not match.']);
		}
		if(count($user->login($admin->email, $oldPassword)) != 1){
			return redirect('meisjejongetje/settings/changepassword')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please insert the correct old password.']);
		}
		$user->changeUserPassword($admin->email, $newPassword);
		return redirect('meisjejongetje/settings/changepassword')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully changed the password.']);
	}
	
	public function tools(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'Tools', 'path'=>'admin/settings/tools']
		];
		
		$page = new Page;
        return view('admin/settings/tools/index', ['admin'=>$admin, 'header'=>$page->getPageHeader()[0], 'breadCrumb'=>$breadCrumb]);
	}
	
	public function general(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'General', 'path'=>'admin/settings/general']
		];
			
		$page = new Page;
        return view('admin/settings/general/index', ['admin'=>$admin, 'header'=>$page->getPageHeader()[0], 'breadCrumb'=>$breadCrumb]);
	}
	public function submitHeader(Request $request)
	{
		$page = new Page;
		$type = $request->input('type');
		$title = $request->input('title');
		$keyword = $request->input('keyword');
		$description = $request->input('description');
		$googleWebMaster = $request->input('googleWebMaster');
		$googleAnalytic = $request->input('googleAnalytic');
		$logo = null;
		$favicon = null;
		
		if($request->file('logo') != null)
		{			
			if ($request->file('logo')->isValid()) {
				$destinationFile = "sliderimage";
				$extension = $request->file('logo')->getClientOriginalExtension();
				$filename = 'logo.'.strtotime(date("d-m-Y")).".".$extension;
				$request->file('logo')->move($destinationFile, $filename);
				$logo = $destinationFile."/".$filename;
			}
		}
		
		if($request->file('favicon') != null)
		{			
			if ($request->file('favicon')->isValid()) {
				$destinationFile = "sliderimage";
				$extension = $request->file('favicon')->getClientOriginalExtension();
				$filename = 'favicon.'.$extension;
				$request->file('favicon')->move($destinationFile, $filename);
				$favicon = $destinationFile."/".$filename;
			}
		}
		
		$page->submitHeader($type, $title, $keyword, $description, $googleWebMaster, $googleAnalytic, $logo, $favicon);
		if($type == 0)
			return redirect('meisjejongetje/settings/general')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this information.']);
		else
			return redirect('meisjejongetje/settings/tools')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this information.']);
	}
}