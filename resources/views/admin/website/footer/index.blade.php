@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#footer').addClass ('active');
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
		<div class="title">Footer</div>
		<form action="{{ url('meisjejongetje/pages/footer/submitfooter') }}" method="post">
			<div class="clearfix row">
				<div class="wdth50">
					<!--<div class="form-group">
						<label>Payment Methods <span class="red">*</span></label>						
						<input type="hidden" name="type" value="0">
						<textarea id="mceEdit" name="paymentMethod">{{$detailFooter->payment}}</textarea>
					</div>-->
					<div class="form-group">
						<label>Copyright <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" required value="{{$detailFooter->copyright}}" class="form-control" name="copyright"/>
					</div>	
				</div>
			</div>											
			<div>
				<input type="submit" class="btn btn-pop" value="Submit">
			</div>
		</form>
	</div>

@endsection