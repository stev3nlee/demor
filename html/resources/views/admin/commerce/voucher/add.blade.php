@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#voucher').addClass ('active');
		
		$('[name=isLimited]').change(function(e){
			if($(this).prop('checked'))
			{
				$("[name='vat']").prop('disabled', true);
				$("[name='vat']").val('');
			}
			else
			{
				$("[name='vat']").prop('disabled', false);
			}
		});
		$('[name=isExpired]').change(function(e){
			if($(this).prop('checked'))
			{
				$("[name='beginDate']").prop('disabled', true);
				$("[name='endDate']").prop('disabled', true);
				$("[name='beginDate']").val('');
				$("[name='endDate']").val('');
			}
			else
			{
				$("[name='beginDate']").prop('disabled', false);
				$("[name='endDate']").prop('disabled', false);
			}
		});
	});
	</script>
		
	<div class="content">
		<div class="breadcrumb">
			@foreach($breadCrumb as $index => $b)
				@if($b->path == '')
					<span class="active">{{$b->name}}</span>
				@else
					<a href="{{ url($b->path) }}">{{$b->name}}</a>
				@endif
				@if($index != count($breadCrumb) - 1)
					<span class="m10"> > </span>
				@endif
			@endforeach
		</div>
		<div class="title">Add Voucher</div>
		<form method="post" action="{{url('meisjejongetje/commerce/voucher/submit')}}">
			<div class="clearfix row">
				<div class="wdth50">
					<h3>Voucher Details</h3>
					<div class="form-group">
						<label>Voucher name <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="voucherName">
					</div>
					<div class="clearfix mb30">
						<div class="display-inline mr10 pos-det">How many times can this discount be used?</div>
						<div class="display-inline mr10">
							<input type="text" class="form-control txtboxToFilter" maxlength="3" name="vat" style="width: 50px;"/>
						</div>
						<div class="display-inline pos-det"><input type="checkbox" checked="" name="isLimited" value="true"> No Limit</div>
					</div>
					<h3 class="mb20">Voucher Type</h3>
					<div class="clearfix mb30">
						<div class="display-inline mr10 pos-det">IDR</div>
						<div class="display-inline mr10">
							<input type="text" class="form-control txtboxToFilter" name="price" style="width: 100px;"/>
						</div>
						<div class="display-inline pos-det mr10">For</div>
						<div class="display-inline">
							<select name="category" class="form-control auto">
								<option value="0">All</option>
								@foreach($productCategories as $category)
									<option value="{{$category->categoryid}}">{{$category->categoryname}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="wdth50">
					<h3>Date Range</h3>
					<p style="margin-bottom: 10px;">Specify when this discount begins and ends. </p>
					<div class="form-group">
					<label>Discount Begins <span class="red">*</span></label>
						<input type="text" class="form-control start-date" name="beginDate">
					</div>
					<div class="form-group">
						<label>Discount Ends <span class="red">*</span></label>
						<input type="text" class="form-control expired-date" name="endDate">
					</div>
					<div class="form-group">
						<input type="checkbox" name="isExpired" value="true"> Never Expired <p></p>
					</div>
				</div>
			</div>
			<div>
				<a href="{{ url('meisjejongetje/commerce/voucher') }}"><button type="button" class="btn btn-pop mr10">Back</button></a>
				<input type="submit" class="btn btn-pop" value="Submit">
			</div>
		</form>
	</div>

<!--
<script>
jQuery(function(){
	jQuery('.start-date').datetimepicker({

		formatDate:'Y/m/d',
		minDate:'-1970/01/02',//yesterday is minimum date(for today use 0 or -1970/01/01)
		onShow:function( ct ){
		this.setOptions({
		maxDate:jQuery('.expired-date').val()?jQuery('.expired-date').val():false
		})
		},
		timepicker:false
	});
	jQuery('.expired-date').datetimepicker({
		format:'Y/m/d',
		onShow:function( ct ){
		this.setOptions({
		minDate:jQuery('.start-date').val()?jQuery('.start-date').val():false
		})
		},
		timepicker:false
	});
});
</script>
-->
@endsection