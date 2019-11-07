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
				<div class="col-sm-8">
					<div class="account02 bold account40">Order History #{{ $orderheader->orderno }}</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Shipping</div>
							@if($orderheader->status == 'Pending')
								<div class="m-name"><span class="orange">Pending</span></div>
							@elseif($orderheader->status == 'Waiting')
								<div class="m-name"><span class="orange">Pending</span></div>
							@elseif($orderheader->status == 'Paid')
								<div class="m-name"><span class="orange">Waiting</span></div>
							@elseif($orderheader->status == 'Ship')
								<div class="m-name"><span class="green">Shipped</span></div>
							@endif
						</div>
						<div class="col-sm-5">
							<div class="m-title">Payment</div>
							@if($orderheader->status == 'Pending')
								<div class="m-name"><span class="orange">Pending</span></div>
							@elseif($orderheader->status == 'Waiting')
								<div class="m-name"><span class="orange">Waiting</span></div>
							@elseif($orderheader->status == 'Paid')
								<div class="m-name"><span class="green">Paid</span></div>
							@elseif($orderheader->status == 'Ship')
								<div class="m-name"><span class="green">Paid</span></div>
							@endif
						</div>
					</div>
					@if($orderheader->status == 'Ship')
					<div class="row order40">
						<div class="col-sm-10">
							<div class="m-title">Tracking No</div>
							<div class="m-name">{{$orderheader->trackingno}}</div>
						</div>
					</div>
					@endif
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Billing Info</div>
							<div class="m-name">
								<div>{{$orderinfo[1]->firstname}} {{$orderinfo[1]->lastname}}</div>
								<div>{{$orderinfo[1]->mobilenumber}}</div>
								<div>{{$orderinfo[1]->telphonenumber}}</div>
								<div>{{$orderinfo[1]->address}}</div>
								<div>{{$orderinfo[1]->city}}, {{$orderinfo[1]->zipcode}}</div>
								<div>{{$orderinfo[1]->state}}, {{$orderinfo[1]->country}}</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Shipping Info</div>
							<div class="m-name">
								<div>{{$orderinfo[0]->firstname}} {{$orderinfo[0]->lastname}}</div>
								<div>{{$orderinfo[0]->mobilenumber}}</div>
								<div>{{$orderinfo[0]->telphonenumber}}</div>
								<div>{{$orderinfo[0]->address}}</div>
								<div>{{$orderinfo[0]->city}}, {{$orderinfo[0]->zipcode}}</div>
								<div>{{$orderinfo[0]->state}}, {{$orderinfo[0]->country}}</div>
							</div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Payment</div>
							<div class="m-name">@if($orderheader->paymenttype == 'VT Web') Credit Card @else {{ $orderheader->paymenttype }} @endif</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Delivery</div>
							<div class="m-name">Regular</div>
						</div>
					</div>
					<div class="row order80">
						<div class="col-sm-10">
							<div class="m-title">Notes</div>
							<div class="m-name">{{ $orderheader->note }}</div>
						</div>
					</div>
					<div id="order-item" class="data-table detail-order">
						<div class="list header">
							<div>Item</div>
							<div class="w150 text-center hidden-xs hidden-sm">Price</div>
							<div class="w150 text-center hidden-xs hidden-sm">Quantity</div>
							<div class="w150 text-right hidden-xs hidden-sm">Total</div>
						</div>
						@php ($quantity = 0)
						@foreach($orderdetail as $detail)
						@php ($quantity += $detail->quantity)
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
											</div>
										</div>
										<div class="w150 text-center hidden-xs">{{-- IDR {{str_replace(",",".",number_format($detail->productprice))}} --}}
											<span class="selected-currency">IDR</span>
											<span class="default-price-hidden hide">{{ $detail->productprice }}</span>
											<span class="selected-currency-value">{{ $detail->productprice }}</span>
										</div>
										<div class="w150 text-center hidden-xs">{{$detail->quantity}}</div>
										<div class="w150 hidden-xs hidden-xs">{{-- IDR {{str_replace(",",".",number_format($detail->productprice * $detail->quantity))}} --}}
											<span class="selected-currency">IDR</span>
											<span class="default-price-hidden hide">{{ $detail->productprice * $detail->quantity }}</span>
											<span class="selected-currency-value">{{ $detail->productprice * $detail->quantity }}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="hidden-sm hidden-md hidden-lg">
								<div class="list header">
									<div class="w35">Price</div>
									<div class="w30 text-center">Qty</div>
									<div class="w35 text-right">Total</div>
								</div>
								<div class="list items">
									<div class="w35">{{-- IDR {{str_replace(",",".",number_format($detail->productprice))}} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $detail->productprice }}</span>
										<span class="selected-currency-value">{{ $detail->productprice }}</span>
									</div>
									<div class="w30 text-center">{{$detail->quantity}}</div>
									<div class="w35 text-right">{{-- IDR {{str_replace(",",".",number_format($detail->productprice * $detail->quantity))}} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $detail->productprice * $detail->quantity }}</span>
										<span class="selected-currency-value">{{ $detail->productprice * $detail->quantity }}</span>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						<div class="list items order-total-count">
							<div class="order-left">
								<div class="in mb10">
									<div class="sub-title w110">Voucher Code</div>
									<div class="w180">
										<input type="text" class="form-control input-order" name="promo" disabled value="{{ $orderheader->voucher }}"/>
									</div>
								</div>
							</div>
							<div class="">
								<div class="in mb10">
									<div class="sub-title">
										<div>SUBTOTAL</div>
										<div class="small">({{ $quantity }} Piece(s))</div>
									</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->subtotal)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->subtotal }}</span>
										<span class="selected-currency-value">{{ $orderheader->subtotal }}</span>
									</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">
										<div>VOUCHER</div>
									</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->vouchernominal)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->vouchernominal }}</span>
										<span class="selected-currency-value">{{ $orderheader->vouchernominal }}</span>
									</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">SHIPPING FEE</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->shippingfee)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->shippingfee }}</span>
										<span class="selected-currency-value">{{ $orderheader->shippingfee }}</span>
									</div>
								</div>
								<div class="in">
									<div class="sub-title">TAXES</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->tax)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->tax }}</span>
										<span class="selected-currency-value">{{ $orderheader->tax }}</span>
									</div>
								</div>
								@if($orderheader->conveniencefee != 0)
								<div class="in">
									<div class="sub-title">CONVENIENCE FEE</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->conveniencefee)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->conveniencefee }}</span>
										<span class="selected-currency-value">{{ $orderheader->conveniencefee }}</span>
									</div>
								</div>
								<div class="in">
									<div class="sub-title">ORDER TOTAL</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee }}</span>
										<span class="selected-currency-value">{{ $orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee }}</span>
									</div>
								</div>
								@else
								<div class="in">
									<div class="sub-title">ORDER TOTAL</div>
									<div class="w180">{{-- IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax)) }} --}}
										<span class="selected-currency">IDR</span>
										<span class="default-price-hidden hide">{{ $orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax }}</span>
										<span class="selected-currency-value">{{ $orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax }}</span>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
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
