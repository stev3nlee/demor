@extends('adminlayouts.adminmaster')

@section('content')

@section('title', 'Page Title')

	<script>
	$(function() {
		$('li#tools').addClass ('active');
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
		<div class="clearfix">
			<div class="pull-left">
				<div class="title">Tools</div>
			</div>
		</div>
		<form method="post" action="{{ url('meisjejongetje/settings/submitheader') }}">
			<div class="form-group">
				<label>Google Webmaster Tool <span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="type" value="1">
				<input type="text" class="form-control" name="googleWebMaster" value="{{$header->googlewebmaster}}" required />
			</div>
			<div class="form-group">
				<label>Google Analytic <span class="red">*</span></label>
				<textarea type="text" class="form-control" name="googleAnalytic" required >{!!$header->googleanalytic!!}</textarea>
			</div>
			<div>
				<button type="submit" class="btn btn-pop">Save</button>
			</div>
		</form>
	</div>
@endsection
