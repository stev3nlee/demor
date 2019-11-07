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
	<div style=" padding: 0 50px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">
        <div style="margin-bottom: 15px;">Dear Customer,</div>
		<div style="margin-bottom: 15px;">We have received your request. Please refer to the "Exchange Terms and Conditions page" in our website, please be sure that the item is in good condition with the tag on it, no perfume, must be unworn and unwashed.</div>
        <div style="margin-bottom: 15px;">These are the following details of your order: </div>
    </div>
	<div style="padding: 0 50px;">
		<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['reply']->orderNo }}</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PRODUCT NAME</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['reply']->productName }}</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SIZE</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['reply']->size }}</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">COLOR</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['reply']->colour }}</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">QUANTITY</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['reply']->quantity }}</div>
			</div>
		</div>
	</div>
    <div style=" padding: 0 50px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">
		<div style="border-top: 1px solid #b69bbc; padding-top: 10px; margin: 30px 0;">
			<div style="margin-top:15px;">We will do a quality check of your item(s) after we get it. Please send the item within 14 days since you get the item to our office address:</div>
			<div style="margin-top:15px;font-size:14px;">Thamrin Residence Apartment </div>
			<div style="font-size:14px;">Tower B unit 32 BB</div>
			<div style="font-size:14px;">Jalan Teluk Betung, Jakarta 10350</div>
			<div style="font-size:14px;">Indonesia</div>
			<div style="font-size:14px;">Attention to: Dewi Starink (De'mor)</div>
		</div>
		
		<div style="margin-top:15px;">We will do our best for our customer.</div>
    </div>
	@include('email/footer')
</div>
