<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
	<title>Admin</title>

	<!-- Favicon -->
	<link rel="icon" type="image/ico" href="{{URL::asset('adminassets/uploads/favicon.ico')}}">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/owl/owl.carousel.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/owl/owl.theme.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/color/jquery.minicolors.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/drop/dropzone.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/dataTable/datatable.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/date/jquery.timepicker.css')}}">
	<!--<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/datetimepicker/jquery.datetimepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/js/fancybox/jquery.fancybox.css?v=2.1.5')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/fonts.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/web.css')}}">

	<!-- JS-->
	<script type="text/javascript" src="{{URL::asset('adminassets/js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/owl/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/color/jquery.minicolors.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/drop/dropzone.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/date/jquery.timepicker.js')}}"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/dataTable/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/datetimepicker/jquery.datetimepicker.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/fancybox/jquery.fancybox.js?v=2.1.5')}}"></script>
	<script type="text/javascript" src="{{URL::asset('adminassets/js/web.js')}}"></script>

    <!-- tinymce -->
	<script type="text/javascript" src="{{URL::asset('adminassets/js/tinymce/tinymce.min.js')}}"></script>

</head>
<body>
	<div class="wrapper">
		<header>
			<div id="header">
				<div class="clearfix">
					<div class="pull-left center-header">
						<div class="tbl">
							<div class="cell">
								<div class="logo">
									<img src="{{ url('/adminassets/uploads/logo2.png') }}"/>&nbsp; <span class="bold">ADMINISTRATOR</span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="pull-right center-header">
						<div class="tbl">
							<div class="cell">
								<a href="{{ url('/meisjejongetje/logout') }}"><span class="lnr lnr-exit" style="font-size: 1.16em; position: relative; top: 2px;"></span>&nbsp; Sign Out</a>
							</div>
						</div>
					</div>
					<div class="pull-right center-header" style="margin-right: 20px;">
						<div class="tbl">
							<div class="cell">
								<span class="lnr lnr-user"></span>&nbsp; {{$admin->fullname}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		@section('sidebar')
			<div class="clearfix">
				<div class="box-left">
					<div class="box">
						<ul id="accordion" class="accordion">
							@if($admin->menus[0] == 1)
							<li id="dashboard">
								<a href="{{ url('/meisjejongetje/index') }}">
									<div class="link">Dashboard</div>
								</a>
							</li>
							@endif
							@if($admin->menus[1] == 1 || $admin->menus[2] == 1 || $admin->menus[3] == 1 || $admin->menus[4] == 1 || $admin->menus[5] == 1 || $admin->menus[6] == 1 || $admin->menus[7] == 1 || $admin->menus[8] == 1)
							<li>
								<a>
									<div class="no-link">
										<span class="lnr lnr-magic-wand" style="font-size: 18px; position: relative; top: 2px;"></span>&nbsp; WEBSITE
									</div>
								</a>
							</li>
							@endif
							@if($admin->menus[1] == 1)
							<li id="slider">
								<a href="{{ url('/meisjejongetje/pages/slider') }}">
									<div class="link">Slider</div>
								</a>
							</li>
							@endif
							@if($admin->menus[2] == 1)
							<li id="newsletter">
								<a href="{{ url('/meisjejongetje/pages/newsletter') }}">
									<div class="link">Newsletter</div>
								</a>
							</li>
							@endif
							@if($admin->menus[3] == 1)
							<li id="pages">
								<a href="{{ url('/meisjejongetje/pages') }}">
									<div class="link">Pages</div>
								</a>
							</li>
							@endif
							@if($admin->menus[4] == 1 || $admin->menus[5] == 1)
							<li id="blog">
								<div class="link">World of De'mor<i class="lnr lnr-chevron-down"></i></div>
								<ul class="submenu">
									@if($admin->menus[4] == 1)
									<li><a href="{{ url('/meisjejongetje/pages/blog/category') }}" id="blog-category">Category</a></li>
									@endif
									@if($admin->menus[5] == 1)
									<li><a href="{{ url('/meisjejongetje/pages/blog/list') }}" id="blog-list">List</a></li>
									@endif
								</ul>
							</li>
							@endif
							@if($admin->menus[6] == 1)
							<li id="contact">
								<a href="{{ url('/meisjejongetje/pages/contact') }}">
									<div class="link">Contact</div>
								</a>
							</li>
							@endif
							@if($admin->menus[7] == 1)
							<li id="career">
								<a href="{{ url('/meisjejongetje/pages/career') }}">
									<div class="link">Career</div>
								</a>
							</li>
							@endif
							@if($admin->menus[25] == 1)
							<li id="currency">
								<a href="{{ url('/meisjejongetje/pages/currency') }}">
									<div class="link">Currency</div>
								</a>
							</li>
							@endif
							@if($admin->menus[24] == 1)
							<li id="popup">
								<a href="{{ url('/meisjejongetje/pages/popup') }}">
									<div class="link">Pop Up</div>
								</a>
							</li>
							@endif
							@if($admin->menus[8] == 1)
							<li id="footer">
								<a href="{{ url('/meisjejongetje/pages/footer') }}">
									<div class="link" style="border-bottom: 0;">Footer</div>
								</a>
							</li>
							@endif
							@if($admin->menus[9] == 1 || $admin->menus[10] == 1 || $admin->menus[11] == 1 || $admin->menus[12] == 1 || $admin->menus[13] == 1 || $admin->menus[14] == 1 || $admin->menus[15] == 1 || $admin->menus[16] == 1 || $admin->menus[17] == 1)
							<li>
								<a>
									<div class="no-link">
										<span class="lnr lnr-cart" style="font-size: 18px; position: relative; top: 2px;"></span>&nbsp; COMMERCE
									</div>
								</a>
							</li>
							@endif
							@if($admin->menus[9] == 1)
							<li id="order">
								<a href="{{ url('/meisjejongetje/commerce/order/') }}">
									<div class="link">Order</div>
								</a>
							</li>
							@endif
							@if($admin->menus[10] == 1)
							<li id="member">
								<a href="{{ url('/meisjejongetje/commerce/member/') }}">
									<div class="link">Member</div>
								</a>
							</li>
							@endif
							@if($admin->menus[11] == 1 || $admin->menus[12] == 1)
							<li id="store">
								<div class="link">Store<i class="lnr lnr-chevron-down"></i></div>
								<ul class="submenu">
									@if($admin->menus[11] == 1)
									<li><a href="{{ url('/meisjejongetje/commerce/productcategory/') }}" id="category">Category</a></li>
									@endif
									@if($admin->menus[12] == 1)
									<li><a href="{{ url('/meisjejongetje/commerce/product/') }}" id="product">Product</a></li>
									@endif
									<li><a href="{{ url('/meisjejongetje/commerce/product/color') }}" id="productColour">Product Colour</a></li>
									<li><a href="{{ url('/meisjejongetje/commerce/product/image') }}" id="productImage">Product Image</a></li>
								</ul>
							</li>
							@endif
							@if($admin->menus[13] == 1)
							<li id="payment">
								<a href="{{ url('/meisjejongetje/commerce/payment/') }}">
									<div class="link">Payment</div>
								</a>
							</li>
							@endif
							@if($admin->menus[14] == 1)
							<li id="shipping">
								<a href="{{ url('/meisjejongetje/commerce/shipping/') }}">
									<div class="link">Shipping</div>
								</a>
							</li>
							@endif
							@if($admin->menus[15] == 1)
							<li id="voucher">
								<a href="{{ url('/meisjejongetje/commerce/voucher/') }}">
									<div class="link">Voucher</div>
								</a>
							</li>
							@endif
							@if($admin->menus[16] == 1)
							<li id="exchange">
								<a href="{{ url('/meisjejongetje/commerce/exchange/') }}">
									<div class="link">Exchange</div>
								</a>
							</li>
							@endif
							@if($admin->menus[17] == 1)
							<li id="general">
								<a href="{{ url('/meisjejongetje/commerce/others/') }}">
									<div class="link" style="border-bottom: 0;">Others</div>
								</a>
							</li>
							@endif
							@if($admin->menus[18] == 1 || $admin->menus[19] == 1 || $admin->menus[20] == 1 || $admin->menus[21] == 1 || $admin->menus[22] == 1 || $admin->menus[23] == 1)
							<li>
								<a>
									<div class="no-link">
										<span class="lnr lnr-cog" style="font-size: 18px; position: relative; top: 2px;"></span>&nbsp; SETTINGS
									</div>
								</a>
							</li>
							@endif
							@if($admin->menus[18] == 1)
							<li id="general2">
								<a href="{{ url('/meisjejongetje/settings/general') }}">
									<div class="link">General</div>
								</a>
							</li>
							@endif
							@if($admin->menus[19] == 1)
							<li id="social-media">
								<a href="{{ url('/meisjejongetje/settings/socialmedia') }}">
									<div class="link">Social Media</div>
								</a>
							</li>
							@endif
							@if($admin->menus[20] == 1)
							<li id="tools">
								<a href="{{ url('/meisjejongetje/settings/tools') }}">
									<div class="link">Tools</div>
								</a>
							</li>
							@endif
							@if($admin->menus[21] == 1 || $admin->menus[22] == 1)
							<li id="role">
								<div class="link">User Account<i class="lnr lnr-chevron-down"></i></div>
								<ul class="submenu">
									@if($admin->menus[21] == 1)
									<li><a href="{{ url('/meisjejongetje/settings/useraccount/role') }}" id="group">Group</a></li>
									@endif
									@if($admin->menus[22] == 1)
									<li><a href="{{ url('/meisjejongetje/settings/useraccount/account') }}" id="account">Account</a></li>
									@endif
								</ul>
							</li>
							@endif
							@if($admin->menus[23] == 1)
							<li id="change-password">
								<a href="{{ url('/meisjejongetje/settings/changepassword') }}">
									<div class="link">Change Password</div>
								</a>
							</li>
							@endif
							<!-- SAMPLE POP UP
							<li>
								<a class="fancybox" href="#success">
									<div class="link">Success Pop Up</div>
								</a>
							</li>

							<li>
								<a class="fancybox" href="#failed">
									<div class="link">Failed Pop Up</div>
								</a>
							</li> -->
						</ul>
					</div>
				</div>

				<!-- SAMPLE OUTPUT POPUP -->

				<div id="success" class="width-pop">
					<div class="pad-pop">
						<div class="title-pop">SUCCESS</div>
						<div class="img-pop">
							<div class="pop-success"></div>
						</div>
						<div class="text-pop">Thank you, save changes!</div>
					</div>
				</div>

				<div id="failed" class="width-pop">
					<div class="pad-pop">
						<div class="title-pop">FAILED</div>
						<div class="img-pop">
							<div class="pop-failed"></div>
						</div>
						<div class="text-pop">Thank you, save changes!</div>
					</div>
				</div>
			</div>
		@show

		<div class="box-right">
			@if(Session::has('message'))
				<div class="alert {{Session::get('message')->type}}">
					{{Session::get('message')->content}}
				</div>
			@endif
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
						{{ $error }}
					@endforeach
				</div>
			@endif
			@yield('content')
		</div>
	</div>
	<!--
	<div class="loader" style="display:none;">
		<img src="{{ url('assets/images/icons/ajax-loader.gif') }}">
	</div>
	-->
</body>
</html>
