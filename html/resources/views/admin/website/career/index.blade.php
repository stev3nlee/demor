@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#career').addClass ('active');
		
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
		<div class="title">Career</div>						
		<div class="content">
			<form method="post" action="{{ url('meisjejongetje/pages/career/postcareer') }}">
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Email <span class="red">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" class="form-control" name="email" value="{{ $career->email }}"/>
						</div>
						<div class="form-group">
							<label>Paragraph <span class="red">*</span></label>
							<textarea id="mceFixed" name="paragraph">{{ $career->careercontent }}</textarea>
						</div>
					</div>
				</div>
				<input type="submit" class="btn btn-pop" value="Save">
			</form>
		</div>
		<div class="border-line"></div>
		<div class="clearfix">
			<div class="pull-right">
				<a href="{{ url('meisjejongetje/pages/career/addcareer/') }}"><button type="button" class="btn btn-auto">Add</button></a>
			</div>						
		</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="50">No</td>
						<td>Job Name</td>
						<td width="250">Date</td>	
						<td width="150" class="text-center">Publish</td>
						<td width="150">
							<div class="text-center">Action</div>
						</td>
					</tr>
				</thead>
				<tbody>
					@foreach($jobs as $index => $job)
						<tr>
							<td>{{$index+1}}</td>
							<td>{{$job->careertitle}}</td>
							<td>{{$job->careerdate}}</td>
							<td>
								<div class="img-auto">
									@if($job->ispublish == 1)
										<div class="icon-correct"></div>
									@else
										<div class="icon-incorrect"></div>
									@endif
								</div>
							</td>
							<td class="text-center">									
								<a href="{{ url('meisjejongetje/pages/career/viewcareer/'.$job->careerid) }}">
									<div class="img-view"></div>
								</a>
								<a href="{{ url('meisjejongetje/pages/career/editcareer/'.$job->careerid) }}">
									<div class="img-edit"></div>
								</a>
								<a class="fancybox deleteClick" href="#deleteGallery" data-value="{{$job->careerid}}">
									<div class="img-delete"></div>
								</a>
							</td>
						</tr>
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
				<form action="{{ url('/meisjejongetje/pages/career/deletecareer') }}" method="post">
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