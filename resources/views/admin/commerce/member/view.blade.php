@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
		$(function() {
			$('#member').addClass ('active');
		});

		$('#table_id2').DataTable({ "order" : [[0,"desc"]]  })
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
		<div class="title">View Member: <span style="margin-left: 10px;">{{ $user->firstname.' '.$user->lastname }}</span></div>
		<div class="content">
			<div id="tabs-container">
				<div class="clearfix">
					<div class="pull-left mr30" style="width: 170px;">
						<ul class="tabs-menu">
							<li class="current"><a href="#tab-1">Personal</a></li>
							<li><a href="#tab-2">Address</a></li>
							<li><a href="#tab-3">Order</a></li>
						</ul>
						<div>
							<a href="{{ url('meisjejongetje/commerce/member') }}"><button type="button" class="btn btn-pop" style="width: 125px; margin-top: 0;">Back</button></a>
						</div>
					</div>
					<div class="pull-left">
						<div class="tab">
							<div id="tab-1" class="tab-content">
								<div class="t-code">Personal</div>
								<div class="full-product">
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">First Name</p>
											<p>{{ $user->firstname }}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Last Name</p>
											<p>{{ $user->lastname }}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Email Address</div>
										<div class="w-order">{{ $user->emailaddress }}</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Date of Birth</p>
											<p>{{ $user->dateofbirth }}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Gender</p>
											<p>{{ $user->gender }}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-2" class="tab-content">
								<div class="t-code">Address</div>
								<div class="full-product">
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Country</p>
											<p>{{ $user->countryname }}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">State</p>
											<p>{{ $user->statename }}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">City</p>
											<p>{{ $user->cityname }}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Post Code</p>
											<p>{{ $user->postcode }}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Address</div>
										<div class="w-order">{{ $user->address }}</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Telephone Number</p>
											<p>{{ $user->telphonenumber }}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Mobile Number</p>
											<p>{{ $user->mobilenumber }}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-3" class="tab-content">
								<div class="t-code">Order History</div>
								<div class="adminTable">
									<table id="table_id2" style="width: 100% !important;">
										<thead>
											<tr class="no-sort">
												<td width="100">Order Number</td>
												<td width="150">Date</td>
												<td>Total Price</td>
												<td width="80" class="text-center">Action</td>
											</tr>
										</thead>
										<tbody>
											@foreach($orders as $o)
											<tr>
												<td>#{{$o->orderno}}</td>
												<td>{{$o->insertdate}}</td>
												<td>IDR {{str_replace(",",".",number_format($o->subtotal - $o->vouchernominal + $o->shippingfee + $o->tax + $o->conveniencefee))}}</td>
												<td class="text-center">
													<a class="link" href="{{ url('meisjejongetje/commerce/order/view/'. $o->orderno) }}">
														<div class="img-view"></div>
													</a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div id="tab-4" class="tab-content">
								<div class="t-code">Shipping</div>
								<div class="full-product">
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">First Name</p>
											<p>Jane</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Last Name</p>
											<p>Doe</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Email Address</div>
										<div class="w-order">janedoe@yahoo.com</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Address</div>
										<div class="w-order">Ancol Lodan</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Country</p>
											<p>Indonesia</p>
										</div>
										<div class="wdth50">
											<p class="htitle">State</p>
											<p>Dki Jakarta</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">City</p>
											<p>Jakarta</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Zip Code</p>
											<p>22560</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Telephone Number</p>
											<p>021 234567890</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Mobile Number</p>
											<p>021 234567890</p>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-5" class="tab-content">
								<div class="full-product">
									<div class="t-code">Product</div>
									<div class="mb30">
										<p class="htitle">Order Note</p>
										<p>Bajunya tidak boleh luntur.</p>
									</div>
									<div class="adminTable">
										<table id="table_id" style="width: 100% !important;">
											<thead>
												<tr>
													<td>Item</td>
													<td width="200" class="text-center">Price</td>
													<td width="200" class="text-center">Quantity</td>
													<td width="200" class="text-right">Total</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<div class="clearfix">
															<div class="pull-left mr20">
																<div class="table-imgproduct">
																	<img src="http://localhost/demorboutique/assets/images/uploads/product01.jpg" class="img-responsive">
																</div>
															</div>
															<div class="pull-left">
																<div class="detail-product">Sweater Blue</div>
																<div class="s-title">
																	<div>Color : Grey</div>
																	<div>Size : M</div>
																</div>
															</div>
														</div>
													</td>
													<td class="text-center">IDR 30.000</td>
													<td class="text-center">1</td>
													<td class="text-right">IDR 30.000</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td rowspan="1" colspan="2">
														<div class="clearfix">
															<div style="float: left; margin-right: 10px; position: relative; top: 3px;">PROMO CODE</div>
															<div style="width: 150px; float:left;">
																<input type="text" class="form-control" name="promo" disabled value="DEMOR DISCOUNT"/>
															</div>
														</div>
													</td>
													<td rowspan="1" colspan="2">
														<div class="text-right">
															<p> SUBTOTAL : IDR 30.000 </p>
															<p> SHIPPING FEE : IDR 5.000 </p>
															<p> TAXES : IDR 25.000 </p>
															<p> CONVENIENCE FEE : IDR 3.000 </p>
															<p> ORDER TOTAL : IDR 1.000 </p>
														</div>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
							<div id="tab-6" class="tab-content">
								<div class="t-code">History</div>
								<div class="adminTable">
									<table id="table_id2" style="width: 100% !important;">
										<thead>
											<tr>
												<td>Date</td>
												<td>Payment</td>
												<td>Shipping</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>28 May 2016</td>
												<td class="red">Cancelled</td>
												<td class="red">Cancelled</td>
											</tr>
											<tr>
												<td>30 May 2016</td>
												<td class="green">Paid</td>
												<td class="green">Shipped</td>
											</tr>
											<tr>
												<td>1 June 2016</td>
												<td class="blue">Refund</td>
												<td class="blue">Returned</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div id="tab-7" class="tab-content">
								<div class="t-code">Payment 1</div>
								<div>
									<div class="t-order">Payment Method</div>
									<div class="w-order">Visa / Credit Card / Master Card</div>
								</div>
							</div>
							<div id="tab-8" class="tab-content">
								<div class="t-code">Payment 2</div>
								<div>
									<div class="t-order">Payment Method</div>
									<div class="w-order">Bank Transfer</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Account No</div>
									<div class="w-order">1950992885</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Account Name</div>
									<div class="w-order">Chyntia Rosabel</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Payment To</div>
									<div class="w-order">BCA 123456789</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Image</div>
									<div class="w-order">
										<img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/assets/images/bca.jpg" class="img-responsive" style="width: 150px;">
									</div>
								</div>
								<div class="border-title"></div>
								<div class="mb20">
									<div class="t-order">Total</div>
									<div class="w-order">IDR 30.000</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
