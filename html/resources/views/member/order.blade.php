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
					<div class="account02 bold account40">Order History</div>
					<table id="table-order" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Order Number</th>
								<th>Date</th>
								<th>Total Price</th>
								<th>Shipping</th>
								<th>Payment</th>
								<th>Exchange</th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
							<tr>
								<td><a class="link-table" href="{{ url('member/order/view/'.$order->orderno) }}">#{{$order->orderno}}</a></td>
								<td>{{$order->insertdate}}</td>
								<td>{{-- IDR {{str_replace(",",".",number_format($order->subtotal - $order->vouchernominal + $order->conveniencefee + $order->shippingfee + $order->tax)) }} --}}
									<span class="selected-currency">IDR</span>
									<span class="default-price-hidden hide">{{ $order->subtotal - $order->vouchernominal + $order->conveniencefee + $order->shippingfee + $order->tax }}</span>
									<span class="selected-currency-value">{{ $order->subtotal - $order->vouchernominal + $order->conveniencefee + $order->shippingfee + $order->tax }}</span>
								</td>
								@if($order->status == 'Pending')
									<td><div class="orange">Pending</div></td>
									<td><div class="orange">Pending</div></td>
								@elseif($order->status == 'Waiting')
									<td><div class="orange">Pending</div></td>
									<td><div class="orange">Waiting</div></td>
								@elseif($order->status == 'Paid')
									<td><div class="orange">Waiting</div></td>
									<td><div class="green">Paid</div></td>
								@elseif($order->status == 'Ship')
									<td><div class="green">Shipped</div></td>
									<td><div class="green">Paid</div></td>
								@elseif($order->status == 'Cancel')
									<td><div class="red">Canceled</div></td>
									<td><div class="red">Canceled</div></td>
								@endif
								<td><a href="{{ url('member/exchangedetail/'.$order->orderno) }}">{{ $order->exchangedate }}</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
