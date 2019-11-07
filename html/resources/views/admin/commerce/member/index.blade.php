@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
		$(function() {
			$('li#member').addClass ('active');

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
				<div class="title">Member</div>
			</div>
			<div class="pull-right">
			</div>
		</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="20">No</td>
						<td width="150">Full Name</td>
						<td width="200">Email Address</td>
						<td width="100">Gender</td>
						<td width="100">Contact Phone</td>
						<td width="100" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach ($users as $user)
						<tr>
							<td>{{$x}}</td>
							<td>{{ $user->firstname }} {{ $user->lastname }}</td>
							<td>{{ $user->emailaddress }}</td>
							<td>{{ $user->gender }}</td>
							<td width="100">{{ $user->mobilenumber }}</td>
							<td class="text-center">
								<a href="{{ url('meisjejongetje/commerce/member/view/'. $user->userid) }}">
									<div class="img-view"></div>
								</a>
								<a class="fancybox deleteUserClick" href="#deleteUser" data-value="{{$user->userid}}">
									<div class="img-delete"></div>
								</a>
							</td>
						</tr>
						<?php $x++; ?>
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
				<form action="{{ url('meisjejongetje/commerce/member/delete') }}" method="post">
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
