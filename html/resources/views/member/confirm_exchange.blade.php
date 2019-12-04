@extends('layouts.master')
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
									<input type="text" class="form-control" name="orderNo" />
								</div>
								<div class="form-group">
									<label>Account No <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountNo" />
								</div>
								<div class="form-group">
									<label>Account Name <span class="purple">*</span></label>
									<input type="text" class="form-control" name="accountName" />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Payment To <span class="purple">*</span></label>
									<div class="custom-select">
										<div class="replacement">Please Select</div>
										<select class="custom-select" name="paymentTo" onChange="custom_select(this)">
											@foreach($banks as $bank)
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Total Amount <span class="purple">*</span></label>
									<input type="text" class="form-control" name="totalAmmount"/>
								</div>
								<div class="form-group">
									<label>Upload Image (Evidence) <span class="purple">*</span></label>
										 <input type="file" name="pictureEvidence" accept="image/*">
									</label>
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
	</div>