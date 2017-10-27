<?php
   
    session_start(); 

    $pageTitle = 'Create New Item';

 	include 'init.php';

 	if ($_SESSION['user']) {


		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$formErrors = array();

			$title 		= ltrim(rtrim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)));
			$desc 		= ltrim(rtrim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)));
			$price 		= ltrim(rtrim(filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT)));
			$country 	= ltrim(rtrim(filter_var($_POST['country'], FILTER_SANITIZE_STRING)));
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

			if (strlen($title) < 3) {
				$formErrors[] = 'Item Title must be at least 3 characters';
			} 

			if (strlen($desc) < 10) {
				$formErrors[] = 'Description must be at least 20 characters';
			}

			if (strlen($country) < 2) {
				$formErrors[] = 'Country name must be at least 2 characters';	
			}

			if(!is_numeric($price) || $price < 0) {
				$formErrors[] = 'Item price must be a valid price';
			}

			if (empty($status)) {
				$formErrors[] = 'Item status must be not empty';
			}

			if (empty($category)) {
				$formErrors[] = 'Item category must be not empty';
			}

			// Check if there's no error, proceed the update operation
			if (empty($formErrors)) { 
				
				// Insert userinfo in database
				$stmt = $db->prepare('INSERT INTO items (Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, Member_ID) 
									  VALUES (:title, :description, :price, CURDATE(), :country, :status, :cat_id, :user_id)');
				$stmt->execute(array(
					'title' 		=> $title, 
					'description'   => $desc,
					'price'    		=> '$' . $price, 
					'country' 		=> $country,
					'status' 		=> $status,
					'cat_id'		=> $category,
					'user_id'       => $_SESSION['uid']
				));

				// Echo Success Message
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added</div>';
				redirectHome($theMsg, 'profile');	
				
			}
			
		}
?>
     
<h1 class="text-center"><?php echo $pageTitle ?></h1>

<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo $pageTitle ?></div>
			<div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" class="form-control live" required="required" 
	            				placeholder="Name of the item" data-class=".live-title">
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Desciption Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Description</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" class="form-control live" required="required" 
	            				placeholder="Description of the item" data-class=".live-desc">
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Price Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Price</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="price" class="form-control live" required="required" 
	            				placeholder="Price of the item" data-class=".live-price">
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
						    <span class="price-tag live-price">$0</span>
						    <img class="img-responive" src="image.jpeg" alt="iamge">
						    <div class="caption">
							    <h3 class="live-title">Title</h3>
							    <p class="live-desc">Description</p>
						    </div>
					   </div>
                    </div>
				</div>
				<!-- Start Looping Through Errors -->
				<?php
					if (!empty($formErrors)) {
						foreach($formErrors as $error) {
							echo '<div class="alert alert-danger">' . $error . '</div>';
						}
					}
				?>
				<!-- End Looping Through Errors -->
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