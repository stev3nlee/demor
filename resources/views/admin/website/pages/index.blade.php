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
		<div class="title">Pages</div>								
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td>Page</td>
						<td width="150"><div class="text-center">Action</div></td>
					</tr>
				</thead>
				<tbody>
					@foreach($pages as $page)
						<tr>
							<td>{{ $page->pagesname }}</td>
							<td class="text-center">
								<a href="pages/editpages/{{ $page->pagesid }}" class="link">
									<div class="img-edit"></div>
								</a>
								<a href="pages/viewpages/{{ $page->pagesid }}" class="link">
									<div class="img-view"></div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>
@endsection