<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Converter;

class AdminIndexController extends Controller
{
    public function index(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$order = new Order;
		$converter = new Converter;
		$statistic = $order->getOrderTop12Statistic();
		$monthly = $order->getOrderMonthly();
		$daily = $order->getOrderDaily();
		$other = $order->getOtherStats();
		$topsales = $order->getTopSalesProduct('today');
		$orders = $order->getAllOrderTransactionPage(10);
		$sales = $order->getOrderSales()[0];
		foreach($orders as $o)
		{
			$o->insertdate = $converter->dateFormat($o->insertdate);
			$o->updatedate = $converter->dateFormat($o->updatedate);
		}
        return view('admin/index', [
			'admin'=>$admin,
			'orders'=>$orders,
			'statistic'=>$statistic,
			'other'=>$other[0],
			'topsales'=>$topsales,
			'monthly'=>$monthly,
			'daily'=>$daily,
			'sales'=>$sales
		]);
    }
	
	public function getTopSalesProduct(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		
		$stats = $request->input('stats');
		
		$order = new Order;
		return ['success' =>  true, 'topsales' => $order->getTopSalesProduct($stats)];
	}
}