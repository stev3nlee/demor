@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#payment').addClass ('active');
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
		<div class="title">View Credit Card</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="60">No</td>
						<td>Name</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Veritrans VT-Web</td>
					</tr>
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div style="margin-top: 10px;">
			<a href="{{ url('meisjejongetje/commerce/payment') }}"><button type="button" class="btn btn-pop">Back</button></a>
		</div>
	</div>
@endsection