@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#submitExchange').submit(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');
			
			$.ajax({
				type: "post",
				url: "{{ url('pages/shippingexchange/submit') }}",
				data: $("#submitExchange").serialize(),
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

	<div id="content">
		<div class="container">
			<div class="text-center title30">
				<div class="title">SHIPPING & EXCHANGES</div>
				<div class="bdr-title"></div>
			</div>
			<ul class="tabs">
				<li class="tab-link current" data-tab="tab-1">SHIPPING</li>
				<li class="tab-link" data-tab="tab-2">EXCHANGES</li>
			</ul>

			<div id="tab-1" class="tab-content current ori-font">
				{!! $shipping->pagestext !!}
			</div>
			<div id="tab-2" class="tab-content ori-font">
				{!! $exchange->pagestext !!}
				<br/><br/>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="title-form">Exchange Product Form</div>
						<form id="submitExchange" method="post">
							<div class="form-group">
								<label>Full Name <span class="purple">*</span></label>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="text" class="form-control" name="fullName" />
								<div class="form-error" id="fullNameFormError"></div>
							</div>
							<div class="form-group">
								<label>Email Address <span class="purple">*</span></label>
								<input type="text" class="form-control" name="emailAddress" />
								<div class="form-error" id="emailAddressFormError"></div>
							</div>
							<div class="form-group">
								<label>Order Number <span class="purple">*</span></label>
								<input type="text" class="form-control txtboxToFilter" name="invoiceNumber" />
								<div class="form-error" id="invoiceNumberFormError"></div>
							</div>
							<div class="form-group">
								<label>Product Name <span class="purple">*</span></label>
								<input type="text" class="form-control" name="productName" />
								<div class="form-error" id="productNameFormError"></div>
							</div>
							<div class="form-group">
								<label>Details of Products (Size, Color, Qty) <span class="purple">*</span></label>
								<input type="text" class="form-control" name="detailProduct" />
								<div class="form-error" id="detailProductFormError"></div>
							</div>
							<div class="form-group">
								<label>Reason why you exchange <span class="purple">*</span></label>
								<input type="text" class="form-control" name="reason" />
								<div class="form-error" id="reasonFormError"></div>
							</div>
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="6LeuMBUUAAAAAGpNaSv2FgJPCLOMjkjal4AfjiSk"></div>
								<div class="form-error" id="captchaFormError"></div>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn120">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection