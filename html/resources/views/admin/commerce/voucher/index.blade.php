@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#voucher').addClass ('active');

		$( ".deleteUserClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
	});
	</script>

	<style>
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }
	</style>

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
				<div class="title">Voucher</div>
			</div>
			<div class="pull-right">
				<a href="{{ url('/meisjejongetje/commerce/voucher/add') }}"><button type="button" class="btn btn-auto">Add</button></a>
			</div>
		</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr class="no-sort">
						<td>No</td>
						<td>Discount Name</td>
						<td>Discount Type</td>
						<td>Limit</td>
						<td>Date Created</td>
						<td>Used Date</td>
						<td>Until Date</td>
						<td>Total Used</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($vouchers as $voucher)
					<tr>
						<td>{{$x}}</td>
						<td>{{ $voucher->vouchername }}</td>
						<td>IDR {{ $voucher->discount }}</td>
						<td>{{ $voucher->timescanused }}</td>
						<td>{{ $voucher->insertdate }}</td>
						<td>{{ $voucher->discountbegin }}</td>
						<td>{{ $voucher->discountend }}</td>
						<td>
							@if ($voucher->used == 0)
								{{ $voucher->used }} transactions
							@else
							<a href="{{ url('meisjejongetje/commerce/voucher/view/'.$voucher->voucherid) }}" class="link">{{ $voucher->used }} transactions</a>
							@endif
						</td>
						<td class="text-center">
							<!--<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/voucher/edit.php">
								<div class="img-edit"></div>
							</a>-->
							@if($voucher->isdeleted == 0)
							<a class="fancybox deleteUserClick" href="#deleteUser" data-value="{{$voucher->voucherid}}">
								<div class="img-expired"></div>
							</a>
							@endif
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
				<form action="{{url('meisjejongetje/commerce/voucher/delete')}}" method="post">
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
