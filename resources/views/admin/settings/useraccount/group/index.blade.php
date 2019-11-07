@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#role > ul.submenu').addClass ('open');
		$('li#role').addClass ('open');
		$('#group').addClass ('active');
		
		$( ".deleteUserClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
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
		<div class="clearfix">
			<div class="pull-left">
				<div class="title">Group</div>
			</div>
			<div class="pull-right">
				<a class="click-box2" href="addrole"><button type="button" class="btn btn-auto">Add</button></a>
			</div>
		</div>
		<div class="table-role">
			<table>
				<thead>
					<tr>
						<td width="60">No</td>
						<td>Role Name</td>
						<td width="150" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($roles as $index => $role)
						<tr>
							<td>{{ $index+1	 }}</td>
							<td>{{ $role->rolename }}</td>
							<td class="text-center" style="height:35px;">
								@if($index != 0)
									<a href="editrole/{{$role->roleid}}">
										<div class="img-edit"></div>
									</a>
									<a class="fancybox deleteUserClick" href="#deleteUser" data-value="{{$role->roleid}}">
										<div class="img-delete"></div>
									</a>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<div id="deleteUser" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			 <div class="text-center">
				<form action="{{url('meisjejongetje/settings/useraccount/deleterole')}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" required name="deleteId" id="deleteId"/>
					<div class="inline">
						<button class="btn btn-sure">Yes</button>
					</div>
					<div class="inline">
						<button class="btn btn-cancel no-popup" type="button">No</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection