<div style="width: 500px; background: white; border: 1px solid #acacac; margin: 0 auto;">
    <div style="margin: 25px auto;text-align: center; padding-bottom: 25px; border-bottom: 1px solid #b69bbc;">
        <a href="http://beta.demorboutique.com/" target="_blank">
			<img src="http://beta.demorboutique.com/assets/images/uploads/test.png" style="width:180px;"/>
		</a>
    </div>
    <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-weight: bold; font-size: 20px; color: #424242;text-align: center; line-height: 25px;">Someone has confirmed the payment.</div>
    <div style="margin: 30px auto;text-align: center;">
        <img src="http://beta.demorboutique.com/assets/images/icons/email-contact.svg"/>
    </div>
	<div style="padding: 0 50px; margin-bottom: 15px;">
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">FULL NAME</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['orderheader'][0]['membername'] ?></div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['orderheader'][0]['orderno'] ?></div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ACCOUNT NO.</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['orderheader'][0]['accountno'] ?></div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ACCOUNT NAME</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['orderheader'][0]['accountname'] ?></div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT TO</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['paymentto'][0]['bankname'].' - '.$data['paymentto'][0]['accountnumber'].' - '.$data['paymentto'][0]['accountname'] ?></div>
		</div>
		<div style="margin-bottom: 15px;">
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">TOTAL AMOUNT</div>			
			<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">IDR <?php echo $data['orderheader'][0]['totalamount'] ?></div>
		</div>
	</div>
    <div style="background: white; padding: 30px 40px; border-top: 1px solid #b69bbc;">
        <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242;text-align: center; line-height: 25px;">Follow Us</div>
        <div style="margin: 10px 0 30px; text-align: center; ">
            <div style="display:inline-block;">
                <a href="http://www.facebook.com" target="_blank">
                    <img src="http://beta.demorboutique.com/assets/images/icons/fb.svg" style="width: 30px;"/>
                </a>
            </div>
            <div style="display:inline-block; margin: 0 10px">
                <a href="http://www.instagram.com" target="_blank">
                    <img src="http://beta.demorboutique.com/assets/images/icons/ig.svg" style="width: 30px;"/>
                </a>
            </div>
			<div style="display:inline-block;">
                <a href="https://www.pinterest.com/" target="_blank">
                    <img src="http://beta.demorboutique.com/assets/images/icons/pt.svg" style="width: 30px;"/>
                </a>
            </div>
        </div>
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/about" target="_blank">About</a>
            </div>
            <div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/shippingexchange" target="_blank">Shipping & Return</a>
            </div>
            <div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/termcondition" target="_blank">Terms & Conditions</a>
            </div>
            <div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/working" target="_blank">Working with De'mor</a>
            </div>
			 <div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/contact" target="_blank">Contact</a>
            </div>
			<div style="display:inline-block; margin: 0 20px 5px 0;">
                <a style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px; text-decoration: none;" href="http://beta.demorboutique.com/pages/privacypolicy" target="_blank">Privacy Policy</a>
            </div>
        </div>
       <div style="text-align: center; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">COPYRIGHT &copy; 2016 DE'MOR BOUTIQUE.
        </div>
    </div>
</div>