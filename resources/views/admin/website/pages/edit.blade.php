@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#pages').addClass ('active');
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
		<div class="title">Edit Page: {{ $page[0]->pagesname }}</div>

		<form method="post" action="{{ url('/meisjejongetje/pages/submitpages') }}" enctype="multipart/form-data">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" class="form-control" name="pageId" value="{{ $page[0]->pagesid }}" />
				@if($page[0]->pagesid == 1)

					<label>Show Image? <input type="checkbox" style="margin-left:10px;" name="show_image" value="1" @if($page[0]->showimage == 1) checked @endif/></label> <br />
					<label>Image :</label>
					<br>
					<img src="{{url($page[0]->pagesimage)}}" height="325" width="720"/>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="file" name="uploadImage">
					<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
					<div>Pic Resolution : 1440 x 650 pixels</div>
					<div>Maximum File Size : 1MB</div>

					<div style="margin:10px 0;"></div>

					<label>Show Video? <input type="checkbox" style="margin-left:10px;" name="show_video" value="1" @if($page[0]->showvideo == 1) checked @endif /></label> <br />
					<label>Video :</label>
					<br>
					<input type="text" class="form-control" name="video" value="{{ $page[0]->pagesvideo }}" />
					</div>
				@endif
			</div>
			<div class="form-group">
				<textarea id="mceFixed" name="pageContent" required>{{ $page[0]->pagestext }}</textarea>
			</div>
			<div class="text-center">
				<a class="mr10" href="{{ url('/meisjejongetje/pages') }}"><button type="button" class="btn btn-pop">Back</button></a>
				<input type="submit" name="upload" class="btn btn-pop mr10" value="Submit"/>
			</div>
		</form>
	</div>

@endsection
