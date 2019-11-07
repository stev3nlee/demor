<?php

namespace App\Http\Models;
use DB;

class Product
{
	public function getAllProduct()
	{
		return DB::select('select a.productid, productcode, productname, a.categoryid, categoryname, mainimage from product a
							join product_category b on a.categoryid = b.categoryid
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1 order by insertdate desc, a.productid');
	}

	public function getAllProduct2()
	{
		return DB::select('select distinct a.productid, productname, productcode, categoryname from product a
							join product_category b on a.categoryid = b.categoryid
							where a.isdeleted = 1 ORDER BY categoryname ASC,productname ASC');
	}

	public function getRandomProduct()
	{
		return DB::select('select a.productid, productcode, productname, a.categoryid, categoryname, price, discount, mainimage, subimage, null as color,
							(select count(*) from product a where isdeleted = 1) as count from product a
							join product_category b on a.categoryid = b.categoryid
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1
							order by RAND() limit 4');
	}
	public function getAllProductPaginate($category, $detail, $page,$productCategory=null)
	{
		$temp = '';
		if($category != null)
			$temp = ' and discount != 0 and a.categoryid = '.$category;
		if($category == 'arrival'){
			$date = DB::select('select arrival from settings limit 0, 1')[0]->arrival;
			$temp = ' and (insertdate between date_add(now(), interval -'.$date.' DAY ) and date_add(now(), interval 1 DAY )) and discount = 0';
		}
		else if($category == 'search'){
			$temp = " and (productcode like '%".$detail."%' or productname like '%".$detail."%')";
		}
		else if($category == 'sale'){
			$temp = ' and discount != 0';
		}
		else if($category == 'collection'){
			$productid = DB::select('select collectionproductid from settings limit 0, 1')[0]->collectionproductid;
			$productid = explode(":",$productid);
			$productid = implode(",",$productid);
			$temp = ' and a.productid in ('.$productid.')';
		}

		if($productCategory != null){
			$temp = ' and a.categoryid = '.$productCategory;
		}

		return DB::select('select a.productid, productcode, productname, a.categoryid, categoryname, price, discount, mainimage, subimage, null as color,
							(select count(*) from product a where isdeleted = 1 '.$temp.') as count from product a
							join product_category b on a.categoryid = b.categoryid
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1 '.$temp.' order by insertdate desc, a.productid limit ?, 16', [$page]);
	}

	public function getProductById($id)
	{
		return DB::select('select a.productid, productcode, productname, brandname, a.categoryid, categoryname, price, discount, productdescription, sizechart, sizedetail, null as color, 0 as stock
							from product a
							join product_category b on a.categoryid = b.categoryid
							where a.isdeleted = 1 and a.productid = ?', [$id]);
	}


	//rian
	public function getProductById2($id)
	{
		return DB::select('select Distinct a.productid,productname, colorpath,price,discount,mainimage
											FROM product a
											LEFT JOIN product_detail				b 	ON a.productid = b.productid
											LEFT JOIN product_detail_image 	c 	ON a.productid = c.productid
											LEFT JOIN product_color 				d  	ON c.colorid = d.colorid
											WHERE a.isdeleted = 1 AND a.productid = ?', [$id]);
	}

	public function getAllProductOrderByName()
	{
		return DB::select('select a.productid, productcode, productname, a.categoryid, categoryname, mainimage from product a
							join product_category b on a.categoryid = b.categoryid
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1
							order by productname asc');
	}
	//end rian
	public function getProductByCode($code)
	{
		return DB::select('select * from product where productcode = ? and isdeleted = 1', [$code]);
	}
	public function getProductAllSize($id)
	{
		return DB::select('select a.productid, mainimage, subimage, a.colorid, colorpath, size, stock
							from product_detail a join product_detail_size b on a.productid = b.productid and a.colorid = b.colorid
							join product_color c on a.colorid = c.colorid and b.colorid = c.colorid
							where a.productid = ?', [$id]);
	}
	public function getProductColorByProductId($productid){
		return DB::select('select a.colorid, colorpath, mainimage, subimage, null as size, null as image from product_detail a join product_color b on a.colorid = b.colorid where productid = ?', [$productid]);
	}
	public function getProductSizeByIdColor($productid, $color)
	{
		return DB::select("select a.productid, colorid, a.size, priority, stock - COALESCE(sum(b.quantity), 0) as stock from product_detail_size a
							left join product_size d on a.size = d.size
							left join orderheader c on c.status in ('Pending', 'Waiting') and now() BETWEEN c.insertdate and DATE_ADD(c.insertdate, INTERVAL 1 DAY)
					 		left join orderdetail b on a.productid = b.productid and b.productcolorid = a.colorid and a.size = b.productsize and b.orderno = c.orderno
							where a.productid = ? and a.colorid = ?
                            group by a.productid, a.colorid, a.size, a.stock, priority
							order by priority", [$productid, $color]);
	}
	public function getProductSubImageByIdColor($productid, $color)
	{
		return DB::select('select productid, colorid, subimage from product_detail_image where productid = ? and colorid = ?', [$productid, $color]);
	}
	public function getPopularSample()
	{
		return DB::select('select productcode, mainimage from product a
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1 order by RAND()
							limit 4');
	}
	public function getPopularSampleByCategoryId($categoryId)
	{
		return DB::select('SELECT productcode, mainimage, a.productid, a.categoryid FROM product a
							JOIN product_detail c ON a.productid = c.productid AND c.colorid = (SELECT colorid FROM product_detail WHERE productid = a.productid LIMIT 0, 1)
							WHERE a.isdeleted = 1 AND categoryid = ? ORDER BY RAND()
							LIMIT 4',[$categoryId]);
	}

	public function getPopularSampleByProductId($productId)
	{
		return DB::select('SELECT productcode, mainimage, a.productid FROM product a
							JOIN product_detail c ON a.productid = c.productid AND c.colorid = (SELECT colorid FROM product_detail WHERE productid = a.productid LIMIT 0, 1)
							WHERE a.isdeleted = 1 AND a.productid IN ( '.implode(",",$productId).' ) ORDER BY RAND()');
	}

	public function getArrivalSample()
	{
		return DB::select('select productcode, mainimage from product a
							join product_detail c on a.productid = c.productid and c.colorid = (select colorid from product_detail where productid = a.productid limit 0, 1)
							where a.isdeleted = 1 order by insertdate desc
							limit 4');
	}
	public function deleteProductById($id)
	{
		DB::update('update product set isdeleted = 0 where productid = ?', [$id]);
		DB::delete('delete from product_detail where productid = ?', [$id]);
		
	}
	public function submitProduct($category, $productCode, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail, $sizeSale, $colourImage, $genStock, $genImage)
	{
		DB::insert('insert into product(categoryid, productcode, productname, brandname, price, discount, productdescription, sizechart, sizedetail, insertdate, updatedate, isdeleted) values(?, ?, ?, ?, ?, ?, ?, ?, now(), now(), 1)',
						[$category, $productCode, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail]);
		$id = DB::select('select * from product order by productid desc limit 0, 1')[0]->productid;
		for($i = 1; $i < count($colourImage); $i++){
			DB::insert('insert into product_detail (productid, colorid, mainimage, subimage) select ?, ?, main, back from terminate_product_image where imageid = ?',
						[$id, $colourImage[$i], $genImage[$i-1]]);
			DB::insert('insert into product_detail_image select ?, ?, subimage from terminate_product_subimage where imageid = ?',
						[$id, $colourImage[$i], $genImage[$i-1]]);
			DB::update('update terminate_product_image set isactive = 1, productid = ? where imageid = ?', [$id, $genImage[$i-1]]);
			for($j = 0; $j < count($genStock[$i-1]); $j++){
				DB::insert('insert into product_detail_size values(?, ?, ?, ?)', [$id, $colourImage[$i], $sizeSale[$j+1], $genStock[$i-1][$j]]);
			}
		}
	}
	public function editProduct($productId, $reGenerate, $genSize, $category, $productCode, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail, $sizeSale, $colourImage, $genStock, $genImage)
	{
		DB::update('update product set categoryid = ?, productname = ?, brandname = ?, price = ?, discount = ?, productdescription = ?, sizechart = ?,  sizedetail = ?, updatedate = now() where productid = ?',
						[$category, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail, $productId]);
		if($reGenerate == "true"){
			DB::update('update terminate_product_image set isactive = 0 where productid = ?', [$productId]);
			DB::delete('delete from product_detail where productid = ?', [$productId]);
			DB::delete('delete from product_detail_image where productid = ?', [$productId]);
			DB::delete('delete from product_detail_size where productid = ?', [$productId]);
			for($i = 1; $i < count($colourImage); $i++){
				DB::insert('insert into product_detail (productid, colorid, mainimage, subimage) select ?, ?, main, back from terminate_product_image where imageid = ?',
							[$productId, $colourImage[$i], $genImage[$i-1]]);
				DB::insert('insert into product_detail_image select ?, ?, subimage from terminate_product_subimage where imageid = ?',
							[$productId, $colourImage[$i], $genImage[$i-1]]);
				DB::update('update terminate_product_image set isactive = 1, productid = ? where imageid = ?', [$productId, $genImage[$i-1]]);
				for($j = 0; $j < count($genStock[$i-1]); $j++){
					DB::insert('insert into product_detail_size values(?, ?, ?, ?)', [$productId, $colourImage[$i], $sizeSale[$j+1], $genStock[$i-1][$j]]);
				}
			}
		}
		else
		{
			DB::delete('delete from product_detail_size where productid = ?', [$productId]);
			for($i = 1; $i < count($colourImage); $i++){
				for($j = 0; $j < count($genStock[$i-1]); $j++){
					DB::insert('insert into product_detail_size values(?, ?, ?, ?)', [$productId, $colourImage[$i], $genSize[$i-1][$j], $genStock[$i-1][$j]]);
				}
			}
		}
	}

	public function getProductColor()
	{
		return DB::select('select * from product_color where isdeleted = 1');
	}
	public function addProductColor($colorPath)
	{
		DB::insert('insert into product_color(colorpath, isdeleted) values(?, 1)', [$colorPath]);
	}
	public function deleteProductColor($id)
	{
		DB::update('update product_color set isdeleted = 0 where colorid = ?', [$id]);
	}

	public function getTerminateImages()
	{
		return DB::select('select imageid, main, back, productid, null as sub from terminate_product_image where isactive = 0');
	}
	public function getTerminateSubImagesById($id)
	{
		return DB::select('select * from terminate_product_subimage where imageid = ?', [$id]);
	}
	public function addTerminateProductImage($main, $back, $subs)
	{
		DB::insert('insert into terminate_product_image(main, back, productid, isactive) values(?, ?, 0, 0)', [$main, $back]);
		$id = DB::select('select * from terminate_product_image order by imageid desc limit 0, 1')[0]->imageid;
		foreach($subs as $sub){
			DB::insert('insert into terminate_product_subimage values(?, ?)', [$id, $sub]);
		}
	}
	public function deleteTerminateProductImage($id)
	{
		DB::delete('delete from terminate_product_image where imageid = ?', [$id]);
		DB::delete('delete from terminate_product_subimage where imageid = ?', [$id]);
	}

	public function getAllProductCategory()
	{
		return DB::select('select * from product_category where isdeleted = 1');
	}
	public function getProductCategoryById($id)
	{
		return DB::select('select * from product_category where isdeleted = 1 and categoryid = ?', [$id]);
	}
	public function getProductCategoryByName($name)
	{
		return DB::select('select * from product_category where isdeleted = 1 and categoryname = ?', [$name]);
	}
	public function addProductCategory($categoryName)
	{
		DB::insert('insert into product_category(categoryname, isdeleted) values(?, 1)', [$categoryName]);
	}
	public function editProductCategory($categoryId, $categoryName)
	{
		DB::update('update product_category set categoryname = ? where categoryid = ?', [$categoryName, $categoryId]);
	}
	public function deleteProductCategoryById($id)
	{
		DB::update('update product_category set isdeleted = 0 where categoryid = ?', [$id]);
	}
	public function deleteProductValidate($const, $id)
	{
		return DB::select("select * from product a join product_detail b on a.productid = b.productid where case ? when 'category' then categoryid else colorid end = ?", [$const, $id]);
	}
}
