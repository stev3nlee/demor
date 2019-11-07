@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('.account-order').addClass('active');
	});
	</script>
	
	<div id="content" class="box-date">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-lg-3 resp40">
					<div class="title30">
						<div class="title">MEMBER AREA</div>
						<div class="bdr-title no-center"></div>
					</div>
					<div class="visible-xs mb25">
						<div class="custom-select">
							<div class="replacement">Personal</div>
							<select name="country" class="custom-select" onChange="change_mymenu(this.value)">
								<option value="{{ url('/member') }}" selected>Personal</option>
								<option value="{{ url('/member/order') }}">Order History</option>
								<option value="{{ url('/member/confirmpayment') }}">Confirm Payment</option>
								<option value="{{ url('/member/newsletter') }}">Newsletter</option>
								<option value="{{ url('/member/changepassword') }}">Change Password</option>
								<option value="{{ url('logout') }}">Log Out</option>
							</select>
						</div>
					</div>
					<ul class="list-account hidden-xs">
						<li>
							<a class="account-personal" href="{{ url('/member') }}">
								<div class="account01">Personal</div>
							</a>
						</li>
						<li>
							<a class="account-order" href="{{ url('/member/order') }}">
								<div class="account02">Order History</div>
							</a>
						</li>
						<li>
							<a class="account-confirm-payment" href="{{ url('/member/confirmpayment') }}">
								<div class="account06">Confirm Payment</div>
							</a>
						</li>
						<li>
							<a class="account-newsletter" href="{{ url('/member/newsletter') }}">
								<div class="account03">Newsletter</div>
							</a>
						</li>
						<li>
							<a class="account-change-password" href="{{ url('/member/changepassword') }}">
								<div class="account04">Change Password</div>
							</a>
						</li>
					</ul>
					<a class="a-logout hidden-xs" href="{{ url('logout') }}">LOG OUT</a>
				</div>
				<div class="col-sm-8 col-lg-9">
					@if(count($permit) != 0)
					<div class="account02 bold account40">Permit Detail</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Order No</div>
							<div class="m-name">#{{$permit->orderno}}</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Exchange</div>
							<div class="m-name"><span class="blue">Permit</span></div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Voucher</div>
							<div class="m-name">{{$permit->voucher}}</div>
						</div>
					</div>
					<div id="order-item" class="data-table detail-order">
						<div class="list header">
							<div>Item</div>
							<div class="w150 text-center hidden-xs">Quantity</div>
						</div>
						@foreach($permit->permitdetail as $detail)
						<div class="table-order">
							<div class="list items">
								<div class="w80">
									<img src="{{url($detail->productimage)}}" class="img-responsive" />
								</div>
								<div class="">
									<div class="in">
										<div>
											<div class="t-product">{{$detail->productname}}</div>
											<div class="txt-grey">
												<div class="clearfix mb10">
													<div class="pull-left w50">Color</div>
													<div class="pull-left color-cart">
														<img src="{{ url($detail->productcolor) }}" class="img-responsive" />
													</div>
												</div>
												<div class="clearfix mb10">
													<div class="pull-left w50">Size</div>
													<div class="pull-left">{{$detail->productsize}}</div>
												</div>
												<div class="clearfix visible-xs">
													<div class="pull-left w50">Qty</div>
													<div class="pull-left">{{$detail->quantity}}</div>
												</div>
											</div>
										</div>
										<div class="w150 hidden-xs" style="text-align: center !important;">{{$detail->quantity}}</div>								
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@endif
					@if(count($notpermit) != 0)
					<div class="account02 bold account40">Not Permit Detail</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Order No</div>
							<div class="m-name">#{{$notpermit->orderno}}</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Exchange</div>
							<div class="m-name"><span class="blue">Not Permit</span></div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Product Name</div>
							<div class="m-name">{{$notpermit->productname}}</div>
						</div>
						<div class="col-sm-5 resp30">
							<div class="m-title">Product Size</div>
							<div class="m-name">{{$notpermit->size}}</div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Product Colour</div>
							<div class="m-name">{{$notpermit->colour}}</div>
						</div>
						<div class="col-sm-5 resp30">
							<div class="m-title">Product Quantity</div>
							<div class="m-name">{{$notpermit->quantity}}</div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Shipping Cost</div>
							<div class="m-name">{{$notpermit->shippingcost}}</div>
						</div>
					</div>
					@endif
					@if(count($refund) != 0)
					<div class="account02 bold account40">Refund Detail</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Order No</div>
							<div class="m-name">#{{$refund[0]->orderno}}</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Exchange</div>
							<div class="m-name"><span class="blue">Refund</span></div>
						</div>
					</div>
					<div id="order-item" class="data-table detail-order">
						<div class="list header">
							<div>Item</div>
							<div class="w150 text-center hidden-xs">Quantity</div>
						</div>
						@foreach($refund as $detail)
						<div class="table-order">
							<div class="list items">
								<div class="w80">
									<img src="{{url($detail->productimage)}}" class="img-responsive" />
								</div>
								<div class="">
									<div class="in">
										<div>
											<div class="t-product">{{$detail->productname}}</div>
											<div class="txt-grey">
												<div class="clearfix mb10">
													<div class="pull-left w50">Color</div>
													<div class="pull-left color-cart">
														<img src="{{ url($detail->productcolor) }}" class="img-responsive" />
													</div>
												</div>
												<div class="clearfix mb10">
													<div class="pull-left w50">Size</div>
													<div class="pull-left">{{$detail->productsize}}</div>
												</div>
												<div class="clearfix visible-xs">
													<div class="pull-left w50">Qty</div>
													<div class="pull-left">{{$detail->quantity}}</div>
												</div>
											</div>
										</div>
										<div class="w150 hidden-xs" style="text-align: center !important;">{{$detail->quantity}}</div>								
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@endif
					<a href="{{ url('member/order') }}">
						<button class="btn btn120">
							<div class="icon-cart">Back</div>
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection