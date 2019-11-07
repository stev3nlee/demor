@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#role > ul.submenu').addClass ('open');
		$('li#role').addClass ('open');
		$('#account').addClass ('active');
		
		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
		$( ".editClick" ).click(function() {
			$("[name=editemail]").val($(this).attr('data-email'));
			$("[name=editfullname]").val($(this).attr('data-name'));
			$("[name=editrole]").val($(this).attr('data-role'));
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
				<div class="title">Account</div>
			</div>
			<div class="pull-right">
				<a class="click-box2"><button type="button" class="btn btn-auto">Add</button></a>
			</div>
		</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="60">No</td>
						<td>Email</td>
						<td width="200">Full Name</td>
						<td width="150">Role</td>
						<td width="150" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $index => $user)
						<tr>
							<td>{{$index+1}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->fullname}}</td>
							<td>{{$user->rolename}}</td>
							<td class="text-center">
								<a class="click-box">
									<div class="img-edit editClick" data-email="{{$user->email}}" data-name="{{$user->fullname}}" data-role="{{$user->roleid}}"></div>
								</a>									
								<a class="fancybox deleteClick" href="#deleteUser" data-value="{{$user->email}}">
									<div class="img-delete"></div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<!-- ADD -->
	<div class="open-box2">
		<div class="in-box">
			<div class="close-box"></div>
			<div class="mt30">
				<form action="addaccount" method="post">
					<div class="form-group">
						<label>Email <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="addemail" value="" required/>
					</div>
					<div class="form-group">
						<label>Full Name <span class="red">*</span></label>
						<input type="text" class="form-control" name="addfullname" value="" required/>
					</div>
					<div class="form-group">
						<label>Role <span class="red">*</span></label>
						<select class="custom-select form-control" name="addrole" required>
							@foreach($roles as $role)
								<option value="{{$role->roleid}}">{{ $role->rolename }}</option>
							@endforeach
						</select>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Add</button>
					</div>
				</form>
			</div>
		</div>		
	</div>

	<!-- EDIT -->
	<div class="open-box">
		<div class="in-box">
			<div class="close-box"></div>
			<div class="mt30">
				<form action="editaccount" method="post">
					<div class="form-group">
						<label>Email <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="editemail" value="" readonly required/>
					</div>
					<div class="form-group">
						<label>Full Name <span class="red">*</span></label>
						<input type="text" class="form-control" name="editfullname" value="" required/>
					</div>
					<div class="form-group">
						<label>Role <span class="red">*</span></label>
						<select class="custom-select form-control" name="editrole">
							@foreach($roles as $role)
								<option value="{{$role->roleid}}">{{ $role->rolename }}</option>
							@endforeach
						</select>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Edit</button>
					</div>
				</form>
			</div>
		</div>		
	</div>

	<!-- DELETE -->
	<div id="deleteUser" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			 <div class="text-center">
				<form action="deleteaccount" method="post">
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