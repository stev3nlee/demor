@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#submitRegister').submit(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');
			$('#date').removeClass('select-error');
			$('#month').removeClass('select-error');
			$('#year').removeClass('select-error');

			$.ajax({
				type: "post",
				url: "{{ url('register/submit') }}",
				data: $("#submitRegister").serialize(),
				dataType: 'json',
				success: function (data) {
					if(data.success == false)
					{
						for(var i = 0; i < data.validation.length; i++)
						{
							$('[name='+data.validation[i].form+']').addClass('error');

							$('#'+data.validation[i].form).addClass('select-error');

							for(var j = 0; j < data.validation[i].msg.length; j++){
								$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+data.validation[i].msg[j]);
							}
						}
					}
					else{
						$.fancybox.open({
							href: '#success',
						});
						location.href = "{{url('login')}}";
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
	});
	</script>

	<div id="content">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="title30">
						<div class="title text-center">REGISTER</div>
						<div class="bdr-title"></div>
					</div>
					<form method="post" id="submitRegister">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>First Name <span class="purple">*</span></label>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="text" class="form-control" name="firstName" />
									<div class="form-error" id="firstNameFormError"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Last Name <span class="purple">*</span></label>
									<input type="text" class="form-control" name="lastName" />
									<div class="form-error" id="lastNameFormError"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Email Address <span class="purple">*</span></label>
							<input type="text" class="form-control" name="email" />
							<div class="form-error" id="emailFormError"></div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Date of birth <span class="purple">*</span></label>
									<div class="clearfix">
										<div class="custom-select w-date pull-left" id="date">
											<div class="replacement">Select Date</div>
											<select class="custom-select" name="date" onChange="custom_select(this)">
												<option value="0" selected disabled>Select Date</option>
												@for($i = 1; $i <= 31; $i++)
												<option value="{{$i}}">{{$i}}</option>
												@endfor
											</select>
										</div>
										<div class="custom-select w-date pull-left" id="month">
											<div class="replacement">Select Month</div>
											<select class="custom-select" name="month" onChange="custom_select(this)">
												<option value="0" selected disabled>Select Month</option>
												<option value="1">Jan</option>
												<option value="2">Feb</option>
												<option value="3">Mar</option>
												<option value="4">Apr</option>
												<option value="5">May</option>
												<option value="6">Jun</option>
												<option value="7">Jul</option>
												<option value="8">Aug</option>
												<option value="9">Sep</option>
												<option value="10">Oct</option>
												<option value="11">Nov</option>
												<option value="12">Dec</option>
											</select>
										</div>
										<div class="custom-select w-year pull-left" id="year">
											<div class="replacement">Select Year</div>
											<select class="custom-select" name="year" onChange="custom_select(this)">
												<option value="0" selected disabled>Select Year</option>
												@for ($i = date('Y') - 17; $i >= 1950; $i--)
												<option value="{{$i}}">{{$i}}</option>
												@endfor
											</select>
										</div>
									</div>
									<div class="form-error" id="dateFormError"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
								<label>Gender <span class="purple">*</span></label>
								<div class="custom-select">
									<div class="replacement">Male</div>
									<select class="custom-select" name="gender" onChange="custom_select(this)">
										<option value="Male" selected>Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Password <span class="purple">*</span></label>
									<input type="password" class="form-control" name="password1" />
									<div class="form-error" id="password1FormError"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Confirm Password<span class="purple">*</span></label>
									<input type="password" class="form-control" name="password2" />
									<div class="form-error" id="password2FormError"></div>
								</div>
							</div>
						</div>
						<div class="row mb30">
							<div class="col-sm-6 col-sm-offset-4">
								<div class="mb20">
									<div class="option-check">
										<input class="labeled-checkbox" type="checkbox" id="labeled-terms" name="terms" >
										<label for="labeled-terms">
											<span class="labeled-checkbox-unchecked"></span>
											<span class="labeled-checkbox-checked"></span>
										</label>
										<span class="text-check">I AGREE WITH <a href="{{url('pages/termcondition')}}" target="_blank">TERMS AND CONDITIONS</a></span>
									</div>
									<div class="form-error" id="termsFormError"></div>
								</div>
								<div>
									<div class="option-check">
										<input class="labeled-checkbox" type="checkbox" id="labeled-newsletter" name="newsletter"/>
										<label for="labeled-newsletter">
											<span class="labeled-checkbox-unchecked"></span>
											<span class="labeled-checkbox-checked"></span>
										</label>
										<span class="text-check">SUBSCRIBE TO OUR NEWSLETTERS</span>
									</div>
								</div>
							</div>
						</div>
						<div class="text-center mb20">
							<button type="submit" class="btn btn120">REGISTER</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
