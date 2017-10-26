<?php
   
    session_start(); 

    $pageTitle = 'Create New Ad';

 	include 'init.php';

 	if ($_SESSION['user']) {
?>
     
<h1 class="text-center">Create New Ad</h1>

<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Create New Ad</div>
			<div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" class="form-control live-name" required="required" 
	            				placeholder="Name of the item">
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Desciption Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Description</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" class="form-control live-desc" required="required" 
	            				placeholder="Description of the item">
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Price Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Price</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="price" class="form-control live-price" required="required" 
	            				placeholder="Price of the item">
	            			</div>
	            		</div>
	            		<!-- End Price Field -->
	            		<!-- Start country of made Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Country</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="country" class="form-control" required="required" 
	            				placeholder="Country of made">
	            			</div>
	            		</div>
	            		<!-- End country of made Field -->
	            		<!-- Start Status Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Status</label>
	            			<div class="col-sm-10 col-md-6">
	            				<select name="status" class="form-control">
	            					<option value="0">Satus of the item</option>
	            					<option value="1">New</option>
	            					<option value="2">Like New</option>
	            					<option value="3">Used</option>
	            					<option value="4">Old</option>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Staus Field -->
	            		<!-- Start Category Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Category</label>
	            			<div class="col-sm-10 col-md-6">
	            				<select name="category" class="form-control">
	            					<option value="0">Select category</option>
	            					<?php
	            						$stmt2 = $db->prepare('SELECT * FROM categories');
	            						$stmt2->execute();
	            						$categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);
	            						foreach ($categories as $category) {
	            							echo '<option value="' . $category['ID'] . '">' . $category['Name'] . '</option>';
	            						}
	            					?>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Category Field -->
	            		<!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Add Item" class="btn btn-primary btn-lg pull-right ">
	            			</div>
	            		</div>
	            		<!-- End Save Button -->
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
						    <span class="price-tag">0</span>
						    <img class="img-responive" src="image.jpeg" alt="iamge">
						    <div class="caption">
							    <h3>Title</h3>
							    <p>Description</p>
						    </div>
					   </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>



<?php
 	
 	} else {
 		header('Location: login.php');
 		exit();
 	} 

	include $tpl . 'footer.php';

?>