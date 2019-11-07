@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#payment').addClass ('active');
		
		$( ".showClick" ).click(function() {
			$("[name=showId]").val($(this).attr('data-value'));
			$("[name=ispublish]").val(1);
			$("#titleView").html('Do you want to show?');
		});
		$( ".hideClick" ).click(function() {
			$("[name=showId]").val($(this).attr('data-value'));
			$("[name=ispublish]").val(0);
			$("#titleView").html('Do you want to hide?');
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
		<div class="title">Payment</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="60">No</td>
						<td>Name</td>
						<td width="100" class="text-center">Publish</td>
						<td width="200" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($payments as $index => $payment)
					<tr>
						<td>{{ $index+1 }}</td>
						<td>{{ $payment->paymentname }}</td>
						<td>
							<div class="img-auto">
								<div class="@if($payment->ispublish == 1) icon-correct @else icon-incorrect @endif"></div>
							</div>
						</td>
						<td class="text-center">
							<a href="{{ url('meisjejongetje/commerce/payment/'.$payment->paymentview) }}">
								<div class="img-view"></div>
							</a>
							@if($payment->ispublish == 1)
								<a class="fancybox p-hide hideClick" href="#View" style="position: relative; top: -4px;" data-value="{{ $payment->paymentid }}">Hide</a>
							@else 
								<a class="fancybox p-hide showClick" href="#View" style="position: relative; top: -4px;" data-value="{{ $payment->paymentid }}">Show</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<!-- VIEW -->
	<div id="View" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop" id="titleView"></div>
			 <div class="text-center">
				<form action="{{ url('meisjejongetje/commerce/payment/savepublish') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" required name="ispublish" value=""/>
					<input type="hidden" required name="showId" id="showId"/>
					<div class="inline">
						<button type="submit" class="btn btn-sure btn-show">Yes</button>
					</div>
					<div class="inline">
						<button class="btn btn-cancel no-popup" type="button">No</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection