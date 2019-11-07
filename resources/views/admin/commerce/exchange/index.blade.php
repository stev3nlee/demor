@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#exchange').addClass ('active');

		$( ".viewClick" ).click(function() {
			$("#viewPop").html($(this).attr('data-value'));
		});
		$( ".replyClick" ).click(function() {
			$("#exchangeId").val($(this).attr('data-value'));
			$("#exchangeEmail").val($(this).attr('data-email'));
		});
		$( ".deleteClick" ).click(function() {
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
		<div class="title">Exchange</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="20">No</td>
						<td width="100">Full Name</td>
						<td width="100">Email Address</td>
						<td width="150">Order No</td>
						<td width="250">Product Name</td>
						<td>Details of Products (Size, Colour, Qty)</td>
						<td width="150">Date</td>
						<td width="100" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($exchages as $exchange)
					 <tr>
						<td>{{$x}}</td>
						<td>{{$exchange->fullname}}</td>
						<td>{{$exchange->email}}</td>
						<td>{{$exchange->ordernumber}}</td>
						<td>{{$exchange->productname}}</td>
						<td>{{$exchange->detailproduct}}</td>
						<td>{{$exchange->exchangedate}}</td>
						<td class="text-center">
							<a class="fancybox replyClick" href="#replyPop" data-value="{{$exchange->exchangeid}}" data-email="{{$exchange->email}}">
								<div class="img-exchange"></div>
							</a>
							<a class="fancybox viewClick" href="#reasonpop" data-value="{{$exchange->reason}}">
								<div class="img-view"></div>
							</a>
							<a class="fancybox deleteClick" href="#deleteGallery" data-value="{{$exchange->exchangeid}}">
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

<!-- DELETE -->
<div id="deleteGallery" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">DELETE</div>
		<div class="img-pop">
			<div class="pop-delete"></div>
		</div>
		 <div class="text-center">
			<form action="{{ url('meisjejongetje/commerce/exchange/delete') }}" method="post">
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

<!-- DELETE -->
<div id="reasonpop" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">Reason why you exchange</div>
		<div class="text" style="line-height: 25px;" id="viewPop"></div>
	</div>
</div>

<!-- REPLAY -->
<div id="replyPop" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">Reply Email</div>
		<form action="{{ url('meisjejongetje/commerce/exchange/submitreply') }}" method="post">
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Order No :</label>
					</div>
					<div class="cell">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="exchangeId" id="exchangeId"/>
						<input type="hidden" name="exchangeEmail" id="exchangeEmail"/>
						<input class="form-control" required type="text" name="orderNo"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Product Name :</label>
					</div>
					<div class="cell">
						<input class="form-control" required name="productName"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Size :</label>
					</div>
					<div class="cell">
						<input class="form-control" required name="size"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Colour :</label>
					</div>
					<div class="cell">
						<input class="form-control" required name="colour"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Quantity :</label>
					</div>
					<div class="cell">
						<input class="form-control" required name="quantity"/>
					</div>
				</div>
			</div>
			<div class="text-center">
				<button type="submit" class="btn" style="width: 150px;" type="button">Send</button>
			</div>
		</form>
	</div>
</div>

@endsection
