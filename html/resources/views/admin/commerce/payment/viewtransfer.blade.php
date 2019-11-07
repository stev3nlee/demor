@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#payment').addClass ('active');
		
		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
		$( ".editClick" ).click(function() {
			$("[name=editTransferId]").val($(this).attr('data-value'));
			$("[name=editBank]").val($(this).attr('data-name'));
			$("[name=editAccount]").val($(this).attr('data-number'));
			$("[name=editAccountName]").val($(this).attr('data-numbername'));
			$("[name=editIsPublish]").prop('checked', $(this).attr('data-check') == 1);
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
				<div class="title">View Bank Transfer</div>
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
						<td width="200">Bank</td>
						<td>Account</td>
						<td>Account Name</td>
						<td width="60">Publish</td>
						<td width="200" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($banks as $index => $bank)
					<tr>
						<td>{{$index+1}}</td>
						<td>{{ $bank->bankname }}</td>
						<td>{{ $bank->accountnumber }}</td>
						<td>{{ $bank->bankaccountname }}</td>
						<td>
							<div class="img-auto">
								<div class="@if($bank->ispublish == 1) icon-correct @else icon-incorrect @endif"></div>
							</div>
						</td>
						<td class="text-center">
							<a class="click-box">
								<div class="img-edit editClick" data-value="{{$bank->transferid}}" data-name="{{$bank->bankname}}" data-number="{{$bank->accountnumber}}" 
										data-numbername="{{$bank->bankaccountname}}" data-check="{{$bank->ispublish}}"></div>
							</a>									
							<a class="fancybox deleteClick" href="#delete" data-value="{{$bank->transferid}}">
								<div class="img-delete"></div>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div style="margin-top: 10px;">
			<a href="{{ url('meisjejongetje/commerce/payment') }}""><button type="button" class="btn btn-pop">Back</button></a>
		</div>
	</div>			

	<!-- ADD -->
	<div class="open-box2">
		<div class="in-box">
			<div class="close-box"></div>
			<div class="mt30">
				<form action="{{ url('meisjejongetje/commerce/payment/addtransfer') }}" method="post">
					<div class="form-group">
						<label>Bank <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="bank">
					</div>
					<div class="form-group">
						<label>Account <span class="red">*</span></label>
						<input type="text" class="form-control" name="account">
					</div>
					<div class="form-group">
						<label>Account Name <span class="red">*</span></label>
						<input type="text" class="form-control" name="accountName">
					</div>
					<div class="form-group">
						<input type="checkbox" class="check" name="isPublish" value="true">
						<span class="publish-check">Publish</span>
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
				<form action="{{ url('meisjejongetje/commerce/payment/edittransfer') }}" method="post">
					<div class="form-group">
						<label>Bank <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" class="form-control" name="editTransferId">
						<input type="text" class="form-control" name="editBank" value="" required>
					</div>
					<div class="form-group">
						<label>Account <span class="red">*</span></label>
						<input type="text" class="form-control" name="editAccount" value="" required>
					</div>
					<div class="form-group">
						<label>Account Name <span class="red">*</span></label>
						<input type="text" class="form-control" name="editAccountName" required>
					</div>
					<div class="form-group">
						<input type="checkbox" class="check" name="editIsPublish" value="true">
						<span class="publish-check">Publish</span>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Edit</button>
					</div>
				</form>
			</div>
		</div>		
	</div>

	<!-- DELETE -->
	<div id="delete" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			 <div class="text-center">
				<form action="{{ url('meisjejongetje/commerce/payment/deletetransfer') }}" method="post">
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