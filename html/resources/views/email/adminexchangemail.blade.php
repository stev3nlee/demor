
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
    <div style="padding: 0 50px; margin-bottom: 15px;">
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">FULL NAME</div>
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">{{$data['name']}}</div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">{{$data['orderId']}}</div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PRODUCT NAME</div>
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">{{$data['productName']}}</div>
		</div>
	</div>
	<div style="padding: 0 50px; margin-bottom: 5px;">
		<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">DETAILS OF PRODUCTS (SIZE, COLOR, QTY)</div>
	</div>
	<div style=" padding: 0 50px; margin-bottom:15px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242;text-align: justify; line-height: 25px;">{{$data['productDetail']}}</div>
	<div style="padding: 0 50px; margin-bottom: 5px;">
		<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">REASON WHY CUSTOMER EXCHANGE</div>
	</div>
	<div style=" padding: 0 50px 30px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242;text-align: justify; line-height: 25px;">{{$data['reason']}}</div>
	@include('email/footer')
</div>
