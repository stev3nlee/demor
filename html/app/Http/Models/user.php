<?php

namespace App\Http\Models;
use DB;

class User
{	
	public function login($email, $password)
	{
		return DB::select('select * from account_user where email = ? and password = ?', [$email, md5($password)]);
	}
	public function changeUserPassword($email, $newPassword)
	{
		DB::update('update account_user set password = ? where email = ?', [md5($newPassword), $email]);
	}
	public function getUserMenuAuthentication($roleId)
	{
		return DB::select('select menuid from account_menu where roleid = ?', [$roleId]);
	}
	
	public function getAllUser()
	{
		return DB::select('select email, fullname, a.roleid, rolename from account_user a join account_role b on a.roleid = b.roleid');
	}
	public function getAllUserByRole($role)
	{
		return DB::select('select email, fullname, a.roleid, rolename from account_user a join account_role b on a.roleid = b.roleid where b.roleid = ?', [$role]);
	}
	public function getAccountByEmail($email)
	{
		return DB::select('select email, fullname, a.roleid, rolename from account_user a join account_role b on a.roleid = b.roleid where email = ? ', [$email]);
	}
	public function addAccount($email, $fullname, $role)
	{
		DB::insert('insert into account_user values(?, ?, ?, ?)', [$email, $fullname, md5('admin123'), $role]);
	}
	public function editAccount($email, $fullname, $role)
	{
		DB::update('update account_user set fullname = ?, roleid = ? where email = ?', [$fullname, $role, $email]);
	}
	public function deleteAccountById($id)
	{
		DB::delete('delete from account_user where email = ?', [$id]);
	}
	
    public function getAllRole()
    {
		return DB::select('select * from account_role order by roleid');
    }
	public function getRoleById($id)
	{
		return DB::select('select * from account_role where roleid = ?', [$id]);
	}
	public function getAccountRoleByIdName($id, $roleName)
	{
		return DB::select('select * from account_role where roleid != ? and rolename = ?', [$id, $roleName]);
	}
	public function getMenuByRoleId($id)
	{
		return DB::select('select * from account_menu where roleid = ? order by menuid', [$id]);
	}
	public function submitRole($roleId, $roleName, $roleMenu)
	{
		if($roleId == null)
		{
			DB::insert('insert into account_role(rolename) values(?)', [$roleName]);
			$role = DB::select('select * from account_role order by roleid desc limit 0, 1');
			for($i=0; $i<count($roleMenu); $i++)
			{
				DB::insert('insert into account_menu values(?, ?)', [$role[0]->roleid, $roleMenu[$i]]);
			}
		}
		else
		{
			DB::update('update account_role set rolename = ? where roleid = ?', [$roleName, $roleId]);
			DB::delete('delete from account_menu where roleid = ?', [$roleId]);
			for($i=0; $i<count($roleMenu); $i++)
			{
				DB::insert('insert into account_menu values(?, ?)', [$roleId, $roleMenu[$i]]);
			}
		}
	}
	public function deleteRoleById($id)
	{
		DB::delete('delete from account_role where roleid = ?', [$id]);
		DB::delete('delete from account_menu where roleid = ?', [$id]);
	}
}