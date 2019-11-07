@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('.account-confirm-payment').addClass('active');
	});
	
	function validatePayment()
	{
		$('input, textarea').removeClass('error');
		$('.form-error').html('');
		var flag = false;
		
		$.ajax({
			type: "post",
			url: "{{ url('member/confirmpayment/validate') }}",
			data: $("#submitConfirm").serialize(),
			dataType: 'json',
			async: false,
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
				else if($("[name=pictureEvidence]").val()=='')
				{
					$('#pictureEvidenceFormError').html('Picture Evidence must be choosen');
				}
				else{
					$.fancybox.open({
						href: '#success',
					});
					flag = true;
				}
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
		return flag;
	}
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
				<div class="col-sm-8 col-lg-7">
					<div class="account06 bold account40">Confirm Payment</div>
					<form id="submitConfirm" method="post" action="{{ url('member/confirmpayment/submit') }}" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Order No <span class="purple">*</span></label>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="text" class="form-control" name="orderNo"/>
									<div class="form-error" id="orderNoFormError"></div>
								</div>	
								<div class="form-group">
									<label>Account No <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountNo"/>
									<div class="form-error" id="accountNoFormError"></div>
								</div>
								<div class="form-group">
									<label>Account Name <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountName"/>
									<div class="form-error" id="accountNameFormError"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Payment To <span class="purple">*</span></label>
									<div class="custom-select">													
										<div class="replacement">Please Select</div>
										<select class="custom-select" name="paymentTo" onChange="custom_select(this)">
											<option value="" selected>Please Select</option>
											@foreach($banks as $bank)
												<option value="{{$bank->transferid}}">{{$bank->bankname}} - {{$bank->accountnumber}}</option>
											@endforeach
										</select>													
									</div>
									<div class="form-error" id="paymentToFormError"></div>
								</div>							
								<div class="form-group">
									<label>Total Amount <span class="purple">*</span></label>
									<input type="text" class="form-control" name="totalAmmount"/>
									<div class="form-error" id="totalAmmountFormError"></div>
								</div>
								<div class="form-group">
									<label>Upload Image (Evidence) <span class="purple">*</span></label>
										 <input type="file" name="pictureEvidence" accept="image/*" required />
									</label>
									<div class="form-error" id="pictureEvidenceFormError"></div>
								</div>
							</div>
						</div>					
						<div>
							<button onClick="return validatePayment()" type="submit" class="btn btn120">SUBMIT</button>
						</div>
					</form>
					<div style="margin-top:30px; font-size:16px; ">
						<div>Click <a href="{{url('member/confirmpaymentshipping')}}">here</a> to confirm payment for shipping cost only</div>
					</div> 
				</div>
			</div>
		</div>
	</div>

@endsection