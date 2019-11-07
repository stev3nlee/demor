<?php include '../../../header.php'; ?>

<script>
$(function() {
	$(document).ready(function() {	
		$('#store > ul.submenu').addClass ('open');
		$('li#store').addClass ('open');
		$('#category').addClass ('active');
	});
});
</script>
		
	<div class="clearfix">
	
		<?php include '../../../menu.php'; ?>
		
		<div class="box-right">
			<div class="content">
				<div class="breadcrumb">
					<a>Commerce</a><span class="m10"> > </span><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/store/category/index.php"/>Category</a><span class="m10"> > </span><a class="active">View Category</a>
				</div>
				<div class="clearfix">
					<div class="pull-left">
						<div class="title">View Category : Tops</div>
					</div>
					<div class="pull-right">
						<a class="click-box2"><button type="button" class="btn btn-auto">Add</button></a>
					</div>						
				</div>
				<div class="adminTable">
					<table id="table_id">
						<thead>
							<tr>
								<td width="100">No</td>
								<td width="200">Product Name</td>
								<td width="200">Image</td>
								<td>Description</td>
								<td width="200">View Detail</td>
								<td width="200">
									<div class="text-center">Action</div>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Cotton Sweater Dress</td>
								<td><a class="fancybox link" href="#popProduct">View Image</a></td>
								<td><a class="fancybox link" href="#pop-description">View Description</a></td>
								<td><a class="fancybox link" href="#pop-detail">View Detail</a></td>
								<td class="text-center">
									<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/store/product/edit.php">
										<div class="img-edit"></div>
									</a>
									<a class="fancybox" href="#delete"><div class="img-delete"></div></a>
								</td>
							</tr>
						</tbody>
						<tfoot></tfoot>
					</table>
				</div>
				<div style="margin-top: 20px;">
					<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/store/category/index.php"><button type="button" class="btn btn-pop">Back</button></a>
				</div>
			</div>
		</div>
	</div>

<!-- ADD -->
<div class="open-box2">
	<div class="in-box">
		<div class="close-box"></div>
		<div class="mt30">
			<form>
				<div class="form-group">
					<label>Menu Name :</label>
					<input type="text" class="form-control" name="menu_name">
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
			<form>
				<div class="form-group">
					<label>Menu Name :</label>
					<input type="text" class="form-control" name="category_name" value="Brand">
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn150">Edit</button>
				</div>
			</form>
		</div>		
	</div>		
</div>

<!-- Delete -->
<div id="delete" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">DELETE</div>
		<div class="img-pop">
			<div class="pop-delete"></div>
		</div>
		<div class="text-center">
			<div class="inline">
				<button class="btn btn-sure">Yes</button>
			</div>
			<div class="inline">
				<button class="btn btn-cancel">No</button>
			</div>
		</div>
	</div>
</div>

<?php include '../../../footer.php'; ?>