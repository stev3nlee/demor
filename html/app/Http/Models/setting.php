<?php

namespace App\Http\Models;
use DB;

class Member
{
    public function getAllMember()
    {
		return DB::select('select * from member where active = 1');
    }
    public function getMemberById($userId)
    {
		return DB::select('select * from member where active = 1 and userid = ?', [$userId]);
    }
	public function deleteMemberById($id)
	{
		DB::delete('delete from member where userid = ?', [$id]);
		return;
	}
}