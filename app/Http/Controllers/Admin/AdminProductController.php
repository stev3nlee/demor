<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;

class AdminProductController extends Controller
{
    public function product(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product', 'path'=>'admin/commerce/product']
		];

		$product = new Product;
        return view('admin/store/product/index', ['admin'=>$admin, 'products'=>$product->getAllProduct(), 'breadCrumb'=>$breadCrumb]);
    }
	public function viewProduct(Request $request, $id)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product', 'path'=>'admin/commerce/product'],
			(object)['name' =>'View Product', 'path'=>'admin/commerce/view/'.$id]
		];

		$product = new Product;
		$prod = $product->getProductById($id)[0];
		$sizes = $product->getProductAllSize($id);

        return view('admin/store/product/view', ['admin'=>$admin, 'product'=>$prod, 'sizes'=>$sizes, 'breadCrumb'=>$breadCrumb]);
	}
	public function addProduct(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product', 'path'=>'admin/commerce/product'],
			(object)['name' =>'Add Product', 'path'=>'admin/commerce/product/addproduct/']
		];

		$product = new Product;
		$images = $product->getTerminateImages();
		foreach($images as $image)
		{
			$image->sub = $product->getTerminateSubImagesById($image->imageid);
		}

		return view('admin/store/product/add', [
			'admin'=>$admin, 'categories'=>$product->getAllProductCategory(),
			'colors'=>$product->getProductColor(),
			'images'=>$images,
			'breadCrumb'=>$breadCrumb
		]);
	}

	public function editProduct(Request $request, $id)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product', 'path'=>'admin/commerce/product'],
			(object)['name' =>'Edit Product', 'path'=>'admin/commerce/product/editproduct/']
		];

		$product = new Product;
		$images = $product->getTerminateImages();
		foreach($images as $image)
		{
			$image->sub = $product->getTerminateSubImagesById($image->imageid);
		}
		$prod = $product->getProductById($id)[0];
		$prod->color = $product->getProductColorByProductId($id);
		foreach($prod->color as $color)
		{
			$color->size = $product->getProductSizeByIdColor($id, $color->colorid);
		}

		return view('admin/store/product/edit', [
			'admin'=>$admin,
			'product'=>$prod,
			'categories'=>$product->getAllProductCategory(),
			'colors'=>$product->getProductColor(),
			'images'=>$images,
			'breadCrumb'=>$breadCrumb
		]);
	}

	public function imageProduct(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product Image', 'path'=>'admin/commerce/product/image']
		];

		$product = new Product;
		$images = $product->getTerminateImages();
		foreach($images as $image)
		{
			$image->sub = $product->getTerminateSubImagesById($image->imageid);
		}

		return view('admin/store/product/image', ['admin'=>$admin, 'images'=>$images, 'breadCrumb'=>$breadCrumb]);
	}

	public function deleteImageProduct(Request $request)
	{
		$product = new Product;
		$id = $request->input('deleteId');

		$product->deleteTerminateProductImage($id);
		return redirect('meisjejongetje/commerce/product/image')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted the product image.']);
	}

	public function submitImageProduct(Request $request)
	{
		$product = new Product;

		if($request->file('uploadMainImage') != null && $request->file('uploadBackImage') != null && $request->file('uploadSubImage') != null)
		{
			$images = $request->file('uploadSubImage');
			$destinationFile = "productimage";
			$pageImage1 = '';
			$pageImage2 = '';
			$pageImage3 = [];

			if ($request->file('uploadMainImage')->isValid()) {
				$extension = $request->file('uploadMainImage')->getClientOriginalExtension();
				$filename = rand(11111111,99999999).'.'.$extension;
				$request->file('uploadMainImage')->move($destinationFile, "main".$filename);
				$pageImage1 = $destinationFile."/main".$filename;
			}
			if ($request->file('uploadBackImage')->isValid()) {
				$extension = $request->file('uploadBackImage')->getClientOriginalExtension();
				$filename = rand(11111111,99999999).'.'.$extension;
				$request->file('uploadBackImage')->move($destinationFile, "back".$filename);
				$pageImage2 = $destinationFile."/back".$filename;
			}
			foreach($images as $image){
				if ($image->isValid()) {
					$extension = $image->getClientOriginalExtension();
					$filename = rand(11111111,99999999).'.'.$extension;
					$image->move($destinationFile, "sub".$filename);
					array_push($pageImage3, $destinationFile."/sub".$filename);
				}
			}
			$product->addTerminateProductImage($pageImage1, $pageImage2, $pageImage3);
			return redirect('meisjejongetje/commerce/product/image')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added new product image.']);
		}
		return redirect('meisjejongetje/commerce/product/image')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please add any images at the bottom of the page earlier before submit the data.']);
	}
	public function colorProduct(Request $request)
	{
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');
		$product = new Product;

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Add Color', 'path'=>'admin/commerce/product/color']
		];

		return view('admin/store/product/color', ['admin'=>$admin, 'colors'=>$product->getProductColor(), 'breadCrumb'=>$breadCrumb]);
	}

	public function deleteColor(Request $request)
	{
		$product = new Product;
		$id = $request->input('deleteId');
		if(count($product->deleteProductValidate('color', $id)) != 0)
		{
			return redirect('meisjejongetje/commerce/product/color')->with('message', (object)['type'=>'alert-warning', 'content'=>'Warning: You cannot delete this color. The existing products are using this color.']);
		}

		$product->deleteProductColor($id);
		return redirect('meisjejongetje/commerce/product/color')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this color.']);
	}

	public function submitColor(Request $request)
	{
		$product = new Product;
		if($request->file('addColor') != null)
		{
			if ($request->file('addColor')->isValid()) {
				$destinationFile = "productimage/color";
				$extension = $request->file('addColor')->getClientOriginalExtension();
				$filename = rand(11111,99999).'.'.$extension;
				$request->file('addColor')->move($destinationFile, $filename);
				$pageImage = $destinationFile."/".$filename;

				$product->addProductColor($pageImage);
				return redirect('meisjejongetje/commerce/product/color')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added new color.']);
			}
		}
		return redirect('meisjejongetje/commerce/product/color')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please add any image at the bottom of the page earlier before submit the data.']);
	}
	public function submitProduct(Request $request)
	{
		$product = new Product;
		$category = $request->input('category');
		$productCode = $request->input('productCode');
		$productName = $request->input('productName');
		$brandName = $request->input('brandName');
		$price = ($request->input('price') == null ? 0 : $request->input('price'));
		$sale = ($request->input('sale')==null ? 0 : $request->input('sale'));
		$productDescription = $request->input('productDescription');
		$sizeChart = $request->input('sizeChart');
		$sizeDetail = $request->input('sizeDetail');
		$countColor = $request->input('countColor');
		$sizeSale = $request->input('sizeSale');
		$colourImage = $request->input('colourImage');
		$genStock = [];
		$genImage= [];

		if(count($product->getProductByCode($productCode)) != 0)
		{
			return ['success' => false, 'msg' => 'The product code has already been taken'];
		}
		else
		{
			for($i=0; $i<$countColor;$i++)
			{
				array_push($genStock, $request->input('genStock'.$i));
				array_push($genImage, $request->input('inputimage'.$i));
			}
			
			$product->submitProduct($category, $productCode, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail, $sizeSale, $colourImage, $genStock, $genImage);
			$request->session()->flash('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added this product.']);
			return ['success' => true];
		}
	}
	public function submitEditProduct(Request $request)
	{
		$product = new Product;
		$productId = $request->input('productId');
		$reGenerate = $request->input('reGenerate');
		$category = $request->input('category');
		$productCode = $request->input('productCode');
		$productName = $request->input('productName');
		$brandName = $request->input('brandName');
		$price = ($request->input('price')==null ? 0 : $request->input('price'));
		$sale = ($request->input('sale')==null ? 0 : $request->input('sale'));
		$productDescription = $request->input('productDescription');
		$sizeChart = $request->input('sizeChart');
		$sizeDetail = $request->input('sizeDetail');
		$countColor = $request->input('countColor');
		$sizeSale = $request->input('sizeSale');
		$colourImage = $request->input('colourImage');
		$genStock = [];
		$genImage = [];
		$genSize = [];

		for($i=0; $i<$countColor;$i++)
		{
			array_push($genStock, $request->input('genStock'.$i));
			array_push($genImage, $request->input('inputimage'.$i));
			array_push($genSize, $request->input('genSize'.$i));
		}
		$product->editProduct($productId, $reGenerate, $genSize, $category, $productCode, $productName, $brandName, $price, $sale, $productDescription, $sizeChart, $sizeDetail, $sizeSale, $colourImage, $genStock, $genImage);
		$request->session()->flash('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this product.']);
		return ['success' => true];
	}
	public function deleteProduct(Request $request)
	{
		$product = new Product;
		$id = $request->input('deleteId');

		$product->deleteProductById($id);
		return redirect('meisjejongetje/commerce/product')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this product.']);
	}

    public function productCategory(Request $request)
    {
		$admin = $request->session()->get('admin');
		if($admin == null) return redirect('meisjejongetje/');

		$breadCrumb = [
			(object)['name' =>'Commerce', 'path'=>''],
			(object)['name' =>'Store', 'path'=>''],
			(object)['name' =>'Product Category', 'path'=>'admin/commerce/productcategory']
		];

		$product = new Product;
        return view('admin/store/category/index', ['admin'=>$admin, 'categories'=>$product->getAllProductCategory(), 'breadCrumb'=>$breadCrumb]);
    }
	public function addProductCategory(Request $request)
	{
		$product = new Product;
		$categoryName = $request->input('categoryName');

		if($categoryName == '')
		{
			return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the category name.']);
		}
		else if($product->getProductCategoryByName($categoryName))
		{
			return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-warning', 'content'=>'The category name has already been taken.']);
		}

		$product->addProductCategory($categoryName);
		return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully added new product.']);
	}
	public function editProductCategory(Request $request)
	{
		$product = new Product;
		$categoryId = $request->input('editCategoryId');
		$categoryName = $request->input('editCategoryName');

		if($categoryName == '')
		{
			return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-warning', 'content'=>'Please fill in the category name.']);
		}
		else if($product->getProductCategoryByName($categoryName))
		{
			return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-warning', 'content'=>'The category name has already been taken.']);
		}

		$product->editProductCategory($categoryId, $categoryName);
		return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully edited this product.']);
	}
	public function deleteProductCategory(Request $request)
	{
		$product = new Product;
		$id = $request->input('deleteId');
		if(count($product->deleteProductValidate('category', $id)) != 0)
		{
			return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-warning', 'content'=>'Warning: You cannot delete this category. The existing products are using this category.']);
		}

		$product->deleteProductCategoryById($id);
		return redirect('meisjejongetje/commerce/productcategory')->with('message', (object)['type'=>'alert-success', 'content'=>'You have successfully deleted this category.']);
	}
}
