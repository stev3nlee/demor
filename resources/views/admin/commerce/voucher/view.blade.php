@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#voucher').addClass ('active');
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
		<div class="title">View Member</div>						
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td>No</td>
						<td>Member Name</td>
						<td>Date</td>
						<td>Initial Price</td>
						<td>Discount</td>
						<td>Final Price</td>
					</tr>
				</thead>
				<tbody>
					@foreach($members as $index => $member)
						<tr>
							<td>{{ $index + 1 }}</td>
							<td>{{ $member->membername }}</td>
							<td>{{ $member->insertdate }}</td>
							<td>{{ $member->subtotal }}</td>
							<td>{{ $member->vouchernominal }}</td>
							<td>{{ $member->total }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div style="margin-top: 10px;">
			<a href="{{ url('meisjejongetje/commerce/voucher') }}"><button type="button" class="btn btn-pop">Back</button></a>
		</div>
	</div>

@endsection