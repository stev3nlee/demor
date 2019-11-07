<?php

namespace App\Http\Models;
use DB;

class Order
{
	public function getLastOrderNo($date)
	{
		return DB::select('select orderno from orderheader where left(orderno, 6) = ? order by orderno desc limit 1', [$date]);
	}

	public function insertOrder($orderno, $general, $paymentType)
	{
		$status = ($paymentType == 'Bank Transfer' ? 'Pending':'Paid');
		DB::insert('insert into orderheader(orderno, memberid, membername, memberemail, paymenttype, voucherid, voucher, note, subtotal, conveniencefee, vouchernominal, shippingfee, tax, status, insertdate, updatedate, isdeleted)
					values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), ?)', [
			$orderno,
			$general->member->userid,
			$general->member->fullname,
			$general->member->email,
			$paymentType,
			($general->cartinfo->Header->voucherid == "" ? 0:$general->cartinfo->Header->voucherid),
			$general->cartinfo->Header->voucher,
			$general->cartinfo->Header->note,
			$general->cartinfo->Header->subtotal,
			$general->cartinfo->Header->conveniencefee,
			$general->cartinfo->Header->vouchernominal,
			$general->cartinfo->Header->shipping,
			$general->cartinfo->Header->tax,
			$status,
			0
		]);
		DB::insert('insert into orderhistory values(?, now(), ?, null)', [$orderno, $status]);
		DB::insert('insert into orderinfo values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
			$orderno,
			$general->cartinfo->Shipping->bfname,
			$general->cartinfo->Shipping->blname,
			$general->cartinfo->Shipping->bemail,
			$general->cartinfo->Shipping->baddress,
			$general->cartinfo->Shipping->bcountry,
			$general->cartinfo->Shipping->bstate,
			$general->cartinfo->Shipping->bcity,
			$general->cartinfo->Shipping->bzipcode,
			$general->cartinfo->Shipping->btelephoneNumber,
			$general->cartinfo->Shipping->bmobileNumber,
			1
		]);
		DB::insert('insert into orderinfo values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
			$orderno,
			$general->cartinfo->Billing->fname,
			$general->cartinfo->Billing->lname,
			$general->cartinfo->Billing->email,
			$general->cartinfo->Billing->address,
			$general->cartinfo->Billing->country,
			$general->cartinfo->Billing->state,
			$general->cartinfo->Billing->city,
			$general->cartinfo->Billing->zipcode,
			$general->cartinfo->Billing->telephoneNumber,
			$general->cartinfo->Billing->mobileNumber,
			2
		]);
		foreach($general->cart as $cart)
		{
			DB::insert('insert into orderdetail values(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
				$orderno,
				$cart->productId,
				$cart->productColor,
				$cart->productName,
				$cart->productImage,
				$cart->productColorPath,
				$cart->productPrice,
				$cart->productSize,
				$cart->productQuantity
			]);
		}
		if($status == 'Paid'){
			DB::update("update product_detail_size a join orderdetail b on a.productid = b.productid and a.colorid = b.productcolorid and a.size = b.productsize set a.stock = a.stock - b.quantity
					where b.orderno = ?", [$orderno]);
		}
	}

	public function getOrderHeader($orderNo)
	{
		return DB::select('select * from orderheader a left join payment_transfer b on a.paymentto = b.transferid where orderno = ?', [$orderNo]);
	}
	public function getOrderHeaderByUser($id)
	{
		return DB::select("select a.orderno, membername, subtotal, vouchernominal, conveniencefee, tax, shippingfee, status, insertdate, updatedate, trackingno, concat(coalesce(b.exchangestatus, ''), ' ', coalesce(c.exchangestatus, ''), ' ', coalesce(d.exchangestatus, '')) as exchangedate
							from orderheader a left join (select 'Permit' as exchangestatus, orderno from order_permit group by orderno) b on a.orderno = b.orderno
							left join (select 'Not Permit' as exchangestatus, orderno from order_notpermit group by orderno) c on a.orderno = c.orderno
							left join (select 'Refund' as exchangestatus, orderno from order_refund group by orderno) d on a.orderno = d.orderno
							where memberid = ? order by orderno desc", [$id]);
	}
	public function getPendingOrderByUser($id, $orderNo)
	{
		return DB::select("select * from orderheader where memberid = ? and orderno = ? and status = 'Pending'", [$id, $orderNo]);
	}
	public function getDetailOrderByUser($id, $orderNo)
	{
		return DB::select("select * from orderheader where memberid = ? and orderno = ?", [$id, $orderNo]);
	}
	public function getOrderPayment($orderNo)
	{
		return DB::select('select id, orderno, paymentto, accountno, accountname, totalamount, evidence, bankname, accountnumber, bankaccountname from orderpayment a
                          left join payment_transfer b on a.paymentto = b.transferid where orderno = ? order by id desc', [$orderNo]);
	}
	public function getOrderPaymentTo($orderNo)
	{
		return DB::select('select * from payment_transfer where transferid = (select paymentto from orderheader where orderno = ?)', [$orderNo]);
	}
	public function getOrderPaymentExchangeTo($orderNo)
	{
		return DB::select('select * from payment_transfer where transferid = (select paymentto from orderpayment where orderno = ? order by id desc limit 1)', [$orderNo]);
	}
	public function getOrderDetail($orderNo)
	{
		return DB::select('select * from orderdetail where orderno = ?', [$orderNo]);
	}
	public function getOrderInfo($orderNo)
	{
		return DB::select('select orderno, firstname, lastname, email, address, telphonenumber, mobilenumber, info, COALESCE(b.name, a.country) as country, COALESCE(c.name, a.state) as state, COALESCE(d.name, a.city) as city, COALESCE(e.postal_code, a.zipcode) as zipcode from orderinfo a
							left join countries b on a.country = b.id
							left join states c on a.state = c.id
							left join cities d on a.city = d.id
							left join postal_codes e on a.zipcode = e.postal_code
							where orderno = ? order by info', [$orderNo]);
	}
	public function getOrderHistory($orderNo)
	{
		return DB::select('select * from orderhistory where orderno = ?', [$orderNo]);
	}
	public function getAllOrderTransaction()
	{
		return DB::select("select a.orderno, membername, subtotal, vouchernominal, conveniencefee, tax, shippingfee, status, insertdate, updatedate, trackingno, concat(coalesce(b.exchangestatus, ''), ' ', coalesce(c.exchangestatus, ''), ' ', coalesce(d.exchangestatus, '')) as exchangedate
							from orderheader a left join (select 'Permit' as exchangestatus, orderno from order_permit group by orderno) b on a.orderno = b.orderno
							left join (select 'Not Permit' as exchangestatus, orderno from order_notpermit group by orderno) c on a.orderno = c.orderno
							left join (select 'Refund' as exchangestatus, orderno from order_refund group by orderno) d on a.orderno = d.orderno
							where isdeleted = 0 order by a.orderno desc");
	}
	public function getAllOrderTransactionPage($page)
	{
		return DB::select("select a.orderno, membername, subtotal, vouchernominal, conveniencefee, tax, shippingfee, status, insertdate, updatedate, trackingno, concat(coalesce(b.exchangestatus, ''), ' ', coalesce(c.exchangestatus, ''), ' ', coalesce(d.exchangestatus, '')) as exchangedate
							from orderheader a left join (select 'Permit' as exchangestatus, orderno from order_permit group by orderno) b on a.orderno = b.orderno
							left join (select 'Not Permit' as exchangestatus, orderno from order_notpermit group by orderno) c on a.orderno = c.orderno
							left join (select 'Refund' as exchangestatus, orderno from order_refund group by orderno) d on a.orderno = d.orderno
							where isdeleted = 0 order by a.orderno desc
							limit ?", [$page]);
	}
	public function getOrderPermit($orderNo)
	{
		return DB::select('select orderno, vouchername as voucher, null as permitdetail from order_permit a
							join voucher b on a.voucher = b.voucherid where orderno = ?', [$orderNo]);
	}
	public function getOrderPermitDetail($orderNo)
	{
		return DB::select('select * from order_permit_detail where orderno = ?', [$orderNo]);
	}
	public function getOrderNotPermit($orderNo)
	{
		return DB::select('select * from order_notpermit where orderno = ?', [$orderNo]);
	}
	public function getOrderRefund($orderNo)
	{
		return DB::select('select * from order_refund where orderno = ?', [$orderNo]);
	}
	public function getMemberEmail()
	{
		return DB::select('SELECT DISTINCT memberemail FROM orderheader WHERE isdeleted = 0');
	}
	public function confirmPaid($orderNo)
	{
		$status = 'Paid';
		DB::update("update orderheader set status = ?, updatedate = now() where orderno = ?", [$status, $orderNo]);
		DB::insert('insert into orderhistory values(?, now(), ?, null)', [$orderNo, $status]);
		DB::update("update product_detail_size a join orderdetail b on a.productid = b.productid and a.colorid = b.productcolorid and a.size = b.productsize set a.stock = a.stock - b.quantity
					where b.orderno = ?", [$orderNo]);
	}
	public function confirmShippingTracking($orderNo, $tracking)
	{
		$status = 'Ship';
		DB::update("update orderheader set status = ?, trackingno = ?, updatedate = now() where orderno = ?", [$status, $tracking, $orderNo]);
		DB::insert('insert into orderhistory values(?, now(), ?, null)', [$orderNo, $status]);
	}
	public function deleteOrder($id)
	{
		$status = 'Deleted';
		DB::update('update orderheader set isdeleted = 1 where orderno = ?', [$id]);
		DB::insert('insert into orderhistory values(?, now(), ?, null)', [$id, $status]);
	}
	public function submitPermit($orderno, $voucher, $product, $quantity)
	{
		DB::insert('insert into order_permit values(?, ?, now())', [$orderno, $voucher]);
		for($i=0; $i<count($product); $i++)
		{
			DB::insert('insert into order_permit_detail select orderno, productid, productname, productimage, productcolor, productprice, productsize, ? from orderdetail where orderno = ? and productid = ?', [$quantity[$i], $orderno, $product[$i]]);
		}
	}
	public function submitRefund($orderno, $product, $quantity)
	{
		for($i=0; $i<count($product); $i++)
		{
			DB::insert('insert into order_refund select orderno, productid, productname, productimage, productcolor, productprice, productsize, ? from orderdetail where orderno = ? and productid = ?', [$quantity[$i], $orderno, $product[$i]]);
		}
	}
	public function submitNotPermit($notPermitId, $productName, $size, $colour, $quantity, $shippingCost)
	{
		DB::insert('insert into order_notpermit values(?, ?, ?, ?, ?, ?, now())', [$notPermitId, $productName, $size, $colour, $quantity, $shippingCost]);
	}

	public function getReminderOrder()
	{
		return DB::select('SELECT * FROM orderheader WHERE status = "Pending" AND TIMESTAMPDIFF(hour,insertdate,NOW()) = 23 AND isdeleted = 0');
	}

	public function getExpireOrder()
	{
		return DB::select('SELECT * FROM orderheader WHERE status = "Pending" AND TIMESTAMPDIFF(hour,insertdate,NOW()) = 24 AND isdeleted = 0');
	}

	public function getReminderNotPermit()
	{
		return DB::select('SELECT DISTINCT a.orderno, c.memberemail, IFNULL(b.accountname,0) as paid FROM order_notpermit a
												LEFT JOIN orderpayment b ON b.orderno = a.orderno
												LEFT JOIN orderheader c ON c.orderno = a.orderno WHERE TIMESTAMPDIFF(hour,notpermitdate,NOW()) = 264');
	}

	public function updateExpireOrder($orderno)
	{
			DB::update('UPDATE orderheader SET status ="Cancel" WHERE TIMESTAMPDIFF(hour,insertdate,NOW()) = 24 AND status = "Pending" AND isdeleted = 0 AND orderno = "'.$orderno.'"');
			DB::insert('INSERT INTO orderhistory (orderno, date, status, remark) VALUES ("'.$orderno.'" , NOW(),"Canceled","Scheduler" ) ');
	}

	public function updateExpireOrder2($orderno)
	{
			DB::update('UPDATE orderheader SET status ="Cancel" WHERE orderno = "'.$orderno.'"');
			DB::insert('INSERT INTO orderhistory (orderno, date, status, remark) VALUES ("'.$orderno.'" , NOW(),"Canceled","Canceled By Admin" ) ');
	}

	public function getExpireNotPermit()
	{
		return DB::select('SELECT DISTINCT a.orderno, c.memberemail, IFNULL(b.accountname,0) AS paid FROM order_notpermit a
												LEFT JOIN orderpayment b ON b.orderno = a.orderno
												LEFT JOIN orderheader c ON c.orderno = a.orderno WHERE TIMESTAMPDIFF(hour,notpermitdate,NOW()) = 336');
	}

	/* Index */
	public function getOrderTop12Statistic()
	{
		return DB::select("SELECT sum(number) as number, date, sortdate FROM (
							SELECT count(*) as number, DATE_FORMAT(insertdate, '%M %Y') as date, DATE_FORMAT(insertdate, '%Y %m') as sortdate FROM orderheader WHERE status = 'Ship'
							group by DATE_FORMAT(insertdate, '%M %Y'), insertdate
							) A GROUP BY date, sortdate
							ORDER BY sortdate");
	}
	public function getOtherStats()
	{
		return DB::select("SELECT (select count(*) FROM orderheader where status in ('Paid', 'Ship') and isdeleted = 1) as ordertotal,
							(select count(*) from member where active = 1) as membertotal,
							(select count(*) from subscribe) as subscribetotal");
	}
	public function getOrderMonthly()
	{
		return DB::select("SELECT sum(number) as number, sortdate FROM (
							SELECT count(*) as number, DATE_FORMAT(insertdate, '%m') as sortdate FROM orderheader
							WHERE status = 'Ship' and DATE_FORMAT(now(), '%Y') = DATE_FORMAT(insertdate, '%Y')
							group by DATE_FORMAT(insertdate, '%M %Y'), insertdate
							) A GROUP BY sortdate
							ORDER BY sortdate");
	}
	public function getOrderDaily()
	{
		return DB::select("SELECT sum(number) as number, sortdate FROM (
							SELECT count(*) as number, DATE_FORMAT(insertdate, '%d') as sortdate FROM orderheader
							WHERE status = 'Ship' and DATE_FORMAT(now(), '%Y %m') = DATE_FORMAT(insertdate, '%Y %m')
							group by DATE_FORMAT(insertdate, '%M %Y'), insertdate
							) A GROUP BY sortdate
							ORDER BY sortdate");
	}
	public function getOrderSales()
	{
		return DB::select("SELECT (SELECT coalesce(sum(productprice * quantity), 0) from orderdetail a join orderheader b on a.orderno = b.orderno
								where status in ('Paid', 'Ship') and DATE_FORMAT(insertdate, '%Y %m %d') = DATE_FORMAT(now(), '%Y %m %d')) as today,
								(SELECT coalesce(sum(productprice * quantity), 0) from orderdetail a join orderheader b on a.orderno = b.orderno
								where status in ('Paid', 'Ship') and week(insertdate) = week(now()) and year(insertdate) = year(now())) as week,
								(SELECT coalesce(sum(productprice * quantity), 0) from orderdetail a join orderheader b on a.orderno = b.orderno
								where status in ('Paid', 'Ship') and month(insertdate) = month(now()) and year(insertdate) = year(now())) as month");
	}
	public function getTopSalesProduct($stats)
	{
		if($stats == 'today'){
			return DB::select("SELECT count(*) as totalorder, productid, productname
							from orderdetail a join orderheader b on a.orderno = b.orderno
							where status in ('Paid', 'Ship') and DATE_FORMAT(insertdate, '%Y %m %d') = DATE_FORMAT(now(), '%Y %m %d')
							group by productid, productname
							order by totalorder desc
							limit 5");
		}
		else if($stats == 'week'){
			return DB::select("SELECT count(*) as totalorder, productid, productname
							from orderdetail a join orderheader b on a.orderno = b.orderno
							where status in ('Paid', 'Ship') and week(insertdate) = week(now()) and year(insertdate) = year(now())
							group by productid, productname
							order by totalorder desc
							limit 5");
		}
		else if($stats == 'month'){
			return DB::select("SELECT count(*) as totalorder, productid, productname
							from orderdetail a join orderheader b on a.orderno = b.orderno
							where status in ('Paid', 'Ship') and month(insertdate) = month(now()) and year(insertdate) = year(now())
							group by productid, productname
							order by totalorder desc
							limit 5");
		}
		else if($stats == 'year'){
			return DB::select("SELECT count(*) as totalorder, productid, productname
							from orderdetail a join orderheader b on a.orderno = b.orderno
							where status in ('Paid', 'Ship') and year(insertdate) = year(now())
							group by productid, productname
							order by totalorder desc
							limit 5");
		}
	}

	/*rian fix missing session*/
	public function getTempOrderNo($orderNo)
	{
		return DB::select("select * from order_temp_session where orderno = ?", [$orderNo]);
	}

	public function deleteTempOrderNo($orderNo)
	{
		DB::delete('delete from order_temp_session where orderno = ?', [$orderNo]);
		return;
	}

	public function insertTempOrder($orderNo,$cart,$cartinfo,$member,$popup)
	{
		DB::insert('insert into order_temp_session(orderno,cart,cartinfo,member,popup) values(?, ?, ?, ?, ?)', [$orderNo, $cart,$cartinfo,$member,$popup]);
	}
	/*end rian*/
}
