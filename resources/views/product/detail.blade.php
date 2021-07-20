@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(document).ready(function() {

		$( '.carousel-left' ).elastislide({
			orientation : 'vertical'
		});

		$( '.carousel-bottom' ).elastislide({
			orientation : 'horizontal'
		});

		$('.zoomslider').bxSlider({
		  pagerCustom: '.zoom-pager'
		});

		$('.colorClick').click(function(e){
			e.preventDefault();
			$('[name=productImage]').val($(this).attr('data-path'));
			$('[name=productColor]').val($(this).attr('data-value'));
			$('[name=productColorPath]').val($(this).attr('data-value-path'));

			$("[name=qty]").find('option').remove();
		});
		$('[name=size]').change(function(e){
			e.preventDefault();
			var str = $(this).val();
			str = str.split(";");
			$('[name=productSize]').val(str[0]);
			$('[name=productStock]').val(str[1]);

			$("[name=qty]").find('option').remove();
			$('[name=qty]').append($('<option>', {
				value: 0,
				text : 'Select Quantity'
			}));
			for(var i = 0; i < parseInt($('[name=productStock]').val()); i++){
				$('[name=qty]').append($('<option>', {
					value: i+1,
					text : i+1
				}));
			}
		});
		$('[name=qty]').change(function(e){
			e.preventDefault();
			$('[name=productQuantity]').val($(this).val());
		});

		$('#submitCart').submit(function(e){
 			e.preventDefault();
			//console.log($("#submitCart").serialize());
			var qty = $('[name=productQuantity]').val();
			var order = {{$general->cartcount}};

 			if($('[name=productSize]').val() == '0;0'){
 				$('#failedMessage').html('Please pick any size you want.');
 				$.fancybox.open({
 					href: '#failed',
 				});
 			}
			else if(qty == '0'){
 				$('#failedMessage').html('Please select the quantity you want.');
 				$.fancybox.open({
 					href: '#failed',
 				});
 			}
			else if(parseInt(qty) + parseInt(order) > 4)
			{
				$('#failedMessage').html('Sorry, you only can buy max 4 pieces for one transaction.');
				$.fancybox.open({
					href: '#failed',
				});
			}
 			else{
				$.ajax({
					type: "post",
					url: "{{ url('product/addtocart') }}",
					data: $("#submitCart").serialize(),
					dataType: 'json',
					success: function (data) {
						location.reload();
						$('#cart1').html(data.cart.length);
						$('#cart2').html(data.cart.length);

						$(".hover-cart").show();
						$("html, body").animate({
							scrollTop: 0
						}, 800);
						setTimeout(function() {
							$(".hover-cart").hide();
						}, 5e3);
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}
		});
	});
	</script>

	<div id="content" class="ori-table">
		<div class="container">
			<div class="title30">
				<div class="title">Detail</div>
				<div class="bdr-title no-center"></div>
			</div>
			<div class="mb40">
				<div class="breadcrumb">
					@foreach($breadCrumb as $index => $b)
						@if($b->path == '')
							<span class="active">{{$b->name}}</span>
						@else
							<a href="{{ url($b->path) }}">{{$b->name}}</a>
						@endif
						@if($index != count($breadCrumb) - 1)
							<span class="m10"> / </span>
						@endif
					@endforeach
				</div>
			</div>
			<div class="row">
				<div class="col-sm-1 hidden-xs hidden-sm">
					<div class="zoom-pager">
						<ul class="carousel-left">
							<li>
								<a data-slide-index="0">
								<?php $z=0; ?>
								@foreach($product->color as $index => $color)
								<img src="{{ url($color->mainimage) }}" class="tab-{{$index+1}} content-img @if($z == 0) current @endif img-responsive " />
								<?php $z++; ?>
								@endforeach
								</a>
							</li>
							<li>
								<a data-slide-index="1">
								<?php $z=0; ?>
								@foreach($product->color as $index => $color)
									<img src="{{ url($color->subimage) }}" class="tab-{{$index+1}} content-img @if($z == 0) current @endif img-responsive" />
								<?php $z++; ?>
								@endforeach
								</a>
							</li>
							<li>
								@for($i = 0; $i < $subImageCount; $i++)
								<li>
									<?php $z=0; ?>
									<a data-slide-index="{{$i+2}}">
										@for($j = 0; $j < count($product->color); $j++)
											<img src="{{ url($product->color[$j]->image[$i]->subimage) }}" class="tab-{{$j+1}} content-img @if($z == 0) current @endif  img-responsive" />
										<?php $z++; ?>
										@endfor
									</a>
								</li>
								@endfor
							</li>
						</ul>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-md-offset-1 resp30">
					<div class="pos-rel">
						<div class="dont-overlay"></div>
						<ul class="zoomslider">
							<li>
								<div class="imagezoom">
									@foreach($product->color as $index => $color)
										<img src="{{ url($color->mainimage) }}?v.1" class="tab-{{$index+1}} content-img @if($index == 0) current @endif img-responsive" />
									@endforeach
								</div>
							</li>
							<li>
								<div class="imagezoom">
									@foreach($product->color as $index => $color)
										<img src="{{ url($color->subimage) }}?v.1" class="tab-{{$index+1}} content-img @if($index == 0) current @endif img-responsive" />
									@endforeach
								</div>
							</li>
							@for($i = 0; $i < $subImageCount; $i++)
								<li>
									<div class="imagezoom">
										@for($j = 0; $j < count($product->color); $j++)
											<img src="{{ url($product->color[$j]->image[$i]->subimage) }}?v.1" class="tab-{{$j+1}} content-img @if($j == 0) current @endif img-responsive" />
										@endfor
									</div>
								</li>
							@endfor
						</ul>
						<div class="row hidden-xs hidden-md hidden-lg">
							<div class="zoom-pager">
								<ul class="carousel-bottom">
									<li>
										<a data-slide-index="0">
										<?php $z=0; ?>
										@foreach($product->color as $index => $color)
										<img src="{{ url($color->mainimage) }}?v.1" class="tab-{{$index+1}} content-img @if($z == 0) current @endif img-responsive " />
										<?php $z++; ?>
										@endforeach
										</a>
									</li>
									<li>
										<a data-slide-index="1">
										<?php $z=0; ?>
										@foreach($product->color as $index => $color)
											<img src="{{ url($color->subimage) }}?v.1" class="tab-{{$index+1}} content-img @if($z == 0) current @endif img-responsive" />
										<?php $z++; ?>
										@endforeach
										</a>
									</li>

									<li>
										@for($i = 0; $i < $subImageCount; $i++)
										<li>
											<?php $z=0; ?>
											<a data-slide-index="{{$i+2}}">
												@for($j = 0; $j < count($product->color); $j++)
													<img src="{{ url($product->color[$j]->image[$i]->subimage) }}?v.1" class="tab-{{$j+1}} content-img @if($z == 0) current @endif  img-responsive" />
												<?php $z++; ?>
												@endfor
											</a>
										</li>
										@endfor
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-5 col-md-offset-1">
					<div class="title mb20">{{ $product->productname }}</div>
					@if($product->stock != 0)
						<div class="green">IN STOCK</div>
					@else
						<div class="red">OUT OF STOCK</div>
					@endif
					<div class="n-product">{{ $product->brandname }}</div>
					<div class="p-product">
						{{--IDR
						@if($product->discount != 0)
							<span class="bsale">{{str_replace(",",".",number_format($product->price))}}</span>
						@endif
						<span class="sale">{{str_replace(",",".",number_format($product->price - $product->price * $product->discount / 100))}}</span>
						--}}
						<span class="selected-currency">IDR</span>
						@if($product->discount != 0)
							<span class="default-disc-price-hidden hide">{{ $product->price }}</span>
							<span class="bsale selected-disc-currency-value">{{ $product->price }}</span>
						@endif
						<span class="default-price-hidden hide">{{ $product->price - $product->price * $product->discount / 100 }}</span>
						<span class="sale selected-currency-value">{{ $product->price - $product->price * $product->discount / 100 }}</span>
					</div>
					<div class="mb20">
						<div class="t-product">Color</div>
						<ul class="tabs-color">
							@foreach($product->color as $index => $color)
								<li class="tab-link colorClick @if($index+1 == 1) current @endif" data-tab="tab-{{$index+1}}" data-value="{{ $color->colorid }}" data-path="{{ url($color->mainimage) }}" data-value-path="{{ url($color->colorpath) }}">
									<div class="in-box">
										<img src="{{ url($color->colorpath) }}" class="img-responsive"/>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
					@if($product->stock != 0)
						<form method="post" id="submitCart">
							<div class="form-group">
								<div class="clearfix">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="productId" value="{{ $product->productid }}">
									<input type="hidden" name="productCode" value="{{ $product->productcode }}">
									<input type="hidden" name="productName" value="{{ $product->productname }}">
									<input type="hidden" name="productPrice" value="{{ $product->price - $product->price * $product->discount / 100 }}">
									<input type="hidden" name="productDiscount" value="{{$product->discount}}">
									<input type="hidden" name="productImage" value="{{ url($product->color[0]->mainimage) }}">
									<input type="hidden" name="productColor" value="{{ $product->color[0]->colorid }}">
									<input type="hidden" name="productColorPath" value="{{ $product->color[0]->colorpath }}">
									<input type="hidden" name="productSize" value="0">
									<input type="hidden" name="productStock" value="0">
									<input type="hidden" name="productQuantity" value="0">

									@if(count($product->length)>0)
										<label>Length</label>
										<div class="custom-select w200">
											<div class="replacement">Select Length</div>
											<select name="length" class="custom-select" onChange="custom_select(this)">
												<option value="" selected>Select Length</option>
												@foreach($product->length as $len)
													<option value="{{$len->length}}">{{$len->length}}</option>
												@endforeach
											</select>
										</div>
									<br>
									@endif

									@foreach($product->color as $index => $color)
										<div class="content-img tab-{{$index+1}} @if($index+1 == 1) current @endif">
											<div class="pull-left detail20">
												<label>Size</label>
												<div class="custom-select w200">
													<div class="replacement">Select Size</div>
													<select name="size" class="custom-select" onChange="custom_select(this)">
														<option value="0;0" selected>Select Size</option>
														@foreach($color->size as $size)
															<option value="{{$size->size}};{{$size->stock}}" @if($size->stock == 0) disabled @endif>Size {{$size->size}} @if($size->stock == 0) – Out of Stock @endif</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									@endforeach
									<div class="pull-left">
										<label>Qty</label>
										<div class="custom-select w80">
											<div class="replacement">Select Quantity</div>
											<select name="qty" class="custom-select" onChange="custom_select(this)">
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="mb40">
								<a class="btn-link">
									<button class="btn btn-cart btn120">
										<div class="icon-cart">Add to Cart</div>
									</button>
								</a>
							</div>
						</form>
					@endif
					<div class="soc-product">
						<div class="text-soc">SHARE :</div>
						<ul class="list-soc">
							<li>
								<a href="https://www.facebook.com/share.php?u=https://www.demorboutique.com/product/detail/{{str_slug($product->productid,'-')}}" target="_blank">
									<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve" class="social-svg">
										<g>
										<path class="hover-soc" fill-rule="evenodd" clip-rule="evenodd" d="M40.306,20.145C40.306,9.021,31.284,0,20.161,0S0.017,9.021,0.017,20.145
										c0,11.122,9.021,20.146,20.145,20.146S40.306,31.267,40.306,20.145L40.306,20.145z M1.85,20.145
										c0-10.112,8.199-18.311,18.312-18.311s18.312,8.199,18.312,18.311s-8.199,18.311-18.312,18.311S1.85,30.257,1.85,20.145
										L1.85,20.145z M1.85,20.145"/>
										<path class="hover-soc" fill-rule="evenodd" clip-rule="evenodd" d="M20.93,31.768V20.145h3.835l0.608-3.854H20.93v-1.933
										c0-1.009,0.331-1.965,1.77-1.965h2.889V8.547h-4.096c-3.442,0-4.381,2.273-4.381,5.412v2.333h-2.36v3.854h2.36v11.623H20.93z
										M20.93,31.768"/>
										</g>
									</svg>
								</a>
							</li>
							<li>
								<a href="https://pinterest.com/pin/create/button/?url={{ url($product->color[0]->mainimage) }}&media={{ url($product->color[0]->mainimage) }}&description={{$product->productname}}" target="_blank">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve" class="social-svg">
									<path class="hover-soc" fill-rule="evenodd" clip-rule="evenodd" d="M40.048,20.024C40.048,8.966,31.08,0,20.024,0S0,8.966,0,20.024
									C0,31.08,8.968,40.05,20.024,40.05S40.048,31.08,40.048,20.024L40.048,20.024z M1.822,20.024c0-10.051,8.15-18.201,18.202-18.201
									c10.051,0,18.202,8.15,18.202,18.201c0,10.051-8.15,18.202-18.202,18.202C9.972,38.226,1.822,30.075,1.822,20.024L1.822,20.024z
									M1.822,20.024"/>
									<g id="Flat_copy">
									<path class="hover-soc" d="M28.958,16.079c0,5.2-2.891,9.087-7.154,9.087c-1.431,0-2.777-0.774-3.238-1.653c0,0-0.77,3.055-0.932,3.645
									c-0.574,2.083-2.263,4.167-2.393,4.339c-0.092,0.119-0.294,0.081-0.315-0.076c-0.037-0.266-0.467-2.895,0.04-5.039
									c0.254-1.076,1.705-7.224,1.705-7.224s-0.422-0.847-0.422-2.098c0-1.965,1.138-3.432,2.556-3.432c1.206,0,1.788,0.904,1.788,1.99
									c0,1.213-0.771,3.025-1.17,4.704c-0.333,1.407,0.706,2.554,2.093,2.554c2.511,0,4.202-3.228,4.202-7.049
									c0-2.905-1.955-5.081-5.516-5.081c-4.021,0-6.527,3-6.527,6.35c0,1.156,0.341,1.971,0.875,2.601c0.245,0.29,0.279,0.406,0.19,0.739
									c-0.065,0.245-0.209,0.831-0.271,1.064c-0.088,0.336-0.36,0.456-0.664,0.332c-1.851-0.757-2.715-2.785-2.715-5.065
									C11.09,13,14.266,8.484,20.565,8.484C25.628,8.484,28.958,12.146,28.958,16.079z"/>
									</g>
								</svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="box-product">
				<ul class="tab-detail">
					<li class="tab-link current" data-tab="tab-1">PRODUCT DESCRIPTION</li>
					<li class="tab-link" data-tab="tab-2">SIZE CHART</li>
					<li class="tab-link" data-tab="tab-3">SIZE DETAIL</li>
				</ul>

				<div id="tab-1" class="detail-content current">
					<div class="text-justify ori-font">
						{!! $product->productdescription !!}
					</div>
				</div>
				<div id="tab-2" class="detail-content">
					<div class="mb10">USE THIS CHART TO CONVERT BETWEEN STANDARD SIZE FORMATS</div>
					{!! $product->sizechart !!}
				</div>
				
				<div id="tab-3" class="detail-content">
					{!! $product->sizedetail !!}
					<div style="margin-top:10px;">Note : Toleration 1-2 cm</div>
				</div>
			
			</div>
			<div class="title30 text-center">
				<div class="title">YOU MAY ALSO LIKE</div>
				<div class="bdr-title"></div>
			</div>
			<div class="row">
				@foreach($randoms as $random)
					<div class="col-xs-6 col-sm-4 col-md-3 item-four">
						<div class="item-list">
							<a href="{{ url('product/detail/'.$random->productid) }}">
								<div class="image">
									<img src="{{ url($random->subimage) }}" class="img-responsive"/>
									<img src="{{ url($random->mainimage) }}" class="img-responsive img-hover"/>
									@if($random->discount != 0)
										<div class="ribbon sale">
											<div class="h50">
												<div class="tbl">
													<div class="cell">SALE</div>
												</div>
											</div>
										</div>
									@endif
								</div>
								<div class="desc">
									<div class="title-prod">{{$random->productname}}</div>
									<div class="price-prod">
										{{--
										IDR
										@if($random->discount != 0)
										<span class="bsale">{{str_replace(",",".",number_format($random->price))}}</span>
										@endif
										<span class="sale">{{str_replace(",",".",number_format($random->price - $random->price * $random->discount / 100))}}</span>
										--}}
										<span class="selected-currency">IDR</span>
										@if($random->discount != 0)
										<span class="default-disc-price-hidden hide">{{ $random->price }}</span>
										<span class="bsale selected-disc-currency-value">{{ $random->price }}</span>
										@endif
										<span class="default-price-hidden hide">{{ $random->price - $random->price * $random->discount / 100 }}</span>
										<span class="sale selected-currency-value">{{ $random->price - $random->price * $random->discount / 100 }}</span>
									</div>
									<ul class="list-color">
										@foreach($random->color as $color)
											<li><img style="width:22px; height:22px;" src="{{ url($color->colorpath) }}" class="img-responsive"/></li>
										@endforeach
									</ul>
								</div>
							</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection
