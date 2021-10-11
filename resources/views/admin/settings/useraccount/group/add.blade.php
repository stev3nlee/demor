@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$(document).ready(function() {	
			$('#role > ul.submenu').addClass ('open');
			$('li#role').addClass ('open');
			$('#group').addClass ('active');
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
		<div class="title">{{$title}} Group</div>
		<form action="{{ url('/meisjejongetje/settings/useraccount/submitrole') }}" method="post">
			<div class="form-group">
				<label>Role Name <span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" class="form-control" name="roleId" value="{{ $role->roleid }}" />
				<input type="text" class="form-control" name="roleName" value="{{ $role->rolename }}" />
			</div>
			<div class="table-role">
				<table>
					<thead>
						<tr>
							<td>Menu</td>
							<td width="250" class="text-center">View</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Dashboard</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="0" class="check-view" @if($menu[0] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Slider</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="1" class="check-view" @if($menu[1] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Newsletter</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="2" class="check-view" @if($menu[2] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Pages</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="3" class="check-view" @if($menu[3] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>World of De'mor > Category</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="4" class="check-view" @if($menu[4] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>World of De'mor > List</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="5" class="check-view" @if($menu[5] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Contact</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="6" class="check-view" @if($menu[6] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Career</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="7" class="check-view" @if($menu[7] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Pop Up</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="24" class="check-view" @if($menu[24] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Currency</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="25" class="check-view" @if($menu[25] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Footer</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="8" class="check-view" @if($menu[8] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Order</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="9" class="check-view" @if($menu[9] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Member</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="10" class="check-view" @if($menu[10] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Store > Category</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="11" class="check-view" @if($menu[11] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Store > Product</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="12" class="check-view" @if($menu[12] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Payment</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="13" class="check-view" @if($menu[13] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Shipping</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="14" class="check-view" @if($menu[14] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Voucher</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="15" class="check-view" @if($menu[15] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Exchange</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="16" class="check-view" @if($menu[16] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Others</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="17" class="check-view" @if($menu[17] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>General</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="18" class="check-view" @if($menu[18] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Social Media</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="19" class="check-view" @if($menu[19] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Tools</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="20" class="check-view" @if($menu[20] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>User Account > Group</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="21" class="check-view" @if($menu[21] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>User Account > Account</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="22" class="check-view" @if($menu[22] == 1) checked @endif></td>
						</tr>
						<tr>
							<td>Change Password</td>
							<td class="text-center"><input type="checkbox" name="roleMenu[]" value="23" class="check-view" @if($menu[23] == 1) checked @endif></td>
						</tr>
					</tbody>
					<tfoot></tfoot>
				</table>
				<div class="text-center" style="margin-top: 10px;">
					<a href="{{ url('/meisjejongetje/settings/useraccount/role') }}"><button type="button" class="btn btn-pop">Back</button></a>
					<button type="submit" class="btn btn-pop">Submit</button>
				</div>
			</div>
		</form>
	</div>
@endsection