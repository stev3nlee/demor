@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('.account-newsletter').addClass('active');
	})
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
					<div class="account03 bold account40">Newsletter</div>
					@if(empty($issubscribe))
					<div class="box-subscribed">
						<div class="form-group">
							<label style="margin-bottom: 0;">You are not currently subscribed to our newsletter. Subscribe now?</label>
						</div>
						<div>
							<a class="fancybox" href="#newsletter"><button type="button" class="btn btn-blue">SUBSCRIBE</button></a>
						</div>
					</div>
					@else
					<div class="box-subscribed">
						<div class="form-group">
							<label style="margin-bottom: 0;">You are currently subscribed to our newsletter. Unsubscribe now?</label>
						</div>
						<div>
							<a class="fancybox" href="#newsletter2"><button type="button" class="btn btn-blue btn-unsubscribed">UNSUBSCRIBE</button></a>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<!--Newsletter -->
	<div id="newsletter" class="width-pop">
		<div class="pad-pop">
			<div class="img-pop">
				<img src="{{url('assets/images/icons/newsletter.png') }}" class="img-responsive"/>
			</div>
			<div class="text-pop mb30">Do you want to subscribe to our newsletter?</div>
			<div class="clearfix text-center">
				<div class="inline-block mr25">
					<form action="{{url('submitnewsletter2')}}" method="post">
						{{csrf_field()}}
						<input type="hidden" name="email" value="{{$general->member->email}}"/>
						<a class="button-subscribed"><button type="submit" class="btn btn-blue">Yes</button></a>
					</form>
				</div>
				<div class="inline-block">
					<button type="button" class="btn btn-red close-fancy">No</button>
				</div>
			</div>
		</div>
	</div>

	<div id="newsletter2" class="width-pop">
		<div class="pad-pop">
			<div class="img-pop">
				<img src="{{url('assets/images/icons/newsletter.png') }}" class="img-responsive"/>
			</div>
			<div class="text-pop mb30">Do you want to unsubscribe to our newsletter?</div>
			<div class="clearfix text-center">
				<div class="inline-block mr25">
					<form action="{{url('deletenewsletter')}}" method="post">
						{{csrf_field()}}
						<input type="hidden" name="email" value="{{$general->member->email}}"/>
						<a class="button-unsubscribed"><button type="submit" class="btn btn-blue">Yes</button></a>
					</form>
				</div>
				<div class="inline-block">
					<button type="button" class="btn btn-red close-fancy">No</button>
				</div>
			</div>
		</div>
	</div>

@endsection
