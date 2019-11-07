<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\User;

class AdminUserController extends Controller
{
	public function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
    public function account(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'User Account', 'path'=>''],
			(object)['name' =>'Account', 'path'=>'admin/settings/useraccount/account']
		];
		
		$user = new User;
		$arr = [
			'admin' => $admin,
			'users' => $user->getAllUser(),
			'roles' => $user->getAllRole(),
			'breadCrumb'=>$breadCrumb
		];
        return view('admin/settings/useraccount/account/index', $arr);
    }
	public function addaccount(Request $request)
	{
		$user = new User;
		
		$email = $request->input('addemail');
		$fullname = $request->input('addfullname');
		$role = $request->input('addrole');
		
		if($email == '')
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the email address field.']);
		}
		else if(!$this->validateEmail($email))
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please enter a valid email address.']);
		}
		else if(count($user->getAccountByEmail($email)) > 0)
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'The email address has already been taken.']);
		}
		else if($fullname == '')
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the full name field.']);
		}
		
		$user->addAccount($email, $fullname, $role);
        return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this account.']);
	}
	public function editAccount(Request $request)
	{
		$user = new User;
		
		$email = $request->input('editemail');
		$fullname = $request->input('editfullname');
		$role = $request->input('editrole');
		
		if($email == '')
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the email address field.']);
		}
		else if(!$this->validateEmail($email))
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please enter a valid email address.']);
		}
		else if($fullname == '')
		{
			return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the full name field.']);
		}
		
		$user->editAccount($email, $fullname, $role);
        return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this account.']);
	}
    public function deleteAccount(Request $request)
    {
		$user = new User;
		
		$id = $request->input('deleteId');
		$user->deleteAccountById($id);
        
		return redirect('meisjejongetje/settings/useraccount/account')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this account']);
    }
	
    public function role(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'User Account', 'path'=>''],
			(object)['name' =>'Group', 'path'=>'admin/settings/useraccount/role']
		];
		
		$user = new User;
        return view('admin/settings/useraccount/group/index', ['admin' => $admin, 'roles' => $user->getAllRole(), 'breadCrumb'=>$breadCrumb]);
    }
    public function addRole(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'Group', 'path'=>'admin/settings/useraccount/role'],
			(object)['name' =>'Add Group', 'path'=>'admin/settings/useraccount/addrole']
		];
		
		$totalMenu = 24;
		$actualMenus = [];
		for($i=0; $i<$totalMenu; $i++)
		{
			array_push($actualMenus, 0);
		}
		$arr = [
			'admin' => $admin,
			'title' => 'Add',
			'role' => (object)['roleid'=>null, 'rolename'=>null],
			'menu' => $actualMenus,
			'breadCrumb' => $breadCrumb
		];
        return view('admin/settings/useraccount/group/add', $arr);
    }
    public function editRole(Request $request, $roleId)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$breadCrumb = [
			(object)['name' =>'Settings', 'path'=>''],
			(object)['name' =>'Group', 'path'=>'admin/settings/useraccount/role'],
			(object)['name' =>'Edit Group', 'path'=>'admin/settings/useraccount/editrole/'.$roleId]
		];
		
		$user = new User;
		$totalMenu = 24;
		$menus = $user->getMenuByRoleId($roleId);
		$actualMenus = [];
		$count = 0;
		for($i=0; $i<$totalMenu; $i++)
		{
			$flag = true;
			if($count < count($menus))
			{
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
		$arr = [
			'admin' => $admin,
			'title' => 'Edit',
			'role' => $user->getRoleById($roleId)[0],
			'menu' => $actualMenus,
			'breadCrumb' => $breadCrumb
		];
        
		return view('admin/settings/useraccount/group/add', $arr);
    }
    public function deleteRole(Request $request)
    {
		$user = new User;
		
		$id = $request->input('deleteId');
		if(count($user->getAllUserByRole($id)) != 0)
		{
			return redirect('meisjejongetje/settings/useraccount/role')->with('message', (object)['type'=>'alert-warning', 'content'=>'Warning: You cannot delete this role. The existing accounts are using this role.']);
		}
		
		$user->deleteRoleById($id);
        return redirect('meisjejongetje/settings/useraccount/role')->with('message', (object)['type'=>'alert-success', 'content'=>'You have deleted the role.']);
    }
	public function submitRole(Request $request)
	{
		$user = new User;
		
		$roleId = $request->input('roleId');
		$roleName = $request->input('roleName');
		$roleMenu = $request->input('roleMenu');
		
		if($roleName == '')
		{
			if($roleId == null || $roleId == '')
				return redirect('meisjejongetje/settings/useraccount/addrole')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the role name field.']);
			else
				return redirect('meisjejongetje/settings/useraccount/editrole/'.$roleId)->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the role name field.']);
		}
		else if(count($user->getAccountRoleByIdName($roleId, $roleName)) > 0)
		{
			if($roleId == null || $roleId == '')
				return redirect('meisjejongetje/settings/useraccount/addrole')->with('message', (object)['type'=>'alert-warning', 'content'=>'The role name has already been taken.']);
			else
				return redirect('meisjejongetje/settings/useraccount/editrole/'.$roleId)->with('message', (object)['type'=>'alert-warning', 'content'=>'The role name has already been taken.']);
		}
		
		$user->submitRole($roleId, $roleName, $roleMenu);
        return redirect('meisjejongetje/settings/useraccount/role')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this new role.']);
	}
}