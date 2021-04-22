<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{!! $general->header->title !!}</title>
	<meta name="description" content="{!! $general->header->metadescription !!}">
	<meta name="keyword" content="{{ $general->header->metakeyword }}">
	<meta name="google-site-verification" content="{{ $general->header->googlewebmaster }}">

	<link rel="shortcut icon" type="image/x-icon" href="{{URL::asset( $general->header->favicon )}}" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/jquery.bxslider/jquery.bxslider.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/elastislide/css/elastislide.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/zoom/imagezoom.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/dataTable/datatable.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/dataTable/responsive.bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/fancybox/jquery.fancybox.css?v=2.1.5')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/jspane/jquery.jscrollpane.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/simple-pagination/simplePagination.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/owl/owl.transitions.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/js/owl/owl.carousel.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/fonts.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/style.css?v.2')}}">

	<!-- JS-->
	<script>var site_url = '';</script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery.number.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery.bxslider/jquery.bxslider.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/elastislide/js/modernizr.custom.17475.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/elastislide/js/jquery.elastislide.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/zoom/imagezoom.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/accordion/jquery-ui.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/dataTable/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/dataTable/dataTables.bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/dataTable/dataTables.responsive.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/dataTable/responsive.bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/fancybox/jquery.fancybox.js?v=2.1.5')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery.mousewheel.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jspane/jquery.jscrollpane.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/simple-pagination/jquery.simplePagination.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/owl/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/web.js')}}"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<!-- SECTIGO -->
	<script type="text/javascript"> //<![CDATA[ 
	  var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
	  document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
	  //]]>
	</script>

	<!-- FONTS -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/fonts/glyphicons-halflings-regular.ttf')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/fonts/glyphicons-halflings-regular.woff')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/fonts/glyphicons-halflings-regular.woff2')}}">

	<script>
	$(function() {
		$('.selected-disc-currency-value').number(true,2);
		$('.selected-currency-value').number(true,2);
		$('#submitLetter').submit(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');

			$.ajax({
				type: "post",
				url: "{{ url('submitnewsletter') }}",
				data: $("#submitLetter").serialize(),
				dataType: 'json',
				success: function (data) {
					if(data.success == false)
					{
						/*
						for(var i = 0; i < data.validation.length; i++)
						{
							$('[name='+data.validation[i].form+']').addClass('error');

							for(var j = 0; j < data.validation[i].msg.length; j++){
								$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+'<br/>'+data.validation[i].msg[j]);
							}
						}
						*/
						$.fancybox.open({
							href: '#failed',
						});
					}
					else{
						$("input, textarea").val("");
						$("[name=_token]").val('{{ csrf_token() }}');
						$.fancybox.open({
							href: '#success',
						});
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
		function round(value, step) {
		    step || (step = 1.0);
		    var inv = 1.0 / step;
		    return Math.ceil(value * inv) / inv;
		}
		$('.select-currency').on("change",function(){
			var value = $(this).find('option:selected').attr('data-value');
			sessionStorage.setItem("selectedCurrency",$(this).val());
			$('.selected-currency').html($(this).val());
			var IDRprice=0;
			$('.default-disc-price-hidden').each(function(){
				IDRprice = parseInt($(this).text());
				$(this).siblings('.selected-disc-currency-value').html(round(IDRprice*value,0.05));
				/*$(this).siblings('.selected-disc-currency-value').html((IDRprice/value).toFixed(2));*/
			})
			IDRprice=0;
			$('.default-price-hidden').each(function(){
				IDRprice = parseInt($(this).text());
				$(this).siblings('.selected-currency-value').html(round(IDRprice*value,0.05));
				/*$(this).siblings('.selected-currency-value').html((IDRprice/value).toFixed(2));*/
			})
			if($(this).val() == "IDR" ||  $(this).val() == "JPY"){
				$('.selected-disc-currency-value').number(true);
				$('.selected-currency-value').number(true);
			}else{
				$('.selected-disc-currency-value').number(true,2);
				$('.selected-currency-value').number(true,2);
			}
			$('.select-currency').val($(this).val());
		})
	});

	<?php
		$sqlCurrency=""; $x=0; $listCurrency=""; $sqlCurrency2=array();
		foreach($currencies as $currency){
			if($x!=0){
				$sqlCurrency.="%2C"; $sqlCurrency2[]="'".$currency->currency_code."'";
			}
			$sqlCurrency.="%27".$currency->currency_code."IDR%27";
			$x++;
		}
	?>

	var selectedCurrency = sessionStorage.getItem('selectedCurrency');
	var a=[<?php echo implode(',',$sqlCurrency2) ?>];
	$.ajax({
		type : "get",
		url  : "https://data.fixer.io/api/latest?access_key=9a4a8ca6dbb7c5a751dfecd3f1f485a1&base=IDR",
		
		success: function (e){
			sessionStorage.setItem("listCurrency",e);
			for (var i = 0; i < a.length; i++){
				if(a[i] == 'IDR'){
					$('.select-currency').append('<option value="'+a[i]+'" data-value="1">IDR</option>');
				}else{
					$('.select-currency').append('<option value="'+a[i]+'" data-value="'+e.rates[a[i]]+'">'+a[i]+'</option>');
				}
			}
			if(selectedCurrency == null){
			$(document).ready(function(){
					var selectedCurrency = "IDR";
					$('.select-currency').val(selectedCurrency);
					sessionStorage.setItem("selectedCurrency","IDR");
				});
				$('.select-currency').val("IDR");
				sessionStorage.setItem("selectedCurrency","IDR");
			}else{
				$(function() {
					$('.select-currency').val(sessionStorage.getItem("selectedCurrency"));
					$('.select-currency').trigger('change');
				});
			}
		}
	});

	</script>

	<!-- GOOGLE ANALYTICS -->
	{!! $general->header->googleanalytic !!}

</head>
<body>

<section id="main-page">
	<div class="pos-rel">
		<div class="bg-dark"></div>
			<header id="header">
				<div class="hdr-container full-container">
					<div class="visible-xs visible-sm hidden-lg hidden-md text-center" style="padding:8px 0;font-size:12px;"><span>SHIPPING WORLDWIDE</span>  @if(Request::segment(1) != "checkout") | <span> CURRENCY : <select name="currencies" onchange="custom_select(this)" class="select-currency"></select></span> @endif</div>
					<div class="row">
						<div class="col-xs-3 col-sm-4">
							<div class="h100">
								<div class="tbl">
									<div class="cell">
										<ul class="list-login hidden-xs hidden-sm">
											@if($general->member == null)
											<li><a href="{{ url('login') }}">LOG IN</a></li>
											<li><a href="{{ url('register') }}">REGISTER</a></li>
											@else
											<li>HELLO, <a href="{{ url('member') }}">{{ strtoupper($general->member->fullname) }}</a></li>
											@endif
										</ul>
										<div class="hidden-md hidden-lg">
											<div class="search-inline">
												<a class="toggle-menu">
													<div class="hdr-icon">
														<img src="{{url('assets/images/icons/menu-toggle.svg') }}" class="img-responsive"/>
													</div>
												</a>
											</div>
											<div class="search-inline">
												<div class="search-toggle">
													<img src="{{url('assets/images/icons/search.svg') }}" class="img-responsive"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-sm-4">
							<div class="h100">
								<div class="tbl">
									<div class="cell">
										<div class="img-logo">
											<a href="{{ url('/') }}">
												<img src="{{url( $general->header->logo ) }}" class="img-responsive"/>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-xs-3 col-sm-4">
							<div class="h100">
								<div class="tbl">
									<div class="cell">
										<div class="hdr-right hidden-xs hidden-sm">
											<span>SHIPPING WORLDWIDE</span>
											@if(Request::segment(1) != "checkout")
												<span>| CURRENCY : <select name="currencies" onchange="custom_select(this)" class="select-currency"></select></span>
											@endif
											<br>
										</div>
										<a class="cart-resp hidden-md hidden-lg" href="{{ url('cart') }}">
											<ul class="list-icon">
												<li>
													<div class="hdr-icon">
														<img src="{{url('assets/images/icons/cart.svg') }}" class="img-responsive"/>
													</div>
												</li>
												<li>
													<div class="text-hdr"><span class="hide1300">SHOPPING BAG</span> (<span id="cart2">{{$general->cartcount}}</span>)</div>
												</li>
											</ul>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="pad-hdr hidden-xs hidden-sm">
						<div class="row">
							<div class="col-sm-2">
								<div class="h40">
									<div class="tbl">
										<div class="cell">
											<form action="{{url('product/search')}}" method="post">
												<div class="search-inline">
													<div class="click-search">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<img src="{{url('assets/images/icons/search.svg') }}" class="img-responsive"/>
													</div>
												</div>
												<div class="search-inline">
													<input class="input-search form-control" name="search"/>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="h40">
									<div class="tbl">
										<div class="cell">
											<nav id="main-menu">
												<ul class="nav-menu list-inline-b">
													<li>
														<a href="{{ url('/') }}" class="nav_home">HOME</a>
													</li>
													<li>
														<a href="{{ url('product/arrival') }}" class="nav_new">NEW ARRIVALS</a>
													</li>
													<li class="dropdown-li">
														<a href="{{ url('product') }}" class="a-dropdown nav_shop">SHOP</a>
														<div class="dropdown-list">
															<div class="list">
																<div class="collectionmenu">
																	@foreach($general->menu as $menu)
																		<a href="{{ url('product/categories/'.$menu->categoryid) }}">{{ $menu->categoryname }}</a>
																	@endforeach
																</div>
															</div>
														</div>
													</li>
													<li class="dropdown-li">
														<a href="{{ url('product/sale') }}" class="a-dropdown nav_sale">SALE</a>
														<div class="dropdown-list">
															<div class="list">
																<div class="collectionmenu">
																	@foreach($general->menu as $menu)
																		<a href="{{ url('product/category/'.$menu->categoryid) }}">{{ $menu->categoryname }}</a>
																	@endforeach
																</div>
															</div>
														</div>
													</li>
													<li class="dropdown-li">
														<a href="{{ url('pages/blog') }}" class="a-dropdown nav_world">WORLD OF DE'MOR</a>
														<div class="dropdown-list">
															<div class="list">
																<div class="collectionmenu">
																	@foreach($general->demor as $demor)
																		<a href="{{ url('pages/blog/'.$demor->categoryid) }}">{{$demor->categoryname}}</a>
																	@endforeach
																</div>
															</div>
														</div>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="h40">
									<div class="tbl">
										<div class="cell text-right">
											<a class="cart-link" href="{{ url('cart') }}">
												<ul class="list-icon">
													<li>
														<div class="hdr-icon">
															<img src="{{url('assets/images/icons/cart.svg')}}" class="img-responsive"/>
														</div>
													</li>
													<li>
														<div class="text-hdr"><span class="hide1300">SHOPPING BAG</span> (<span id="cart1">{{$general->cartcount}}</span>)</div>
													</li>
												</ul>
											</a>
											<div class="hover-cart cart-list hidden-xs data-cart">
												<div class="jspane">
													@foreach($general->cart as $cart)
														<div class="list">
															<div class="w80"><img src="{{url($cart->productImage)}}" class="img-responsive" /></div>
															<div class="desc">
																<div class="t-cart">{{$cart->productName}}</div>
																<div class="text">
																	<div class="clearfix">
																		<div class="pull-left" style="width:50px;">Color</div>
																		<div class="pull-left color-cart">
																			<img src="{{url($cart->productColorPath)}}" class="img-responsive" />
																		</div>
																	</div>
																	<div class="clearfix">
																		<div class="pull-left" style="width:50px;">Size</div>
																		<div class="pull-left">{{$cart->productSize}}</div>
																	</div>
																	<div class="clearfix">
																		<div class="pull-left" style="width:50px;">Qty</div>
																		<div class="pull-left">{{$cart->productQuantity}}</div>
																	</div>
																	<div class="clearfix">
																		<div class="pull-left" style="width:50px;">Price</div>
																		<div class="pull-left">{{-- IDR {{str_replace(",",".",number_format($cart->productPrice))}}--}}
																			<span class="selected-currency">IDR</span>
																			<span class="default-price-hidden hide">{{ $cart->productPrice * $cart->productQuantity }}</span>
																			<span class="sale selected-currency-value">{{ $cart->productPrice *$cart->productQuantity }}</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													@endforeach
												</div>
												<div class="clearfix btn-max">
													<div class="width50">
														<a href="{{ url('cart') }}"><button type="button" class="btn btn-blue max">Cart</button></a>
													</div>
													<div class="width50 right">
														<a href="{{ url('checkout') }}"><button type="button" class="btn btn-red max">Checkout</button></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div id="tsearch">
				<div class="search">
					<div class="tbl">
						<div class="cell">
							<form action="{{url('product/search')}}" method="post">
								<div class="pos-rel">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="text" class="form-control input-sm" placeholder="I'm looking for.." name="search"/>
									<button type="submit" class="btn-search btn-sm">
										<i class="isearch"></i>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			@yield('content')

			<footer>
			<div id="footer">
				<div class="container">
					<div class="text-soc">Follow Us</div>
					<ul class="list-soc">
						<li>
							<a href="{{$general->footer->socialfacebook}}" target="_blank">
								<img src="{{url('assets/images/icons/f-fb.svg') }}" class="img-responsive" />
								<!--
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
								-->
							</a>
						</li>
						<li>
							<a href="{{$general->footer->socialinstagram}}" target="_blank">
								<img src="{{url('assets/images/icons/f-ig.svg') }}" class="img-responsive" />
								<!--
								<svg class="social-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
									<g>
									<path class="hover-soc" d="M27.476,10.092h-14.82c-1.355,0-2.457,1.102-2.457,2.457v15.002c0,1.355,1.102,2.458,2.457,2.458h14.82
									c1.354,0,2.457-1.103,2.457-2.458V12.549C29.933,11.194,28.83,10.092,27.476,10.092L27.476,10.092z M27.605,27.552
									c0,0.071-0.058,0.13-0.13,0.13h-14.82c-0.071,0-0.129-0.059-0.129-0.13V12.549c0-0.071,0.059-0.129,0.129-0.129h14.82
									c0.072,0,0.13,0.058,0.13,0.129V27.552z M27.605,27.552"/>
									<rect class="hover-soc" x="23.462" y="14.164" width="2.667" height="2.446"/>
									<path class="hover-soc" d="M22.695,21.036c0,1.452-1.178,2.628-2.629,2.628c-1.451,0-2.629-1.176-2.629-2.628c0-1.452,1.178-2.628,2.629-2.628
									C21.518,18.408,22.695,19.584,22.695,21.036L22.695,21.036z M22.695,21.036"/>
									<path class="hover-soc" d="M24.259,21.024c0,2.315-1.878,4.193-4.192,4.193c-2.316,0-4.193-1.878-4.193-4.193l0.005-1.868h-1.875v6.952h12.125v-6.952
									h-1.86L24.259,21.024z M24.259,21.024"/>
									</g>
									<path class="hover-soc" fill-rule="evenodd" clip-rule="evenodd" d="M40.115,20.05C40.115,8.978,31.137,0,20.066,0C8.996,0,0.016,8.978,0.016,20.05
									c0,11.07,8.979,20.052,20.05,20.052C31.137,40.102,40.115,31.12,40.115,20.05L40.115,20.05z M1.84,20.05
									c0-10.064,8.161-18.224,18.226-18.224s18.225,8.16,18.225,18.224c0,10.064-8.16,18.226-18.225,18.226S1.84,30.114,1.84,20.05
									L1.84,20.05z M1.84,20.05"/>
								</svg>
								-->
							</a>
						</li>
						<li>
							<a href="{{$general->footer->socialpinterest}}" target="_blank">
								<img src="{{url('assets/images/icons/f-pt.svg') }}" class="img-responsive" />
							<!--
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
							-->
							</a>
						</li>
					</ul>
					<ul class="list-ftrmenu hidden-xs hidden-sm">
						<li><a href="{{ url('/pages/about') }}">About De'mor</a></li>
						<li><a href="{{ url('/pages/shippingexchange') }}">Shipping &amp; Exchanges</a></li>
						<li><a href="{{ url('/pages/termcondition') }}">Terms &amp; Conditions</a></li>
						<li><a href="{{ url('/pages/privacypolicy') }}">Privacy Policy</a></li>
						<li><a href="{{ url('/pages/working') }}">Working with De'mor</a></li>
						<li><a href="{{ url('/pages/contact') }}">Contact Us</a></li>
						<!--
						<li><a class="fancybox" href="#failed">Failed</a></li>
						<li><a class="fancybox" href="#success">Success</a></li>
						-->
					</ul>
					<div class="bdr-newsletter">
						<div class="row">
							<form id="submitLetter" method="post">
								<div class="col-sm-6 resp30">
									<div class="t-newsletter">JOIN OUR NEWSLETTER</div>
									<div class="w-newsletter">Subscribe to our newsletters to receive our exclusive and product updates!</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group mb30">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="text" class="form-control form-email" name="email" placeholder="Please enter your email" onkeydown="checkFunction(this)">
										<span class="input-group-addon">
											<button type="submit" class="btn btn-subs">SUBSCRIBE</button>
										</span>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="hidden-index">
						<div class="text-soc">Payment Methods</div>
						<ul class="list-payment">
							<li><img src="{{url('assets/images/icons/master.svg')}}" class="img-responsive"/></li>
							<li><img src="{{url('assets/images/icons/visa.svg')}}" class="img-responsive"/></li>
							<li><img src="{{url('assets/images/icons/bca.svg')}}" class="img-responsive"/></li>
							<li><img src="{{url('assets/images/icons/mandiri.svg')}}" class="img-responsive"/></li>
						</ul>
						<!--{!! $general->footer->payment !!}-->
					</div>
					<div class="cp">{{ $general->footer->copyright }}</div>
				</div>
			</div>
			</footer>
		</div>
	</section>

	<div id="offcanvas-menu">
		<div class="clearfix">
			<div class="close-menu">
				<img src="{{url('assets/images/icons/close-menu.svg')}}" class="img-responsive"/>
			</div>
		</div>
		<div class="border-menu">
			@if($general->member == null)
			<div class="mb20">
				<a href="{{ url('login') }}">
					<div class="icon-login">LOG IN</div>
				</a>
			</div>
			<div class="mb20">
				<a href="{{ url('register') }}">
					<div class="icon-login">REGISTER</div>
				</a>
			</div>
			@else
			<div class="mb20">HELLO, <a href="{{ url('member') }}">{{ strtoupper($general->member->fullname) }}</a></div>
			<div class="mb20">
				<a href="{{ url('logout') }}">
					<div class="icon-logout">SIGN OUT</div>
				</a>
			</div>
			@endif
		</div>
		<div class="border-menu">
			<div class="list">
				<a href="{{ url('/') }}">HOME</a>
			</div>
			<div class="hide-home">
				<div class="list">
					<a href="{{ url('product/arrival') }}">NEW ARRIVALS</a>
				</div>
				<div class="list">
					<a class="dropdown-listmenu">SHOP</a>
					<div class="list-menu">
						@foreach($general->menu as $menu)
							<div><a href="{{ url('product/categories/'.$menu->categoryid) }}">{{ $menu->categoryname }}</a></div>
						@endforeach
					</div>
				</div>
				<div class="list">
					<a class="dropdown-listmenu">SALE</a>
					<div class="list-menu">
						@foreach($general->menu as $menu)
							<div><a href="{{ url('product/category/'.$menu->categoryid) }}">{{ $menu->categoryname }}</a></div>
						@endforeach
					</div>
				</div>
				<div class="list">
					<a class="dropdown-listmenu">WORLD OF DE'MOR</a>
					<div class="list-menu">
						@foreach($general->demor as $demor)
							<div><a href="{{ url('pages/blog/'.$demor->categoryid) }}">{{$demor->categoryname}}</a></div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="list">
				<a href="{{ url('/pages/about') }}">ABOUT DE'MOR</a>
			</div>
			<div class="list">
				<a href="{{ url('/pages/shippingexchange') }}">SHIPPING &amp; EXCHANGES</a>
			</div>
			<div class="list">
				<a href="{{ url('/pages/termcondition') }}">TERMS &amp; CONDITIONS</a>
			</div>
			<div class="list">
				<a href="{{ url('/pages/privacypolicy') }}">PRIVACY POLICY</a>
			</div>
			<div class="list">
				<a href="{{ url('/pages/working') }}">WORKING WITH DE'MOR</a>
			</div>
			<div class="list">
				<a href="{{ url('/pages/contact') }}">CONTACT US</a>
			</div>
		</div>
	</div>

	<!-- Failed -->
	<div id="failed" class="width-pop">
		<div class="pad-pop">
			<div class="img-pop">
				<img src="{{url('assets/images/icons/failed.svg')}}" class="img-responsive"/>
			</div>
			<div class="text-pop" id="failedMessage">Failed</div>
		</div>
	</div>

	<!-- Success -->
	<div id="success" class="width-pop">
		<div class="pad-pop">
			<div class="img-pop">
				<img src="{{url('assets/images/icons/success.svg')}}" class="img-responsive"/>
			</div>
			<div class="text-pop">Success</div>
		</div>
	</div>

        <div class="icon-comodo">
	  <script language="JavaScript" type="text/javascript">
	    TrustLogo("https://www.demorboutique.com/assets/images/icons/sectigo_trust_seal_md_106x42.png", "CL1", "none");
	  </script>
	  <!-- <a  href="https://ssl.comodo.com/wildcard-ssl-certificates.php" id="comodoTL">Wildcard SSL</a>-->
        </div>


</body>
</html>
