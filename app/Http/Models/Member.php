<?php

namespace App\Http\Models;
use DB;

class Member
{
    public function getAllMember()
    {
		return DB::select('select * from member a where active = 1 order by userid desc');
    }
    public function getMemberById($userId)
    {
		return DB::select('select a.*, COALESCE(b.name, country) as countryname, COALESCE(c.name, state) as statename, COALESCE(d.name, city) as cityname, COALESCE(e.postal_name, a.postcode) as postname from member a
							left join countries b on a.country = b.id
							left join states c on a.state = c.id
							left join cities d on a.city = d.id
							left join postal_codes e on a.postcode = e.postal_code
							where active = 1 and userid = ?', [$userId]);
    }
    //rian

    public function getMemberByIdNotActive($userId)
    {
		    return DB::select('select * from member where active = 0 and userid = ?', [$userId]);
    }
    //end rion
	public function getMemberLastId()
	{
		return DB::select('select * from member order by userid desc limit 0, 1')[0];
	}
  public function getMemberByEmail($email)
  {
	return DB::select('select a.*, COALESCE(b.name, country) as countryname, COALESCE(c.name, state) as statename, COALESCE(d.name, city) as cityname, COALESCE(e.postal_name, a.postcode) as postname from member a
						left join countries b on a.country = b.id
						left join states c on a.state = c.id
						left join cities d on a.city = d.id
						left join postal_codes e on a.postcode = e.postal_code where active = 1 and emailaddress = ?', [$email]);
  }
  public function getMemberByEmail2($email)
  {
	return DB::select('select a.*, COALESCE(b.name, country) as countryname, COALESCE(c.name, state) as statename, COALESCE(d.name, city) as cityname, COALESCE(e.postal_name, a.postcode) as postname from member a
						left join countries b on a.country = b.id
						left join states c on a.state = c.id
						left join cities d on a.city = d.id
						left join postal_codes e on a.postcode = e.postal_code where emailaddress = ?', [$email]);
  }
	public function forgotPassword($email)
	{
		return DB::update('update member set ischange = uuid() where active = 1 and emailaddress = ?', [$email]);
	}
	public function insertMember($firstName, $lastName, $email, $dob, $gender, $password1, $newsletter)
	{
		DB::insert("insert into member(firstname, lastname, emailaddress, password, dateofbirth, gender, issubscribe, active, ischange) values (?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, 0, uuid())",
					[$firstName, $lastName, $email, md5($password1), $dob, $gender, $newsletter]);
	}
	public function updateMember($id, $firstName, $lastName, $email, $dob, $gender, $country, $city, $state, $postcode, $address, $telphoneNumber, $mobileNumber)
	{
		DB::update("update member set firstname = ?, lastname = ?, dateofbirth = STR_TO_DATE(?, '%d/%m/%Y'), gender = ?, country = ?, city = ?, state = ?, postcode = ?, address = ?, telphonenumber = ?, mobilenumber = ? where userid = ?",
					[$firstName, $lastName, $dob, $gender, $country, $city, $state, $postcode, $address, $telphoneNumber, $mobileNumber, $id]);
	}
	public function clearToken($id)
	{
		DB::update('update member set ischange = null where userid = ?', [$id]);
	}
	public function updatePassword($id, $password)
	{
		DB::update("update member set password = ? where userid = ?", [md5($password), $id]);
	}
	public function activateMember($id)
	{
		DB::update("update member set active = 1, ischange = null where userid = ?", [$id]);
	}
	public function doLogin($email, $password)
	{
		return DB::select("select userid, firstname, lastname, emailaddress, active from member where emailaddress = ? and password = ?", [$email, md5($password)]);
	}
	public function isOldPassword($id, $password)
	{
		return DB::select('select * from member where userid = ? and password = ?', [$id, md5($password)]);
	}
	public function deleteMemberById($id)
	{
		DB::delete('delete from member where userid = ?', [$id]);
		return;
	}

	public function getAllShipping()
	{
		return DB::select('select * from shipping');
	}
	public function getAllPayment()
	{
		return DB::select('select * from payment');
	}
	public function getAllPublishPayment()
	{
		return DB::select('select * from payment where ispublish = 1');
	}
	public function savePublish($id, $isPublish)
	{
		return DB::update('update payment set ispublish = ? where paymentid = ?', [$isPublish, $id]);
	}
	public function getAllBanks()
	{
		return DB::select('select * from payment_transfer');
	}
	public function getAllPublishBanks()
	{
		return DB::select('select * from payment_transfer where ispublish = 1');
	}
	public function getBanksByName($id, $name)
	{
		return DB::select("select * from payment_transfer where transferid = case when transferid = ? and accountnumber = ? then '0' else transferid end and accountnumber = ?", [$id, $name, $name]);
	}
	public function addBankTransfer($bank, $account, $accountName, $isPublish)
	{
		return DB::insert('insert into payment_transfer(bankname, accountnumber, bankaccountname, ispublish) values(?, ?, ?, ?)', [$bank, $account, $accountName, $isPublish]);
	}
	public function editBankTransfer($id, $bank, $account, $accountName, $isPublish)
	{
		return DB::update('update payment_transfer set bankname = ?, accountnumber = ?, bankaccountname = ?, ispublish = ? where transferid = ?', [$bank, $account, $accountName, $isPublish, $id]);
	}
	public function deleteBankTransferById($id)
	{
		return DB::delete('delete from payment_transfer where transferid = ?', [$id]);
	}

	public function getAllVoucher()
	{
		//, (select count(*) from (select distinct memberid, voucher from orderheader) as x where a.vouchername = x.voucher) as totalMember
		// and b.status not in('Pending', 'Waiting')
		return DB::select("select a.voucherid, vouchername, discount, case when islimit = 1 then 'No Limit' else timescanused end as timescanused, a.insertdate, a.isexpired, a.isdeleted,
							case when isexpired = 1 then '-' else discountbegin end as discountbegin, case when isexpired = 1 then '-' else discountend end as discountend,
							count(b.voucher) as used
							from voucher a
							left join orderheader b on b.voucherid = a.voucherid
							group by voucherid, vouchername, discount, timescanused, a.islimit, a.insertdate, a.isexpired, a.isdeleted, discountbegin, discountend order by voucherid desc");
	}
	public function getAllActiveVoucher()
	{
		return DB::select("select * from voucher where isdeleted = 0 and (isexpired = 1 or now() between discountbegin and discountend)");
	}
	public function getAllOrderHeaderByVoucher($id)
	{
		//return DB::select("select membername, a.insertdate, subtotal, vouchernominal, subtotal + conveniencefee + shippingfee + tax - vouchernominal as total
		//					from orderheader a join voucher b on a.voucher = b.vouchername");
		return DB::select("select membername, a.insertdate, subtotal, vouchernominal, subtotal + conveniencefee + shippingfee + tax - vouchernominal as total
							from orderheader a join voucher b on a.voucherid = b.voucherid WHERE a.voucherid = '".$id."'");
	}
	public function getVoucherByName($voucherName)
	{
		return DB::select('select * from voucher a where isdeleted = 0 and vouchername = ?
							and (isexpired = 1 or now() between discountbegin and discountend)
							and (islimit = 1 or timescanused > (select count(*) from orderheader where orderheader.voucherid = a.voucherid))', [$voucherName]);
	}
	public function deleteVoucherById($id)
	{
		return DB::update('update voucher set isdeleted = 1 where voucherid = ?', [$id]);
	}
	public function submitVoucher($voucherName, $vat, $isLimited, $price, $category, $beginDate, $endDate, $isExpired)
	{
		DB::insert('insert into voucher(vouchername, timescanused, islimit, discount, discountfor, discountbegin, discountend, isexpired, insertdate, isdeleted) values(?, ?, ?, ?, ?, STR_TO_DATE(?, "%d/%m/%Y"), STR_TO_DATE(?, "%d/%m/%Y"), ?, now(), 0)', [$voucherName, $vat, $isLimited, $price, $category, $beginDate, $endDate, $isExpired]);
	}

	public function getAllExchange()
	{
		return DB::select('select * from product_exchange order by exchangeid desc');
	}
	public function deleteExchangeById($id)
	{
		DB::delete('delete from product_exchange where exchangeid = ?', [$id]);
	}

	public function getOthers()
	{
		return DB::select('select * from settings');
	}
	public function submitOthers($tax, $arrival,$submenuname,$method,$categoryid,$withbanner,$image,$productId,$collectionProduct,$image2)
	{
		DB::update('update settings set tax = ?, arrival = ?, submenuname = ?,method = ?,categoryid = ?,withbanner = ?, categorybanner = ? , productid = ? , collectionproductid = ?, collectionbanner = ?', [$tax, $arrival*7, $submenuname,$method, $categoryid,$withbanner, $image, $productId, $collectionProduct, $image2]);
	}
	public function confirmPayment($orderNo, $accountNo, $accountName, $paymentTo, $totalAmmount, $picturePath)
	{
		$status = 'Waiting';
		DB::update("update orderheader set paymentto = ?, accountno = ?, accountname = ?, totalamount = ?, evidence = ?, status = ?, updatedate = now() where orderno = ?",
		[$paymentTo, $accountNo, $accountName, $totalAmmount, $picturePath, $status, $orderNo]);
		DB::insert('insert into orderhistory values(?, now(), ?, null)', [$orderNo, $status]);
	}
	public function confirmExchange($orderNo, $accountNo, $accountName, $paymentTo, $totalAmmount, $picturePath)
	{
		DB::insert('insert into orderpayment(orderno, paymentto, accountno, accountname, totalamount, evidence) values(?, ?, ?, ?, ?, ?)', [$orderNo, $paymentTo, $accountNo, $accountName, $totalAmmount, $picturePath]);
	}

	public function getAllCountry()
	{
		return DB::select('select * from countries');
	}
	public function getStateById($country)
	{
		return DB::select('select * from states where country_id = ?', [$country]);
	}
	public function getCityById($state)
	{
		return DB::select('select * from cities where state_id = ?', [$state]);
	}
	public function getPostCodeById($city)
	{
		return DB::select('select * from postal_codes where city_id = ?', [$city]);
	}

	public function getCountryByCountryId($id)
	{
		return DB::select('select * from countries where id = ?',[$id]);
	}
	public function getStateByStateId($id)
	{
		return DB::select('select * from states where id = ?', [$id]);
	}
	public function getCityByCityId($id)
	{
		return DB::select('select * from cities where id = ?', [$id]);
	}
}
