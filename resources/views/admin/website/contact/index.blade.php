@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#contact').addClass ('active');

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
		<div class="content">
			<form method="post" action="{{ url('meisjejongetje/pages/contact/submitcontact') }}">
				<div class="title">Contact Information</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Hours of Operation</label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" class="form-control" name="hoursOfOperation" value="{{ $contact->operation }}"/>
						</div>
					</div>
					<div class="wdth50">
						<div class="form-group">
							<label>Whatsapp Number <span class="red">*</span></label>
							<input type="text" class="form-control" name="phoneNumber" value="{{ $contact->phonenumber }}"/>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Telephone Number <span class="red">*</span></label>
							<input type="text" class="form-control" name="mobileNumbser" value="{{ $contact->mobilenumber }}"/>
						</div>
					</div>
					<div class="wdth50">
						<div class="form-group">
							<label>Email <span class="red">*</span></label>
							<input type="text" class="form-control" name="email" value="{{ $contact->email }}" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Google Maps <span class="red">*</span></label>
					<input type="text" class="form-control" name="maps" value="{{ $contact->maps }}"/>
				</div>
				<div class="form-group">
					<label>Address</label>
					<textarea id="mceFixed" name="address">{{ $contact->address }}</textarea>
				</div>
				<input type="submit" class="btn btn-pop" value="Save">
			</form>
		</div>
		<div class="border-line"></div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="20">No</td>
						<td width="100">Subject</td>
						<td width="150">Name</td>
						<td width="200">Email</td>
						<td>Messages</td>
						<td width="70" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($messages as $message)
						 <tr>
							<td>{{ $x }}</td>
							<td>{{ $message->subject }}</td>
							<td>{{ $message->name }}</td>
							<td>{{ $message->email }}</td>
							<td>{!! $message->message !!}</td>
							<td class="text-center">
								<a class="fancybox deleteClick" href="#deleteGallery" data-value="{{$message->messageid}}">
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
				<form action="{{ url('/meisjejongetje/pages/deletemessage') }}" method="post">
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
