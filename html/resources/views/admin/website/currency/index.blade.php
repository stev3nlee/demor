@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#popup').addClass ('active');
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
		<div class="title">Currency</div>
		<form action="{{ url('meisjejongetje/pages/currency/submitcurrency') }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="adminTable">
				<table id="table_id">
					<tr>
						<th>Country Currency</th>
						<th>Currency Code</th>
						<th>Active</th>
					</tr>
				@foreach ($currencies as $currency)
					<tr>
						<td>{{ $currency->country_currency }}</td>
						<td>{{ $currency->currency_code }}</td>
						<td><input type="checkbox" name="is_active[{{$currency->id}}]" value="1" @if($currency->is_active == 1) checked @endif /></td>
					</tr>
				@endforeach
				</table>
			</div>

			<div style="margin-top: 20px; clear: both;">
				<button type="submit" class="btn btn-auto">UPDATE</button>
			</div>
		</form>

@endsection
