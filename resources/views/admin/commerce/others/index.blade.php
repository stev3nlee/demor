@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')
	@php $x=1; $countProductId=[0]; $countCollectionProductId=[0];
		if(!empty($others->productid)) {
			$countProductId = explode(":",$others->productid);
		}

		if(!empty($others->collectionproductid)) {
			$countCollectionProductId = explode(":",$others->collectionproductid);
		}
	@endphp
	<script>
	$(function() {
		$('li#general').addClass ('active');
		$('.deleteProduct').click(function(){
			$('.pd'+$(this).attr('data-value')).remove();
			calculate()
		});
		var c = {{count($countProductId)}};
		$('.addProduct').click(function(){
			var clone = $('.hiddenProduct').clone().removeAttr('class').removeClass('hidden').attr('class', 'pd'+c+" copy");
			clone.find('.deleteProduct').attr('data-value', c);
			$('.productTemp').append(clone);
			c++;
			calculate()
			$('.deleteProduct').unbind().click(function(){
				$('.pd'+$(this).attr('data-value')).remove();
				calculate()
			});
		});
		$('.deleteProduct').click(function(){
			$('.pd'+$(this).attr('data-value')).remove();
			calculate()
		});
		function calculate()
		{
			var i=2;
			$('.copy').each(function(){
				$(this).find($('.numberProduct')).html(i)
				i++;
			})
		}

		$('.deleteProduct2').click(function(){
			$('.pd2'+$(this).attr('data-value')).remove();
			calculate2()
		});
		var d = {{count($countCollectionProductId)}};
		$('.addProduct2').click(function(){
			var clone = $('.hiddenProduct').clone().removeAttr('class').removeClass('hidden').attr('class', 'pd2'+d+" copy2");
			clone.find('.deleteProduct').attr('data-value', d).attr('class','display-inline deleteProduct2');
			clone.find('.numberProduct').attr('class','numberProduct2');
			clone.find('.select_product').attr('name','collectionProduct[]');
			$('.productTemp2').append(clone);
			d++;
			calculate2()
			$('.deleteProduct2').unbind().click(function(){
				$('.pd2'+$(this).attr('data-value')).remove();
				calculate2()
			});
		});
	});
	$('.deleteProduct2').click(function(){
		$('.pd2'+$(this).attr('data-value')).remove();
		calculate()
	});
	function calculate2()
	{
		var j=2;
		$('.copy2').each(function(){
			$(this).find($('.numberProduct2')).html(j)
			j++;
		})
	}
	</script>
	<form method="post" action="{{ url('meisjejongetje/commerce/others/submitothers') }}" enctype="multipart/form-data">
		<div class="content">
			<div class="breadcrumb">
				@foreach($breadCrumb as $index => $b)
					@if($b->path == '')
						<span class="active">{{$b->name}}</span>
					@else
						<a href="{{ url($b->path) }}">{{$b->name}}</a>
					@endif
					@if($index != count($breadCrumb) - 1)
						<span class="m10"> > </span>
					@endif
				@endforeach
			</div>
			<div class="title">Others</div>
			<div class="clearfix mb30">
				<div class="display-inline mr10 pos-det">Tax VAT :</div>
				<div class="display-inline mr10">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="text" required class="form-control txtboxToFilter" maxlength="4" name="tax" value="{{$others->tax}}" style="width: 55px;"/>
				</div>
				<div class="display-inline pos-det">%</div>
			</div>
			<div class="clearfix">
				<div class="display-inline pos-det mr10">New arrival page: items stay on the page for </div>
				<div class="display-inline mr10">
					<input type="text" required class="form-control txtboxToFilter" maxlength="2" name="arrival" value="{{$others->arrival / 7}}" style="width: 40px;"/>
				</div>
				<div class="display-inline pos-det">weeks.</div>
			</div>
			<div class="border-line"></div>
			<div class="title">Homepage</div>
			<div class="clearfix mb30">
				<div class="display-inline mr10 pos-det" style="width: 120px;">Collection Name :</div>
				<div class="display-inline">
					<input type="text" required class="form-control" name="submenuname" value="{{$others->submenuname}}" style="width: 200px;"/>
				</div>
			</div>
			<div id="myRadioGroup" class="clearfix">
				<div style="float: left; width: 350px;">
					<div class="mb30">
						<input type="radio" name="select_method" @if($others->method == 1) checked @endif value="1" style="position: relative; top: 1px;"/><span style="margin-left: 5px;">Category</span>
					</div>
					<div style="margin-bottom:20px;"> Show products/banners to its category page </div>
					<div id="method1" class="desc">
						<div class="clearfix">
							<div class="display-inline mr10 pos-det" style="width: 80px;">Category:</div>
							<div class="display-inline">
								<select class="custom-select form-control" style="width: 200px;"  id="selectMe" name="category" onchange="custom_select(this)">
									<option value="0" disabled selected>Category</option>
									@foreach($categories as $category)
									<option value="{{$category->categoryid}}" @if($category->categoryid == $others->categoryid) selected @endif>{{$category->categoryname}}</option>
									@endforeach
								</select>
							</div>
							<div class="mt10 mb10">
								 <input type="checkbox" name="use_banner" value="1" @if($others->withbanner == 1) checked @endif> Do you want to use Banner? 
							</div>
							<div class="display-inline mr20 mt10">
								@if(!empty($others->categorybanner))
									@php $imgTemp=[]; @endphp
									@foreach(explode(":",$others->categorybanner) as $img)
									<img src="{{asset($img)}}" width="136" height="204"/>
										@php $imgTemp[]=$img; @endphp
									@endforeach
									@php $imgTemp=implode(":",$imgTemp); @endphp
								@endif
								<input type="hidden" value="{{$imgTemp}}" name="hidCategoryBanner"/>
								<div class="form-group">
									<label>Banner Images<span class="red">*</span></label>
									<input type="file" name="categoryBanner[]" multiple>
									<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
									<div>Pic Resolution : 1080 × 1455 pixels</div>
									<div>Maximum File Size : 1MB</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div style="float: left; margin-left: 30px;">
					<div class="mb30">
						<input type="radio" name="select_method" @if($others->method == 2) checked @endif value="2" style="position: relative; top: 1px;" /><span style="margin-left: 5px;">Product</span>
					</div>
					<!-- SHOW PRODUCTS CLICKED AUTOMATICALLY TO ITS PRODUCT DETAILS -->
					<div style="float: left;">
						<div style="margin-bottom:20px;"> Show Products and clicked to its product details. </div>
						<div id="method2" class="desc">
							@foreach($countProductId as $coll)
							<div class="clearfix mb10 @if($x>1) pd{{$x-1}} copy @endif">
								<div class="display-inline mr10 pos-det" style="width: 80px;">Product <span class="numberProduct">{{$x}}</span> :</div>
								<div class="display-inline">
									<select class="custom-select form-control" style="width: 200px; margin-bottom: 10px;" name="product[]" onchange="custom_select(this)">
										@foreach($products as $product)
										<option value="{{$product->productid}}" @if($coll == $product->productid) selected @endif>{{$product->categoryname}} - {{$product->productcode}} - {{$product->productname}}</option>
										@endforeach
									</select>
								</div>
								@if($x>1)
								<div class="display-inline deleteProduct" style="position: relative; top: 4px; left: -2px;" data-value="{{$x-1}}">
									<div class="icon-incorrect"></div>
								</div>
								@endif
							</div>
							<?php $x++; ?>
							@endforeach
							<div class="productTemp"></div>
							<div class="clearfix mb10">
								<div class="display-inline mr10" style="width: 80px;"></div>
								<div class="display-inline"><button type="button" class="btn btn-auto addProduct">Add Product</button></div>
							</div>
						</div>
					</div>
				</div>
				<!-- END SHOW PRODUCTS CLICKED AUTOMATICALLY TO ITS PRODUCT DETAILS -->
				<!-- SHOW BANNER CLICKED AUTOMATICALLY TO ITS CHOSEN PRODUCT PAGE -->
				<div style="float: left; margin-left:50px;">
					<div class="mb30">
						<input type="radio" name="select_method" @if($others->method == 3) checked @endif value="3" style="position: relative; top: 1px;" /><span style="margin-left: 5px;">Product Banner</span>
					</div>
					<div style="margin-bottom:20px;"> Show banner and clicked to its chosen products. </div>
					<div class="display-inline">
						@if(!empty($others->collectionbanner))
							@php $imgTemp=[]; @endphp
							@foreach(explode(":",$others->collectionbanner) as $img)
							<img src="{{asset($img)}}" width="136" height="204"/>
								@php $imgTemp[]=$img; @endphp
							@endforeach
							@php $imgTemp=implode(":",$imgTemp); @endphp
						@endif
						<input type="hidden" value="{{$imgTemp}}" name="hidCollectionBanner"/>
						<div class="form-group">
							<label>Banner Images<span class="red">*</span></label>
							<input type="file" name="collectionBanner[]" multiple>
							<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
							<div>Pic Resolution : 1080 × 1455 pixels</div>
							<div>Maximum File Size : 1MB</div>
						</div>
					</div>
					@php $x=1; @endphp
					@foreach($countCollectionProductId as $coll)
					<div class="clearfix mb10 @if($x>1) pd2{{$x-1}} copy2 @endif">
						<div class="display-inline mr10 pos-det" style="width: 80px;">Product <span class="numberProduct2">{{$x}}</span> :</div>
						<div class="display-inline">
							<select class="custom-select form-control" style="width: 200px; margin-bottom: 10px;" name="collectionProduct[]" onchange="custom_select(this)">
								@foreach($products as $product)
								<option value="{{$product->productid}}" @if($coll == $product->productid) selected @endif>{{$product->categoryname}} - {{$product->productcode}} - {{$product->productname}}</option>
								@endforeach
							</select>
						</div>
						@if($x>1)
						<div class="display-inline deleteProduct2" style="position: relative; top: 4px; left: -2px;" data-value="{{$x-1}}">
							<div class="icon-incorrect"></div>
						</div>
						@endif
					</div>
					<?php $x++; ?>
					@endforeach
					<div class="productTemp2"></div>
					<div class="clearfix mb10">
						<div class="display-inline mr10" style="width: 80px;"></div>
						<div class="display-inline"><button type="button" class="btn btn-auto addProduct2">Add Product</button></div>
					</div>
					<!-- END SHOW BANNER CLICKED AUTOMATICALLY TO ITS CHOSEN PRODUCT PAGE -->
				</div>
			</div>
			<div style="margin-top: 20px; clear: both;">
				<button type="submit" class="btn btn-auto">UPDATE</button>
			</div>
		</div>
	</form>
	<div class="hidden hiddenProduct">
		<div class="mb10">
			<div class="display-inline mr10 pos-det" style="width: 80px;">Product <span class="numberProduct"></span>:</div>
			<div class="display-inline mr10">
				<select class="custom-select form-control select_product" style="width: 200px; margin-bottom: 10px;" name="product[]" onchange="custom_select(this)">
					@foreach($products as $product)
					<option value="{{$product->productid}}">{{$product->categoryname}} - {{$product->productcode}} - {{$product->productname}}</option>
					@endforeach
				</select>
			</div>
			<div class="display-inline deleteProduct" style="position: relative; top: 4px; left: -2px;">
				<div class="icon-incorrect "></div>
			</div>
		</div>
	</div>

@endsection
