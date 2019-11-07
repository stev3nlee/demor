@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('.account-change-password').addClass('active');
		
		$('#submitPersonal').submit(function(e){
			e.preventDefault();
			$('input').removeClass('error');
			$('.form-error').html('');
			
			$.ajax({
				type: "post",
				url: "{{ url('member/changepassword/submit') }}",
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					if(data.success == false)
					{
						for(var i = 0; i < data.validation.length; i++)
						{
							$('[name='+data.validation[i].form+']').addClass('error');
							
							for(var j = 0; j < data.validation[i].msg.length; j++){
								$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+data.validation[i].msg[j]);
							}
						}
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
				<div class="col-sm-5 col-lg-4">
					<form method="post" id="submitPersonal">
						<div class="account04 bold account40">Change Password</div>
						<div class="form-group">
							<label>Old Password <span class="purple">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" class="form-control" name="id" value="{{$general->member->userid}}" />
							<input type="password" class="form-control" name="oldPassword"/>
							<div class="form-error" id="oldPasswordFormError"></div>
						</div>
						<div class="form-group">
							<label>New Password <span class="purple">*</span></label>
							<input type="password" class="form-control" name="newPassword"/>
							<div class="form-error" id="newPasswordFormError"></div>
						</div>
						<div class="form-group">
							<label>Confirm Password <span class="purple">*</span></label>
							<input type="password" class="form-control" name="confirmPassword"/>
							<div class="form-error" id="confirmPasswordFormError"></div>
						</div>
						<div>
							<button type="submit" class="btn btn120">SAVE CHANGES</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection