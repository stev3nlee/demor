@extends('layouts.master')@section('title', 'Page Title')@section('content')	<script>	function validatePayment()	{		$('input, textarea').removeClass('error');		$('.form-error').html('');		var flag = false;		$.ajax({			type: "post",			url: "{{ url('member/confirmpayment/validate') }}",			data: $("#submitConfirm").serialize(),			dataType: 'json',			async: false,			success: function (data) {				if(data.success == false)				{					for(var i = 0; i < data.validation.length; i++)					{						$('[name='+data.validation[i].form+']').addClass('error');						for(var j = 0; j < data.validation[i].msg.length; j++){							$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+data.validation[i].msg[j]);						}					}				}				else if($("[name=pictureEvidence]").val()=='')				{					$('#pictureEvidenceFormError').html('Picture Evidence must be choosen');				}				else{					$.fancybox.open({						href: '#success',					});					flag = true;				}			},			error: function (data) {				console.log('Error:', data);			}		});		return flag;	}	</script>
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="title30">
						<div class="title text-center">CONFIRM PAYMENT</div>
						<div class="bdr-title"></div>
					</div>
					<form method="post" id="submitConfirm" action="{{ url('member/confirmexchange/submit') }}" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Order No <span class="purple">*</span></label>
									<input type="text" class="form-control" name="orderNo" />									<input type="hidden" name="isexchange" value="true" />									<input type="hidden" name="_token" value="{{ csrf_token() }}">									<div class="form-error" id="orderNoFormError"></div>
								</div>
								<div class="form-group">
									<label>Account No <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountNo" />									<div class="form-error" id="accountNoFormError"></div>
								</div>
								<div class="form-group">
									<label>Account Name <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountName" />									<div class="form-error" id="accountNameFormError"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Payment To <span class="purple">*</span></label>
									<div class="custom-select">
										<div class="replacement">Please Select</div>
										<select class="custom-select" name="paymentTo" onChange="custom_select(this)">											<option value="" selected>Please Select</option>
											@foreach($banks as $bank)												<option value="{{$bank->transferid}}">{{$bank->bankname}} - {{$bank->accountnumber}}</option>											@endforeach
										</select>
									</div>									<div class="form-error" id="paymentToFormError"></div>
								</div>
								<div class="form-group">
									<label>Total Amount <span class="purple">*</span></label>
									<input type="text" class="form-control" name="totalAmmount"/>									<div class="form-error" id="totalAmmountFormError"></div>
								</div>
								<div class="form-group">
									<label>Upload Image (Evidence) <span class="purple">*</span></label>
										 <input type="file" name="pictureEvidence" accept="image/*">
									</label>									<div class="form-error" id="pictureEvidenceFormError"></div>
								</div>
							</div>
						</div>
						<div class="text-center mb20">
							<button onClick="return validatePayment()" type="submit" class="btn btn120">SUBMIT</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>@endsection