<div style="width: 500px; background: white; border: 1px solid #acacac; margin: 0 auto;">
    <div style="margin: 25px auto;text-align: center; padding-bottom: 25px; border-bottom: 1px solid #b69bbc;">
        <a href="{{ url('/') }}" target="_blank">
			<img src="{{ url('assets/images/icons/logo.png') }}" style="width:180px;"/>
		</a>
    </div>
    <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-weight: bold; font-size: 20px; color: #424242;text-align: center; line-height: 25px;">{!! $data['title'] !!}</div>
    <div style="margin: 30px auto;text-align: center;">
        <img src="{{ $data['image'] }}"/>
    </div>
	@if($data['body'] != '')
		<div style=" padding: 0 50px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">
		{!! $data['body'] !!}
		</div>
	@endif
	<div style="padding: 0 50px;">
		{!! $data['action'] !!}
	</div>
	@include('email/footer')
</div>