@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#submitLogin').submit(function(e){
			e.preventDefault();
			$('input').removeClass('error');
			$('.form-error').html('');
			$.ajax({
				type: "post",
				@if(isset(Request::segments()[1]))
				url: "{{ url('login/submit/confirmpayment') }}",
				@else
				url: "{{ url('login/submit') }}",
				@endif
				data: $("#submitLogin").serialize(),
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
						var d = JSON.parse(data.success);
						//1 = has a cart. 0 no cart
						if(d[1] == 1){
							location.href = "{{url('cart')}}";
						}else if(d[1]==2){
							location.href = "{{ url('member/confirmpayment') }}"
						}else{
							location.href = "{{url('member')}}";
						}
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
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<div class="title30">
						<div class="title text-center">LOG IN</div>
						<div class="bdr-title"></div>
					</div>
					<form method="post" id="submitLogin">
						<div class="form-group">
							<label class="error">Email Address <span class="purple">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" class="form-control" name="email" />
							<div class="form-error" id="emailFormError"></div>
						</div>
						<div class="form-group">
							<label>Password <span class="purple">*</span></label>
							<input type="password" class="form-control" name="password" />
							<div class="form-error" id="passwordFormError"></div>
						</div>
						<div class="form-group" id="errorDiv"></div>
						<div class="text-center mb20">
							<button type="submit" class="btn btn120">LOG IN</button>
						</div>
						<div class="text-center">
							<a href="{{ url('forgot') }}" class="link-small">Forgot Password?</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
