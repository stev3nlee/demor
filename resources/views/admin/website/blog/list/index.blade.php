@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#blog > ul.submenu').addClass ('open');
		$('li#blog').addClass ('open');
		$('#blog-list').addClass ('active');
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
				<div class="title">List</div>
			</div>
			<div class="pull-right">
				<a href="{{ url('meisjejongetje/pages/blog/addlist') }}"><button type="button" class="btn btn-auto">Add</button></a>
			</div>
		</div>

		<div class="adminTable">
			<table id="table_id2">
				<thead>
					<tr>
						<td style="display:none;"></td>
						<td width="60">No</td>
						<td width="400">Name</td>
						<td>Category</td>
						<td width="200">
							<div class="text-center">Action</div>
						</td>
					</tr>
				</thead>
				<tbody>
					@foreach($lists as $index => $list)
					<tr>
						<td style="display:none;">{{ $list->blogid }}</td>
						<td>{{ $index+1 }}</td>
						<td>{{ $list->name }}</td>
						<td>{{ $list->categoryname }}</td>
						<td class="text-center">
							<a href="{{ url('meisjejongetje/pages/blog/editlist/'.$list->blogid) }}">
								<div class="img-edit"></div>
							</a>
							<a class="fancybox del" href="#delete" ><div class="img-delete"></div></a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<!-- Delete -->
	<div id="delete" class="full-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			<div class="text-center">
				<div class="inline">
					<form method="post" action="{{url('meisjejongetje/pages/blog/deletelist/submit')}}">
						{{csrf_field()}}
						<input type="hidden" name="deleteId" id="deleteId" value="">
						<button class="btn btn-sure">Yes</button>
					</form>
				</div>
				<div class="inline">
					<button class="btn btn-cancel">No</button>
				</div>
			</div>
		</div>
	</div>
<script>
	$('.del').click(function(){
		id=$(this).closest('tr').find('td:eq(0)').html();
		$('#deleteId').val(id);
	})
	$('#table_id2').DataTable( {
			"order": [[ 1, "asc" ]]
	});
</script>
@endsection
