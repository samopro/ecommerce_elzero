<?php 
	/*
	  ========================================================================================
	  == Items Page
      ========================================================================================	
	*/

     session_start();
     $pageTitle = 'Items';

     if (isset($_SESSION['Username'])) {

     		include 'init.php';

     		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

     		if ($do == 'Manage') {

     			$stmt = $db->prepare('SELECT items.*, categories.Name AS Category, users.Username FROM items
     				                  INNER JOIN categories ON categories.ID = items.Cat_ID
     				                  INNER JOIN users ON users.UserID = items.Member_ID');
 				$stmt->execute();
 				$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			// echo '<pre>'; print_r($items); echo '</pre>'; 
 		?>
 			<h1 class="text-center">Manage Items </h1>
 			<div class="container">
 				<div class="table-responsive">
 					<table class="table text-center table-bordered table-striped table-responsive">
 						<thead>
	 						<tr>
	 							<th>#ID</th>
	 							<th>Name</th>
	 							<th>Descritption</th>
	 							<th>Price</th>
	 							<th>Made In</th>
	 							<th>Status</th>
	 							<th>Adding Date</th>
	 							<th>Member</th>
	 							<th>Category</th>
	 							<th>Control</th> 
	 						</tr>
 						</thead>
 				   <?php foreach ($items as $item) {
 				 	 		echo '<tr>';
 				 				echo '<td>' . $item['Item_ID'] . '</td>';
 				 	 			echo '<td>' . $item['Name'] . '</td>';
 				 	 			echo '<td>' . $item['Description'] . '</td>';
 				 	 			echo '<td>' . $item['Price'] . '</td>';
 				 	 			echo '<td>' . $item['Country_Made'] .'</td>';
 				 	 			echo '<td>' . $item['Status'] .'</td>';
 				 	 			echo '<td>' . $item['Add_Date'] .'</td>';
 				 	 			echo '<td>' . $item['Username'] .'</td>';
 				 	 			echo '<td>' . $item['Category'] .'</td>';
 				 	 			echo '<td>';
 				 	 				echo '<a href="?do=Edit&itemid='. $item['Item_ID'] . '" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>';
 				 	 				echo '<a href="?do=Delete&itemid='. $item['Item_ID'] . '" class="btn btn-danger btn-sm confirm"><i class="fa fa-trash-o"></i>Delete</a>';
 				 	 				if ($item['Approve'] == 0) {
 				 	 				echo '<a href="?do=Approve&itemid=' . $item['Item_ID'] . '" class="btn btn-info btn-sm"><i class="fa fa-check"></i>Approve</a>';
 				 	 			}
 				 	 			echo '</ td>';
 				 	 		echo '</tr>';
 					     }
 				    ?>
 					</table>
 				</div>
 				<a href=" ?do=Add" class="btn btn-primary "><i class="fa fa-plus"></i>&nbsp;New Item</a>
 			</div>

     		<?php 

     		} elseif ($do == 'Add') { 

     		?>
				
			<h1 class="text-center">Add Item</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Insert" method="POST">
	            		<!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" class="form-control" required="required" 
	            				placeholder="Name of the item">
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Desciption Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Description</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" class="form-control" required="required" 
	            				placeholder="Description of the item">
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Price Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Price</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="price" class="form-control" required="required" 
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
	            		<!-- Start Member Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Member</label>
	            			<div class="col-sm-10 col-md-6">
	            				<select name="user" class="form-control">
	            					<option value="0">Select member</option>
	            					<?php
	            						$stmt = $db->prepare('SELECT * FROM users');
	            						$stmt->execute();
	            						$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	            						foreach ($users as $user) {
	            							echo '<option value="' . $user['UserID'] . '">' . $user['Username'] . '</option>';
	            						}
	            					?>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Member Field -->
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
	
	       <?php
     		} elseif ($do == 'Insert') {

     			if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

					echo '<h1 class="text-center">Insert Item</h1>'; 
					echo '<div class="container">';

					// Get Variables From The Form
					$name 	 = $_POST['name'];
					$desc 	 = $_POST['description'];
					$price 	 = $_POST['price'];
					$country = $_POST['country'];
		            $status  = $_POST['status'];
		            $user_id = $_POST['user']; 
		            $cat_id  = $_POST['category'];           

					// Validate The Form
					$formErrors = array();

					if (empty($name)) {
						$formErrors[] = 'name Can\'t be <strong>empty</strong>';
					} 


					if (empty($desc)) {
						$formErrors[] = 'Description Can\'t be <strong>empty</strong>';
					} 


					if (empty($price)) {
						$formErrors[] = 'Price can\'t be <strong>empty</strong>';
					}

					if (empty($country)) {
						$formErrors[] = 'Country can\'t be <strong>empty</strong>';
					}

					if ($status == 0) {
						$formErrors[] = 'You must choose the <strong>status</strong>';
					}

					if ($user_id == 0) {
						$formErrors[] = 'You must choose a <strong>Member</strong>';
					}

					if ($cat_id == 0) {
						$formErrors[] = 'You must choose a <strong>Category</strong>';
					}
                    
                    if (!empty($formErrors)) {
                    	 echo '<div class="alert alert-danger">';
						foreach ($formErrors as $error) {
						echo '* ' . $error . '<br>';
					}
					echo '</div>';
                    }

					// Check if there's no error, proceed the update operation
					if (empty($formErrors)) { 

						// Insert userinfo in database
                    	$stmt = $db->prepare('INSERT INTO items (Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, Member_ID) VALUES (:name, :description, :price, CURDATE(), :country, :status, :cat_id, :user_id)');
                    	$stmt->execute(array(
                            'name' 			=> $name, 
                        	'description'   => $desc,
                        	'price'    		=> $price, 
                        	'country' 		=> $country,
                        	'status' 		=> $status,
                        	'cat_id'		=> $cat_id,
                        	'user_id'       => $user_id
                        ));

				    	// Echo Success Message
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added</div>';
						redirectHome($theMsg, 'items');	
                        
					}


				 } else {
					  echo '<div class="container">';
					  $errorMsg =  '<div class="alert alert-danger">You cant browse this page directly</div>';
					  redirectHome($errorMsg);
					  echo '</div>';
 				}

 				echo '</div>';

     		} elseif ($do == 'Edit') {

     			// Check of item_id is numeric 
	           $item_id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
	            
	            // Select item record with the given item_id
	           $stmt = $db->prepare('SELECT * FROM items WHERE Item_ID = ?');
	           $stmt->execute(array($item_id));
	           $item = $stmt->fetch(PDO::FETCH_ASSOC);
	           
	           
	           // If userid exist in database table, show the form with the user data
	           if ($stmt->rowCount() > 0) { ?>
	             
		            <h1 class="text-center">Edit Item</h1> 
		            <div class="container">
		            	<form class="form-horizontal" action="?do=Update" method="POST">
		            		<input type="hidden" name="itemid" value="<?php echo $item_id ?>">
		            		<!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" value="<?php echo $item['Name'] ?>" class="form-control" required="required" 
	            				placeholder="Name of the item">
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Desciption Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Description</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" value="<?php echo $item['Description'] ?>" class="form-control" required="required" 
	            				placeholder="Description of the item">
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Price Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Price</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="price" value="<?php echo $item['Price'] ?>" class="form-control" required="required" 
	            				placeholder="Price of the item">
	            			</div>
	            		</div>
	            		<!-- End Price Field -->
	            		<!-- Start country of made Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Country</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="country" value="<?php echo $item['Country_Made'] ?>" class="form-control" required="required" 
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
	            					<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; }?>>New</option>
	            					<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; }?>>Like New</option>
	            					<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; }?>>Used</option>
	            					<option value="4" <?php if ($item['Status'] == 4) { echo 'selected';  }?>>Old</option>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Staus Field -->
	            		<!-- Start Member Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Member</label>
	            			<div class="col-sm-10 col-md-6">
	            				<select name="user" class="form-control">
	            					<option value="0">Select member</option>
	            					<?php
	            						$stmt = $db->prepare('SELECT * FROM users');
	            						$stmt->execute();
	            						$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	            						foreach ($users as $user) {
	            							echo '<option value="' . $user['UserID'] . '"';
	            							if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; }
	            							echo '>' . $user['Username'] . '</option>';
	            						}
	            					?>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Member Field -->
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
	            							echo '<option value="' . $category['ID'] . '"';
	            							if ($item['Cat_ID'] == $category['ID']) { echo 'selected'; }
	            							echo  '>' . $category['Name'] . '</option>';
	            						}
	            					?>
	            				</select>
	            			</div>
	            		</div>
	            		<!-- End Category Field -->
	            		<!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Save" class="btn btn-success btn-lg pull-right ">
	            			</div>
	            		</div>
	            		<!-- End Save Button -->
		            	</form>
                       <?php
		            	$stmt = $db->prepare('SELECT 
 										comments.*, users.Username AS commenter
 								  FROM 
 								  		comments
 								  INNER JOIN users ON comments.user_id = users.UserID
 								  WHERE item_id = ?');
			 			$stmt->execute(array($item_id));
			 			$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
			 			 // echo '<pre>'; print_r($comments); echo '</pre>'; 
			 			if(!empty($comments)) { 
				 		    ?>
				 			<h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>
				 				<div class="table-responsive">
				 					<table class="table text-center table-bordered table-striped">
				 						<thead>
					 						<tr>
					 							<th>Comment</th>
					 							<th>Username</th>
					 							<th>Added Date</th>
					 							<th>Control</th>
					 						</tr>
				 						</thead>
				 				   <?php foreach ($comments as $comment) {
				 				 	 		echo '<tr>';
				 				 	 			echo '<td>' . $comment['comment'] . '</td>';
				 				 	 			echo '<td>' . $comment['commenter'] . '</td>';
				 				 	 			echo '<td>' . $comment['comment_date'] .'</td>';
				 				 	 			echo '<td>';
				 				 	 				echo '<a href="comments.php?do=Edit&comid='. $comment['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>';
				 				 	 				echo '<a href="comments.php?do=Delete&comid='. $comment['c_id'] . '" class="btn btn-danger confirm"><i class="fa fa-trash-o"></i>Delete</a>';
				 				 	 			if ($comment['status'] == 0) {
				 				 	 				echo '<a href="comments.php?do=Approve&comid=' . $comment['c_id'] . '" class="btn btn-info "><i class="fa fa-check"></i>Approve</a>';
				 				 	 			}
				 				 	 			echo '</td>';
				 				 	 		echo '</tr>';
				 					     }
				 				    ?>
				 					</table>
				 				</div>
				 			<?php } ?>
		            </div>

	 		<?php	
				  } else { 

				  		echo '<div class="container">';   
							$errorMsg = '<div class="alert alert-danger">There is no such id</div>';
							redirectHome($errorMsg, 'back');
						echo '</div>';
				  }  

     		} elseif ($do == 'Update') {

     			if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

					echo '<h1 class="text-center">Update Item</h1>'; 
					echo '<div class="container">';

					// Get Variables From The Form
					$itemid  = $_POST['itemid'];
					$name 	 = $_POST['name'];
					$desc 	 = $_POST['description'];
					$price 	 = $_POST['price'];
					$country = $_POST['country'];
		            $status  = $_POST['status'];
		            $user_id = $_POST['user']; 
		            $cat_id  = $_POST['category'];           

					// Validate The Form
					$formErrors = array();

					if (empty($name)) {
						$formErrors[] = 'name Can\'t be <strong>empty</strong>';
					} 


					if (empty($desc)) {
						$formErrors[] = 'Description Can\'t be <strong>empty</strong>';
					} 


					if (empty($price)) {
						$formErrors[] = 'Price can\'t be <strong>empty</strong>';
					}

					if (empty($country)) {
						$formErrors[] = 'Country can\'t be <strong>empty</strong>';
					}

					if ($status == 0) {
						$formErrors[] = 'You must choose the <strong>status</strong>';
					}

					if ($user_id == 0) {
						$formErrors[] = 'You must choose a <strong>Member</strong>';
					}

					if ($cat_id == 0) {
						$formErrors[] = 'You must choose a <strong>Category</strong>';
					}
                    
                    if (!empty($formErrors)) {
                    	 echo '<div class="alert alert-danger">';
						foreach ($formErrors as $error) {
						echo '* ' . $error . '<br>';
					}
					echo '</div>';
                    }

					// Check if there's no error, proceed the update operation
					if (empty($formErrors)) { 

						// Insert userinfo in database
                    	$stmt = $db->prepare('UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ? WHERE Item_ID = ?') ;
                    	$stmt->execute(array($name, $desc, $price, $country, $status, $cat_id, $user_id, $itemid));

				    	// Echo Success Message
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added</div>';
						redirectHome($theMsg, 'items');	
                        
					}


				 } else {
					  echo '<div class="container">';
					  $errorMsg =  '<div class="alert alert-danger">You cant browse this page directly</div>';
					  redirectHome($errorMsg);
					  echo '</div>';
 				}

 				echo '</div>';

     		} elseif ($do == 'Delete') {

     			// Delete Item Page
				echo '<h1 class="text-center">Delete Item</h1>'; 
				echo '<div class="container">';

				// Check of userid is numeric 
           		$itemid  = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
            
            	// Select item record with the given item_id
          	 	 $check = checkItem('Item_ID', 'items', $itemid);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('DELETE FROM items WHERE Item_ID = :itemid');
           			$stmt->bindValue(':itemid', $itemid , PDO::PARAM_INT);
           			$stmt->execute();

           			// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 'back');
           		} else { 
           			echo '<div class="container">';
           			$errorMsg = '<div class="alert alert-danger">You cant browse this page directly</div>';
					redirectHome($errorMsg);
					echo '</div>'; 
           		}

           		echo '</div>';

     		} elseif ($do == 'Approve') {

     			// Approve Item 
				echo '<h1 class="text-center">Approve Item</h1>'; 
				echo '<div class="container">';

				// Check if itemid is exist and numeric 
           		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 
            
            	// Select user record with the given userid
          	 	 $check = checkItem('Item_ID', 'items', $itemid);
       
           		// If user exist, approved in items table
           		if ($check) {
           			$stmt = $db->prepare('UPDATE items SET Approve = 1 WHERE Item_ID = :itemid');
           			$stmt->bindValue(':itemid', $itemid, PDO::PARAM_INT);
           			$stmt->execute(); 

           			// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Item Approved</div>';
					redirectHome($theMsg, 'back');
           		} else { 
           			echo '<div class="container">';
           			$errorMsg = '<div class="alert alert-danger">You cant browse this page directly</div>';
					redirectHome($errorMsg);
					echo '</div>'; 
           		}

           		echo '</div>';


     		}

     		include $tpl . 'footer.php';
     } else {
     	header('Location: index.php');
     	exit();
     }