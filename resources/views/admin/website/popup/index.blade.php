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
		<div class="title">Pop Up</div>
		<form action="{{ url('meisjejongetje/pages/popup/submitpopup') }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div id="myRadioGroup" class="clearfix">
				<div style="float: left; width:50%;">
					<div class="mb15">
						<input type="radio" name="select_method" value="1" @if($popup->popup_type == 1) checked @endif style="position: relative; top: 1px;" /> Popup in text<span style="margin-left: 5px;">
					</div>
					<div id="method1" class="desc">
						<!-- START POP UP FOR TEXT -->
						<div id="method1" class="desc">
							<div class="display-inline mr20 mt10">
								<div class="form-group">
									<label>Message<span class="red">*</span></label>
									<div class="form-group">
										<textarea id="mceFixed" name="message" required>{{ $popup->message }}</textarea>
									</div>
								</div>
							</div>
						</div>
						<!-- END POP UP FOR TEXT -->
						<div class="form-group">
							<label>Start Popup <span class="red">*</span></label><br>
							<input type="text" class="form-control start-date inputDate" name="start_popup" value="{{ date("d/m/Y",strtotime($popup->start_popup)) }}">
						</div>
						<div class="form-group">
							<label>End Popup <span class="red">*</span></label><br>
							<input type="text" class="form-control start-date inputDate" name="end_popup" value="{{ date("d/m/Y",strtotime($popup->end_popup)) }}">
						</div>
						<div class="form-group">
							<label>Is Active ? &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="is_active" value="1" @if($popup->is_active == 1) checked @endif></label>					
						</div>
					</div>
				</div>
				<div style="float: left; margin-left: 30px;">
					<div class="mb15">
						<input type="radio" name="select_method" value="2" @if($popup->popup_type == 2) checked @endif style="position: relative; top: 1px;" /> Popup in image<span style="margin-left: 5px;">Product</span>
					</div>
					<!-- START POP UP FOR BANNER IMAGE -->
					<div id="method2" class="desc">
						<div class="display-inline mr20 mt10">
							<div class="form-group">
								<label>Url<span class="red">*</span></label><br>
								<input type="text" class="form-control" name="url_path" value="{{ $popup->link_path }}">
							</div>
							<div class="form-group">
								<img src="{{ url($popup->image_path) }}" height="160" width="240"/><br>
								<label>Banner Image<span class="red">*</span></label>
								<input type="file" name="image">
								<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
								<div>Pic Resolution : 670 x 350 pixels</div>
								<div>Maximum File Size : 1MB</div>
							</div>
						</div>
					</div>
					<!-- END POP UP FOR BANNER IMAGE -->
				</div>
			</div>

			<div style="margin-top: 20px; clear: both;">
				<button type="submit" class="btn btn-auto">UPDATE</button>
			</div>
		</form>

@endsection
