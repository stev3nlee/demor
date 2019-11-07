@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#general2').addClass ('active');
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
				<div class="title">Metadata</div>
			</div>					
		</div>
		<form method="post" action="{{ url('meisjejongetje/settings/submitheader') }}" enctype="multipart/form-data">
			<div class="form-group">
				<label>Title <span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="type" value="0">
				<input type="text" class="form-control" name="title" value="{{ $header->title }}" required />
			</div>
			<div class="form-group">
				<label>Meta Keyword <span class="red">*</span></label>
				<input type="text" class="form-control" name="keyword" value="{{ $header->metakeyword }}" required />
			</div>
			<div class="form-group">
				<label>Meta Description <span class="red">*</span></label>
				<input type="text" class="form-control" name="description" value="{{ $header->metadescription }}" required />
			</div>
			<div class="form-group">
				<label>Logo <span class="red">*</span></label>
				<div class="clearfix site_logo">
					<div class="box-logo pull-left mr10"><img src="{{ url($header->logo) }}"></div>
					<div class="pull-left"><input type="file" name="logo"></div>
				</div>
			</div>
			<div class="form-group">
				<label>Favicon <span class="red">*</span></label>
				<div class="clearfix site_logo">
					<div class="box-logo pull-left mr10"><img src="{{ url($header->favicon) }}"></div>
					<div class="pull-left"><input type="file" name="favicon"></div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn btn-pop">Save</button>						
			</div>
		</form>
	</div>

@endsection