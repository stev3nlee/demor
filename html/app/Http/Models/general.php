<?php

namespace App\Http\Models;
use App\Http\Models\Page;
use App\Http\Models\Product;
use DB;
class General
{
	public function getAll($request)
	{
		$page = new Page;
		$product = new Product;
		$member = $request->session()->get('member');
		$cart = $request->session()->get('cart');
		$cartinfo = $request->session()->get('cartinfo');
		$cartcount = 0;
		if($cart != null){
			foreach($cart as $c)
			{
				$cartcount += $c->productQuantity;
			}
		}

		return (object)[
			'cart'=>($cart == null ? [] : $cart),
			'cartinfo'=>($cartinfo == null ? '' : $cartinfo),
			'cartcount'=>$cartcount,
			'member'=>$member,
			'footer'=>$page->getFooter()[0],
			'header'=>$page->getPageHeader()[0],
			'menu'=>$product->getAllProductCategory(),
			'demor'=>$page->getAllBlogCategory()
		];
	}

	public function getSubscriber($email)
	{
		return DB::select('select * from subscribe where type = 1 and email = ?', [$email]);
	}
}
