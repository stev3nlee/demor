@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

<script>
$(function() {
	$(document).ready(function() {	
		$('#store > ul.submenu').addClass ('open');
		$('li#store').addClass ('open');
		$('#product').addClass ('active');
		
		var c = 0;
		var d = 0;
		var countColor = 0;
		var countSize = 0;
		var colorId = [];
		var sizeId = [];
		var imageId = [];
		var editFlag = true;
		
		function generatePrice()
		{
			var price = ($('[name=price]').val() == '' ? 0 : $('[name=price]').val());
			var sale = ($('[name=sale]').val() == '' ? 0: $('[name=sale]').val()) ;
			
			$('[name=totalPrice]').val(price - (price * sale / 100));
		}
		
		function removeArray(array, element) {
			var index = array.indexOf(element);
			while (index !== -1) {
				array.splice(index, 1);
				index = array.indexOf(element);
			}
		}
		
		$('[name=price]').blur(function(){
			generatePrice();
		});
		$('[name=sale]').blur(function(){
			generatePrice();
		});
		
		$('.colorClick').click(function(){
			var flag = true;
			for(var i = 0; i < colorId.length; i++)
			{
				if(colorId[i] == $(this).attr('data-path'))
				{
					alert('The color you chose has been taken');
					flag = false;
					break;
				}
			}
			if(flag)
			{
				var clone = $('#hiddenClass').clone().removeAttr('id').removeClass('hidden').attr('id', 'clr'+$(this).attr('data-value'));
				clone.find("input").val($(this).attr('data-value'));
				clone.find("#colorImage").attr('src',$(this).attr('data-path'));
				clone.find('.deleteColor').attr('data-value', $(this).attr('data-value')).attr('data-path', $(this).attr('data-path'));
				
				$('#colorTemp').append(clone);
				colorId.push($(this).attr('data-path'));
				countColor++;
				
				$('.deleteColor').unbind().click(function(){
					removeArray(colorId, $(this).attr('data-path'));
					$('#clr'+$(this).attr('data-value')).remove();
				});
				
				$.fancybox.close();
			}
		});
		
		//$('.addImage').click(function(e){
		$('#table_id').on('click','.addImage',function(e){
			var flag = true;
			for(var i = 0; i < imageId.length; i++)
			{
				if(imageId[i] == $(this).attr('data-id'))
				{
					alert('The image you chose has been taken.');
					flag = false;
					break;
				}
			}
			if(flag)
			{
				//$('#input'+$(this).attr('data-value')).val($(this).attr('data-id'));
				//$('#image'+$(this).attr('data-value')).attr('src', $(this).attr('data-path'));
				$('#input'+$('#table_id').attr('data-value')).val($(this).attr('data-id'));
				$('#image'+$('#table_id').attr('data-value')).attr('src', $(this).attr('data-path'));
				imageId.push($(this).attr('data-id'));
				$.fancybox.close();
			}
		});
		
		$('#addLength').click(function(){
				var clone = $('#hiddenLength').clone().find("input:text").val("").end().removeAttr('id').removeClass('hidden').attr('id', 'lh'+d);
				clone.find('.deleteLength').attr('data-value', d);
				$('#lengthTemp').append(clone);
				//countSize++;
				d++;

				$('.deleteLength').unbind().click(function(){
					$('#lh'+$(this).attr('data-value')).remove();
					//countSize--;
				});
		});

		$('#addSize').click(function(){
			if(countSize < 5)
			{
				var clone = $('#hiddenSize').clone().removeAttr('id').removeClass('hidden').attr('id', 'sz'+c);
				clone.find('.deleteSize').attr('data-value', c);
				$('#sizeTemp').append(clone);
				countSize++;
				c++;
				
				$('.deleteSize').unbind().click(function(){
					$('#sz'+$(this).attr('data-value')).remove();
					countSize--;
				});
			}
		});
		
		$('#generateDetailClick').click(function(){
			editFlag = false;
			var z = 0;
			sizeId = [];
			imageId = [];
			$('[name^=sizeSale]').each(function(){
				if(this.value != ''){
					z++;
					sizeId.push(this.value);
				}
			});
			if(countColor == 0)
			{
				alert('Please pick any color for this product');
				return;
			}
			if(countSize != z || countSize == 0)
			{
				alert('Please pick any size for this product');
				return
			}
			var html = '';
			for(var i = 0; i < countColor; i++)
			{
				html += '<div class="form-group mb20"><label>Product Details <span><input type="hidden" name="countColor" value="'+countColor+'"/><img src="'+colorId[i]+'"/></span></label>';
				for(var j = 0; j < countSize; j++)
				{
					html += '<div class="clearfix mb20"><div class="display-inline mr20"><div class="display-inline mr10 pos-det">Size <span class="red">*</span> :</div><div class="display-inline"><input type="text" required class="form-control txtboxToFilter" maxlength="4" name="genSize'+i+'[]" value="'+sizeId[j]+'" style="width: 50px;" disabled /></div></div><div class="display-inline mr20"><div class="display-inline mr10 pos-det">Stock <span class="red">*</span> :</div><div class="display-inline"><input type="text" required class="form-control txtboxToFilter" maxlength="4" name="genStock'+i+'[]" style="width: 50px;"/></div></div></div>';
				}
				html += '<div class="display-inline"><a type="button" data-value="image'+i+'" class="btn btn-small addImageClick mb20">Add Image</a><input type="hidden" name="inputimage'+i+'" id="inputimage'+i+'" /><div class="w200"><img id="imageimage'+i+'" src="" class="img-responsive" /></div></div>';
				html += '</div>';
			}
			$('[name=reGenerate]').val(true);
			$('#tempGenerate').html(html);
			$('.addImageClick').click(function(e){
				$.fancybox.open({
					href: '#image'
				});
				//$('.addImage').attr('data-value', $(this).attr('data-value'));
				$('#table_id').attr('data-value', $(this).attr('data-value'));
			});
		});	
		
		$('#submitProduct').submit(function(e){
			e.preventDefault();
			if(!editFlag && countColor == 0)
			{
				alert('Please pick any color for this product');
				return;
			}
			if(!editFlag && (countSize != sizeId.length || countSize == 0))
			{
				alert('Please pick any size for this product');
				return;
			}

			var tinyMceDesc = ['product description', 'size chart'];
			for (var i=0; i < tinymce.editors.length; i++){
				var content = tinymce.editors[i].getContent();
				if(null == content || "" == content){
					alert("Please fill in the " + tinyMceDesc[i] + " field.");
					return;
				}
			}	

		
			$('.' + 'productDesc').html( tinymce.get('mceFixed').getContent() );
			$('.' + 'sizeChart').html( tinymce.get('mceFixed2').getContent() );
			$('.' + 'sizeDetail').html( tinymce.get('mceFixed2').getContent() );
			
			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/commerce/product/submiteditproduct') }}",
				data: $("#submitProduct").serialize(),
				dataType: 'json',
				success: function (data) {
					//console.log(data);
					location.href = "{{url('meisjejongetje/commerce/product')}}";
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
	});
});
</script>
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
		<div class="title">Edit Product</div>
		<form id="submitProduct" method="post" enctype="multipart/form-data">
			<div class="row clearfix">
				<div class="wdth50">
					<div class="form-group">
						<label>Category <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="productId" value="{{ $product->productid }}" />
						<input type="hidden" name="reGenerate" value="false" />
						<select class="custom-select form-control" name="category" onchange="custom_select(this)">
							@foreach($categories as $category)
								<option value="{{ $category->categoryid }}" @if($category->categoryid == $product->categoryid) selected @endif>{{ $category->categoryname }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Product Code <span class="red">*</span></label>
						<input type="text" required class="form-control" name="productCode" value="{{$product->productcode}}" disabled />
					</div>
					<div class="form-group">
						<label>Product Name <span class="red">*</span></label>
						<input type="text" required class="form-control" name="productName" value="{{$product->productname}}" />
					</div>
					<div class="form-group">
						<label>Brand Name</label>
						<input type="text" class="form-control" name="brandName" value="{{$product->brandname}}" />
					</div>
					<div class="clearfix mb30">
						<div class="display-inline mr10">
							<label>Price <span class="red">*</span></label>
							<div class="clearfix">
								<div class="display-inline mr10">
									<div style="height: 30px; margin: auto 0;">
										<div class="tbl">
											<div class="cell">IDR</div>
										</div>
									</div>
								</div>
								<div class="display-inline">
									<input type="text" required class="form-control txtboxToFilter" maxlength="9" name="price" value="{{ $product->price }}" />
								</div>	
							</div>	
						</div>	
						<div class="display-inline mr10">
							<label>Sale</label>
							<div class="clearfix">								
								<div class="display-inline mr10" style="width: 50px;">
									<input type="text" class="form-control txtboxToFilter" maxlength="3" name="sale" value="{{ $product->discount }}" />
								</div>	
								<div class="display-inline">
									<div style="height: 30px; margin: auto 0;">
										<div class="tbl">
											<div class="cell">%</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="display-inline">
							<label>Price</label>
							<div class="clearfix">
								<div class="display-inline mr10">
									<div style="height: 30px; margin: auto 0;">
										<div class="tbl">
											<div class="cell">IDR</div>
										</div>
									</div>
								</div>
								<div class="display-inline">
									<input type="text" required class="form-control txtboxToFilter" maxlength="9" name="totalPrice" value="{{ $product->price * $product->discount / 100 }}" disabled/>
								</div>	
							</div>	
						</div>
					</div>
					<div class="form-group">
						<div class="display-inline mr10"><button type="button" class="btn btn-small" id="addLength">Add</button></div>
						<div class="display-inline pos-det">Length</div>
						<div id="lengthTemp" class="display-inline">
							<div class="display-inline mr10 hidden" id="hiddenLength">
								<div class="display-inline" style="margin-right: 5px;">
									<input type="text" name="lengthSale[]" class="form-control" style="width: 50px;"/>
								</div>
								<div class="display-inline deleteLength" style="position: relative; top: 8px; ">
									<div class="icon-incorrect"></div>
								</div>
							</div>
							@foreach($product->length as $len)
							<div class="display-inline mr10" id="hiddenLength">
								<div class="display-inline" style="margin-right: 5px;">
									
									<input type="text" name="lengthSale[]" class="form-control" value="{{ $len->length }}" style="width: 50px;"/>
									
								</div>
								<div class="display-inline deleteLength" style="position: relative; top: 8px; ">
									<div class="icon-incorrect"></div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					<div class="form-group">
						<div class="mb20">
							<div class="display-inline mr10"><a class="fancybox" href="#color"><button type="button" class="btn btn-small">Add</button></a></div>
							<div class="display-inline pos-det">Colour Image <span class="red">*</span></div>
						</div>
						<div id="colorTemp" class="display-inline">
							<div class="hidden display-inline mr10" id="hiddenClass">
								<div class="display-inline" style="margin-right: 5px;">
									<input type="hidden" name="colourImage[]" value="" />
									<img src="" id="colorImage" />
								</div>		
								<div class="display-inline deleteColor" style="position: relative; top: 4px; left: -2px;">
									<div class="icon-incorrect "></div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="display-inline mr10"><button type="button" class="btn btn-small" id="addSize">Add</button></div>
						<div class="display-inline pos-det">Size <span class="red">*</span></div>
						<div id="sizeTemp" class="display-inline">
							<div class="display-inline mr10 hidden" id="hiddenSize">
								<div class="display-inline" style="margin-right: 5px;">
									<input type="text" name="sizeSale[]" class="form-control" style="width: 50px;"/>
								</div>
								<div class="display-inline deleteSize" style="position: relative; top: 8px; ">
									<div class="icon-incorrect"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="display-inline"><button type="button" class="btn btn-small" id="generateDetailClick">Generate</button></div>
					</div>
				</div>
				<div class="wdth50">
					<div class="form-group mb30">
						<label>Product Description <span class="red">*</span></label>
						<textarea id="mceFixed" class="productDesc" name="productDescription">{!! $product->productdescription !!}</textarea>    
					</div>
					<div class="form-group mb30">
						<label>Size Chart <span class="red">*</span></label>
						<textarea id="mceFixed2" class="sizeChart" name="sizeChart">{!! $product->sizechart !!}</textarea>    
					</div>
					<div class="form-group mb30">
						<label>Size Detail <span class="red">*</span></label>
						<textarea id="mceFixed2" class="sizeDetail" name="sizeDetail">{!! $product->sizedetail !!}</textarea>   
					</div>
				</div>
			</div>
			<div class="clearfix mb30" id="tempGenerate">
				<div class="form-group mb20">
					@foreach($product->color as $i => $color)
						<label>Product Details <span>
							<input type="hidden" name="countColor" value="{{ count($product->color) }}"/>
							<input type="hidden" name="colourImage[]" value="{{ $color->colorid }}" />
							<img src="{{ url($color->colorpath) }}"/></span>
						</label>
						@foreach($color->size as $j => $size)
							<div class="clearfix mb20">
								<div class="display-inline mr20">
									<div class="display-inline mr10 pos-det">Size <span class="red">*</span> :</div>
									<div class="display-inline">
										<input type="text" class="form-control txtboxToFilter" maxlength="4" name="genSize{{$i}}[]" value="{{$size->size}}" style="width: 50px;" readonly="readonly" />
									</div>
								</div>
								<div class="display-inline mr20">
									<div class="display-inline mr10 pos-det">Stock <span class="red">*</span> :</div>
									<div class="display-inline">
										<input type="text" required class="form-control txtboxToFilter" maxlength="4" name="genStock{{$i}}[]" value="{{$size->stock}}" style="width: 50px;"/>
									</div>
								</div>
							</div>
						@endforeach
						<div class="clearfix mb20"><input type="hidden" name="inputimage{{$i}}" id="inputimage{{$i}}" /><div class="w200"><img id="imageimage{{$i}}" src="{{ url($color->mainimage) }}" class="img-responsive" /></div></div>
					@endforeach
				</div>
			</div>
			<div>
				<a href="{{ url('meisjejongetje/commerce/product') }}"><button type="button" class="btn btn-pop mr10">Back</button></a>
				<input type="submit" class="btn btn-pop" value="Submit">
			</div>
		</form>
	</div>
	
	<div id="color" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">Color</div>
			<div>
				Please choose any color for this product
			</div>
			<br/>
			<div class="form-group mb30">
				@foreach($colors as $color)
					<a class="no-popup colorClick" data-value="{{$color->colorid}}" data-path="{{ url($color->colorpath) }}"><img src="{{ url($color->colorpath) }}" /></a>
				@endforeach
			</div>
		</div>
	</div>
	<div id="image" class="width-pop" style="width: 700px;">
		<div class="pad-pop">
			<div class="title-pop">Image</div>
			<div class="adminTable table-image">
				<table id="table_id" style="width: 100% !important;">
					<thead>
						<tr>
							<td width="100">Main Image</td>
							<td width="200">Back Image</td>
							<td>Sub Image</td>
							<td width="100" class="text-center">Action</td>
						</tr>
					</thead>
					<tbody>
						@foreach($images as $index => $image)
							<tr>
								<td><div class="w200"><img src="{{ url($image->main) }}" class="img-responsive"/></div></td>
								<td><div class="w200"><img src="{{ url($image->back) }}" class="img-responsive"/></div></td>
								<td>
									@foreach($image->sub as $sub)
										<div class="w200 image-left"><img src="{{ url($sub->subimage) }}" class="img-responsive"/></div>
									@endforeach
								</td>
								<td class="text-center">
									<button class="addImage btn btn-image" data-path="{{ url($image->main) }}" data-id="{{$image->imageid}}">Add</button>
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
@endsection