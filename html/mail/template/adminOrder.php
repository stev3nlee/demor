<div style="width: 500px; background: white; border: 1px solid #acacac; margin: 0 auto;">
    <div style="margin: 25px auto;text-align: center; padding-bottom: 25px; border-bottom: 1px solid #b69bbc;">
        <a href="http://beta.demorboutique.com/" target="_blank">
			<img src="http://beta.demorboutique.com/assets/images/uploads/test.png" style="width:180px;"/>
		</a>
    </div>
    <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-weight: bold; font-size: 20px; color: #424242;text-align: center; line-height: 25px;">Someone has ordered</div>
    <div style="margin: 30px auto;text-align: center;">
		<img src="http://beta.demorboutique.com/assets/images/icons/email-order.svg"/>
	</div>
	<div style="padding: 0 50px;">
		<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;"><?php echo $data['orderheader'][0]['orderno'] ?></div>
			</div>
			<?php if($data['orderheader'][0]['status'] == 'Pending'){ ?>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">PENDING</div>
			</div>
			<div>
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">PENDING</div>
			</div>
			<?php } else if($data['orderheader'][0]['status'] == 'Waiting'){ ?>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">AWAITING FOR PAYMENT</div>
			</div>
			<div>
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">PENDING</div>
			</div>
			<?php } else if($data['orderheader'][0]['status'] == 'Paid'){ ?>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #22b600; line-height: 25px; font-weight: bold;">PAID</div>
			</div>
			<div>
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">ON PROCESS</div>
			</div>
			<?php } else if($data['orderheader'][0]['status'] == 'Ship'){ ?>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #22b600; line-height: 25px; font-weight: bold;">PAID</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #22b600; line-height: 25px; font-weight: bold;">SHIPPED</div>
			</div>
			<div>
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">TRACKING NO</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;"><?php echo $data['orderheader'][0]['trackingno'] ?></div>
			</div>
			<?php } ?>
		</div>
		<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
			<div style="margin-bottom: 20px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER DETAILS</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;"><?php echo $data['orderheader'][0]['membername'] ?></div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">Jessica</div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER TOTAL</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">IDR <?php echo $data['orderheader'][0]['subtotal'] - $data['orderheader'][0]['vouchernominal'] + $data['orderheader'][0]['shippingfee'] + $data['orderheader'][0]['tax'] ?></div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT METHOD</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;"><?php echo $data['orderheader'][0]['paymenttype'] ?></div>
			</div>
			<div style="margin-bottom: 15px;">
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold; vertical-align: top;">BILLING ADDRESS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">
					<div>Jl. Meruya Utara Raya blok 3</div>
					<div>Jakarta Barat, 11620</div>
					<div>DKI Jakarta, Indonesia</div>
				</div>
			</div>
			<div>
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold; vertical-align: top;">SHIPPING ADDRESS</div>			
				<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">
					<div>JL. Parang Tritis 1DJ</div>
					<div>Jakarta Barat, 20256</div>
					<div>DKI Jakarta, Indonesia</div>
				</div>
			</div>
		</div>
		<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
			<div style="margin-bottom: 20px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">YOUR SHOPPING BAG</div>
			<?php foreach($data['orderdetail'] as $orderdetail){ ?>
			<div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #c6c6c6;">
				<div style="display:inline-block; width: 80px; margin-right: 20px; vertical-align:top;">
					<img src="<?php echo $orderdetail['productimage'] ?>" style="width:80px;"/>
				</div>
				<div style="display:inline-block; width: 170px; margin-right: 10px; margin-top: -5px;">
					<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 15px; color: #424242; font-weight: bold; line-height: 25px; margin-bottom: 2px;"><?php echo $orderdetail['productname'] ?></div>
					<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; font-style: italic; line-height: 25px; margin-bottom: 5px;">IDR <?php echo $orderdetail['productprice'] ?></div>
					<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; margin-bottom: 5px;">
						<div style="display: inline-block; width: 60px; vertical-align: top;">Color</div>
						<div style="display: inline-block; width: 100px;">
							<img src="<?php echo $orderdetail['productcolor'] ?>" style="width: 12px; position: relative; top: 3px;"/>
						</div>
					</div>
					<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; margin-bottom: 5px;">
						<div style="display: inline-block; width: 60px;">Size</div>
						<div style="display: inline-block; width: 100px;"><?php echo $orderdetail['productsize'] ?></div>
					</div>
					<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575;">
						<div style="display: inline-block; width: 60px;">Qty</div>
						<div style="display: inline-block; width: 100px;"><?php echo $orderdetail['quantity'] ?></div>
					</div>
				</div>
				<div style="display:inline-block; width: 110px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right; font-weight: bold;">IDR <?php echo $orderdetail['productprice'] * $orderdetail['quantity'] ?></div>
			</div>
			<?php } ?>
		</div>
		<div style="margin-bottom: 30px;">
			<div style="margin-bottom: 5px; padding: 0 20px;">
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">SUBTOTAL</div>			
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR <?php echo $data['orderheader'][0]['subtotal'] - $data['orderheader'][0]['vouchernominal'] ?></div>
			</div>
			<div style="margin-bottom: 5px; padding: 0 20px;">
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">SHIPPING FEE</div>			
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR <?php echo $data['orderheader'][0]['shippingfee'] ?></div>
			</div>
			<div style="padding: 0 20px;">
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">TAX</div>			
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR <?php echo $data['orderheader'][0]['tax'] ?></div>
			</div>
		</div>
		<div style="margin-bottom: 30px; background: #424242;">
			<div style="padding: 15px 20px;">
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px;">TOTAL</div>			
				<div style="display:inline-block; width: 175px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px; text-align: right;">IDR <?php echo $data['orderheader'][0]['subtotal'] - $data['orderheader'][0]['vouchernominal'] + $data['orderheader'][0]['shippingfee'] + $data['orderheader'][0]['tax'] ?></div>
			</div>
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