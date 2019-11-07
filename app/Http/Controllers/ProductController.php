<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\General;

class ProductController extends Controller
{
    public function index(Request $request)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Shop', 'path'=>'']
		];
		return $this->getProducts($request, null, null, 1, $breadCrumb);
    }

    public function indexPage(Request $request, $page)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Shop', 'path'=>'']
		];
		return $this->getProducts($request, null, null, $page, $breadCrumb);
    }
	public function saleByCategory(Request $request, $category)
	{
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Sale', 'path'=>'product/sale']
		];
		return $this->getProducts($request, $category, null, 1, $breadCrumb);
	}
	public function saleByCategoryPage(Request $request, $category, $page)
	{
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Sale', 'path'=>'product/sale']
		];
		return $this->getProducts($request, $category, null, $page, $breadCrumb);
	}
    public function arrival(Request $request)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'New Arrivals', 'path'=>'']
		];
		return $this->getProducts($request, 'arrival', null, 1, $breadCrumb);
    }
    public function arrivalPage(Request $request, $page)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'New Arrivals', 'path'=>'']
		];
		return $this->getProducts($request, 'arrival', null, $page, $breadCrumb);
    }
    public function sale(Request $request)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Sale', 'path'=>'']
		];
		return $this->getProducts($request, 'sale', null, 1, $breadCrumb);
    }
    public function salePage(Request $request, $page)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Sale', 'path'=>'']
		];
		return $this->getProducts($request, 'sale', null, $page, $breadCrumb);
    }
    public function search(Request $request)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Search', 'path'=>'']
		];
		$search = $request->input('search');
		return $this->getProducts($request, 'search', $search, 1, $breadCrumb);
    }
    public function searchEmptyPage(Request $request, $page)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Search', 'path'=>'']
		];
		$search = '';
		return $this->getProducts($request, 'search', $search, $page, $breadCrumb);
    }
    public function searchPage(Request $request, $search, $page)
    {
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Search', 'path'=>'']
		];
		return $this->getProducts($request, 'search', $search, $page, $breadCrumb);
    }
	public function detailById(Request $request, $id)
	{
		$general = new General;
		$product = new Product;

		$prod = $product->getProductById($id)[0];
		$prod->color = $product->getProductColorByProductId($id);
		$subImageCount = 0;
		foreach($prod->color as $color)
		{
			$color->size = $product->getProductSizeByIdColor($id, $color->colorid);
			$color->image = $product->getProductSubImageByIdColor($id, $color->colorid);
			foreach($color->size as $size)
				$prod->stock += $size->stock;

			
		}
		if($subImageCount < count($color->image))
				$subImageCount = count($color->image);
		$breadCrumb = [
			(object)['name' =>'Home', 'path'=>'/'],
			(object)['name' =>'Shop', 'path'=>'product'],
			(object)['name' =>$prod->productname, 'path'=>'']
		];

		$randoms = $product->getRandomProduct();
		foreach($randoms as $random){
			$random->color = $product->getProductColorByProductId($random->productid);
		}

        return view('product/detail', [
			'general'=>$general->getAll($request),
			'product'=>$prod,
			'randoms'=>$randoms,
			'subImageCount'=>$subImageCount,
			'breadCrumb'=>$breadCrumb
		]);
	}
  public function indexcategory(Request $request,$productCategory)
  {
  $breadCrumb = [
    (object)['name' =>'Home', 'path'=>'/'],
    (object)['name' =>'Shop', 'path'=>''],
  ];
  return $this->getProducts($request, null, null, 1, $breadCrumb,$productCategory);
  }
  public function indexcategoryPage(Request $request,$productCategory, $page)
  {
  $breadCrumb = [
    (object)['name' =>'Home', 'path'=>'/'],
    (object)['name' =>'Shop', 'path'=>'']
  ];
  return $this->getProducts($request, null, null, $page, $breadCrumb,$productCategory);
  }

  public function collection(Request $request)
  {
  $breadCrumb = [
    (object)['name' =>'Home', 'path'=>'/'],
    (object)['name' =>'Collection', 'path'=>'']
  ];
  return $this->getProducts($request, 'collection', null, 1, $breadCrumb);
  }

  public function collectionPage(Request $request, $page)
  {
  $breadCrumb = [
    (object)['name' =>'Home', 'path'=>'/'],
    (object)['name' =>'Collection', 'path'=>'']
  ];
  return $this->getProducts($request, 'collection', null, $page, $breadCrumb);
  }

	public function getProducts($request, $category, $detail, $page, $breadCrumb ,$productCategory=null)
	{
		$general = new General;
		$product = new Product;

		$products = $product->getAllProductPaginate($category, $detail, ($page - 1) * 16,$productCategory);
    if($productCategory != null){
      $category = $productCategory;
    }
		if(null != $category && $category != 'arrival' && $category != 'search' && $category != 'sale' && $category != 'collection')
		{
			array_push($breadCrumb, (object)['name' =>$product->getProductCategoryById($category)[0]->categoryname, 'path'=>'']);
		}
		foreach($products as $prod){
			$prod->color = $product->getProductColorByProductId($prod->productid);
		}
    return view('product/sale', [
			'general'=>$general->getAll($request),
			'title'=>($category == null ? 'Shop' : ($category == 'sale' ? 'Sale' : ($category == 'arrival' ? 'NEW ARRIVALS' : ($category == 'collection' ? 'Collection' : ($category == 'search' ? 'SEARCH RESULT' : $product->getProductCategoryById($category)[0]->categoryname))))),
			'linkPages'=> ($category == null ? 'product' : ($category == 'sale' ? 'product/sale' : ($category == 'arrival' ? 'product/arrival': ($category == 'collection' ? 'product/collection': ($category == 'search' ? 'product/search/'.$detail : ($category != null && $productCategory != null ? 'product/categories/'.$productCategory : 'product/category/'.$category)))))),
			'page'=>$page,
			'detail'=>$detail,
			'products'=>$products,
			'breadCrumb'=>$breadCrumb
		]);
	}
}
