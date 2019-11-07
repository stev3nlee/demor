<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\User;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin/login');
    }
    public function login(Request $request)
    {
		$user = new User;
		$email = $request->input('email');
		$password = $request->input('password');
		$isDashboard = false;
		
		$users = $user->login($email, $password);
		if(count($users) == 1)
		{
			$menus = $user->getUserMenuAuthentication($users[0]->roleid);
			$totalMenu = 24;
			$count = 0;
			$actualMenus = [];
			for($i=0; $i<$totalMenu; $i++)
			{
				$flag = true;
				if($count < count($menus))
				{
					if($menus[0]->menuid == 1)
						$isDashboard = true;
					
					if($i == $menus[$count]->menuid)
					{
						array_push($actualMenus, 1);
						$count++;
						$flag = false;
					}
				}
				if($flag)
					array_push($actualMenus, 0);
			}
			$admin = (object)["email" => $users[0]->email, "fullname" => $users[0]->fullname, "menus" => $actualMenus];
			
			$request->session()->put('admin', $admin);
			if(!$isDashboard)
				return redirect('meisjejongetje/index');
			else
				return redirect('meisjejongetje/settings/changepassword');
		}
		return redirect('meisjejongetje/')->with('message', (object)['type'=>'alert-warning', 'content'=>'The email or password is invalid.']);
    }
	public function logout(Request $request)
	{
		$request->session()->forget('admin');
		//$request->session()->flush();
		
		return redirect('meisjejongetje/');
	}
    public function forgot()
    {
        return view('admin/password');
    }
}