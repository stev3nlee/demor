<?php include '../../header.php'; ?>

<script>
$(function() {
	$('li#voucher').addClass ('active');
});
</script>
		
	<div class="clearfix">
	
		<?php include '../../menu.php'; ?>
		
		<div class="box-right">
			<div class="content">
				<div class="breadcrumb">
					<a>Commerce</a><span class="m10"> > </span><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/voucher/index.php"/>Voucher</a><span class="m10"> > </span><a class="active">Edit Voucher</a>
				</div>
				<div class="title">Edit Voucher</div>
				<form>
					<div class="clearfix row">
						<div class="wdth50">
							<h3>Voucher Details</h3>
							<div class="form-group">
								<label>Voucher name <span class="red">*</span></label>
								<input type="text" class="form-control" name="voucher_name" value="DEMORSALE">
							</div>
							<div class="clearfix mb30">
								<div class="display-inline mr10 pos-det">How many times can this discount be used?</div>
								<div class="display-inline mr10">
									<input type="text" required class="form-control txtboxToFilter" maxlength="3" name="vat" style="width: 50px;"/>
								</div>
								<div class="display-inline pos-det"><input type="checkbox" checked="" name="discount_unlimited" value="true"> No Limit</div>
							</div>
							<h3 class="mb20">Voucher Type</h3>
							<div class="clearfix mb30">
								<div class="display-inline mr10 pos-det">IDR</div>
								<div class="display-inline mr10">
									<input type="text" class="form-control txtboxToFilter" name="price" style="width: 100px;"/>
								</div>
								<div class="display-inline pos-det mr10">For</div>
								<div class="display-inline">
									<select name="category" class="form-control auto">
										<option value="0">All</option>
										<option value="1">Tops</option>												
										<option value="2">Dresses</option>												
										<option value="3">Bottoms</option>												
									</select>
								</div>
							</div>
						</div>
						<div class="wdth50">
							<h3>Date Range</h3>
							<p style="margin-bottom: 10px;">Specify when this discount begins and ends. </p>
							<div class="form-group">
							<label>Discount Begins <span class="red">*</span></label>
								<input type="text" class="form-control start-date">
							</div>
							<div class="form-group">
								<label>Discount Ends <span class="red">*</span></label>
								<input type="text" class="form-control expired-date">
							</div>
							<div class="form-group">
								<input type="checkbox" name="discount_forever" value="true"> Never Expired <p></p>
								<input type="hidden" class="form-control" name="update" value="28">
							</div>
						</div>
					</div>
					<div>
						<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/voucher/index.php"><button type="button" class="btn btn-pop mr10">Back</button></a>
						<input type="submit" class="btn btn-pop" value="Submit">
					</div>
				</form>
			</div>
		</div>
	</div>

<?php include '../../footer.php'; ?>