<?php 
	 /*
	  =============================================================
	  == Category Page
	  == You Can Add | Edit | Delete Categories From Here
	  =============================================================	
	 */

     session_start();

     $pageTitle = 'Categories';

     if (isset($_SESSION['Username'])) {
     	
     	include 'init.php';
     	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

     	if ($do == 'Manage') {

     		$sort = 'ASC';

     		$sort_array = array('ASC', 'DESC');

     		if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
     			$sort = $_GET['sort'];
     		}
            
     		$cats = getAll("*", "categories", "WHERE parent=0", "", "Ordering", "$sort"); 
?>

     	<h1 class="text-center">Manage Categories</h1>
     	<div class="container categories">
     		<div class="panel panel-default">
     			<div class="panel-heading">
     				<i class="fa fa-gear"></i>&nbsp;Manage Categories
     				<div class="option pull-right">
     					<i class="fa fa-sort"></i>&nbsp;Ordering: 
     					[<a class="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">Asc</a> |
     					<a class="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">Desc</a>]
     					<i class="fa fa-eye"></i>&nbsp;View:
     					[<span class="active" data-view="full">Full</span> |
     					<span data-view="classic">Classic</span>]
     				</div>
     			</div>
     			<div class="panel-body">
     				<?php

     					foreach($cats as $cat) {
     						echo '<div class="cat">';
     							echo '<div class="hidden-btn pull-right">';
     								echo '<a href="?do=Edit&catid=' . $cat['ID'] . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i>Edit</a>';
     								echo '<a href="?do=Delete&catid=' . $cat['ID']. '" class="btn btn-xs btn-danger confirm"><i class="fa fa-trash-o"></i>Delete</a>';
     							echo '</div>';
	     						echo '<h3>' . $cat['Name'] . '</h3> ';
	     						echo '<div class="full-view">';
		     						$desc = !empty($cat['Description']) ? $cat['Description'] : 'This category has no description';
		     						echo '<p>' . $desc . '</p>'; 
		     						if ($cat['Visibility'] == 1) { echo '<span class="labels visibility">Hidden</span>';  } 
		     						if ($cat['Allow_Comment' ] == 1) { echo '<span class="labels commenting">Comment Disabled</span>'; } 
		     						if ($cat['Allow_Ads'] == 1) { echo '<span class="labels advertises">Ads Disabled</span>'; }
	     						echo '</div>';
     						
                            
                            // Get Child Category
                            $childCats = getAll("*", "categories", "WHERE parent={$cat['ID']}", "", "ID");
                            if(!empty($childCats)) {
                                echo '<h4 class="child-head">Child Categories</h4>';
                                echo '<ul class="list-unstyled child-cats">';
                                foreach ($childCats as $cat_child) {
                                    echo '<li class="child-link">';
                                        echo '<a href="?do=Edit&catid=' . $cat_child['ID'] . '">' . $cat_child['Name'] . '</a>';
                                        echo '<a href="?do=Delete&catid=' . $cat_child['ID']. '" class="confirm show-delete"> Delete</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                            echo '</div>';
                            echo '<hr>';
     					}

     				?>
     			</div>
     		</div>
     		<a class="btn btn-primary add-category" href="categories.php?do=Add"><i class="fa fa-plus"></i>&nbsp;New Category</a>
     	</div>

     	<?php
     	} elseif ($do == 'Add') { ?>

     		<h1 class="text-center">Add Category</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Insert" method="POST">
	            		<!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" class="form-control" autocomplete="off" required="required" 
	            				>
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Description Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Descritpion</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" class="form-control" >
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Ordering Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Ordering</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="ordering" class="form-control">
	            			</div>
	            		</div>
	            		<!-- End Ordering Field -->
	            		<!-- Start Category Type -->
	            		<div class="form-group form-group-lg">
	            		    <label class="col-sm-2 control-label">Parent?</label>
	            		    <div class="col-sm-10 col-md-6">
	            		        <select name="parent" class="form-control">
	            		            <option value="0">None</option>
	            		            <?php
                                        $allCats = getAll("*", "categories", "WHERE parent=0", "", "ID", "ASC" );
                                        foreach ($allCats as $cat) {
                                            echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>'; 
                                        }
                                    ?>
	            		        </select>
	            		    </div>
	            		</div>
	            		<!-- End Category Type -->
	            		<!-- Start Visibility Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Visible</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="vis-yes" type="radio" name="visibility" value="0" checked="checked">
	            					<label for="vis-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="vis-no" type="radio" name="visibility" value="1">
	            					<label for="vis-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Visibility Field -->
	            		<!-- Start Commenting Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Allow Commenting</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="com-yes" type="radio" name="commenting" value="0" checked="checked">
	            					<label for="com-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="com-no" type="radio" name="commenting" value="1">
	            					<label for="com-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Commenting Field -->
	            		<!-- Start Ads Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Allow Ads</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="ads-yes" type="radio" name="ads" value="0" checked="checked">
	            					<label for="ads-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="ads-no" type="radio" name="ads" value="1">
	            					<label for="ads-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Ads Field -->
	            		<!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Add Category" class="btn btn-primary btn-lg ">
	            			</div>
	            		</div>
	            		<!-- End Save Button -->
	            	</form>
	            </div>

     	<?php

     	} elseif ($do == 'Insert') { // Insert Category
     		
     		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

				echo '<h1 class="text-center">Insert Category</h1>'; 
				echo '<div class="container">';

				// Get Variables From The Form
				$name 	    = $_POST['name'];
				$desc    	= $_POST['description'];
                $parent     = $_POST['parent'];
				$order 	    = $_POST['ordering'];
				$visible    = $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads']; 
                
                if (!empty(trim($name))) {
				
					// Check If Category Exist in Database
					if (checkItem('Name', 'categories', $name))  {
						$errorMsg = '<div class="alert alert-danger">Sorry this category is already exist</div>';
						redirectHome($errorMsg, 'back');
					} else {

						// Insert category data in database
	                	$stmt = $db->prepare('INSERT INTO categories(Name, Description, parent,Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES (:name, :description, :parent,:ordering, :visibility, :comment, :ads)' );
	                	$stmt->execute(array(
	                        'name' 			  => $name, 
	                    	'description'     => $desc,
                            'parent'          => $parent,
	                    	'visibility' 	  => $visible,
	                    	'ordering'    	  => $order, 
	                    	'comment'		  => $comment,
	                    	'ads' 	   		  => $ads
	                    ));

				    	// Echo Success Message
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added</div>';
						redirectHome($theMsg, 'categories');
					}	
			    } else {
			    	echo '<div class="container">';
			  		$errorMsg =  '<div class="alert alert-danger">The name of category cant be empty</div>';
			  		redirectHome($errorMsg, 'back');
			  		echo '</div>';
			    }


		    } else {
			  echo '<div class="container">';
			  $errorMsg =  '<div class="alert alert-danger">You cant browse this page directly</div>';
			  redirectHome($errorMsg);
			  echo '</div>';
			}

 				echo '</div>';


     	} elseif ($do == 'Edit') {

     		 // Check if catid exist and is numeric 
           $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 
            
            // Select user record with the given userid
            
           $stmt = $db->prepare('SELECT * FROM categories WHERE ID = ?');
           $stmt->execute(array($catid));
           $cats = $stmt->fetch();
           
           
           // If userid exist in database table, show the form with the user data
           if ($stmt->rowCount() > 0) { ?>
             
	            <h1 class="text-center">Edit Category</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Update" method="POST">
	            		<input type="hidden" name="catid" value="<?php echo $catid ?>">
	            		<!-- Start Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="name" class="form-control" autocomplete="off" required="required" 
	            				value="<?php echo $cats['Name'] ?>">
	            			</div>
	            		</div>
	            		<!-- End Name Field -->
	            		<!-- Start Description Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Descritpion</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="description" class="form-control" value="<?php echo $cats['Description'] ?>">
	            			</div>
	            		</div>
	            		<!-- End Description Field -->
	            		<!-- Start Ordering Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Ordering</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="ordering" class="form-control" value="<?php echo $cats['Ordering'] ?>">
	            			</div>
	            		</div>
	            		<!-- End Ordering Field -->
	            		<!-- Start Category Type -->
	            		<div class="form-group form-group-lg">
	            		    <label class="col-sm-2 control-label">Parent?</label>
	            		    <div class="col-sm-10 col-md-6">
	            		        <select name="parent" class="form-control">
	            		            <option value="0">None</option>
	            		            <?php
                                        $allCats = getAll("*", "categories", "WHERE parent=0", "", "ID", "ASC" );
                                        foreach ($allCats as $cat) {
                                            echo '<option value="' . $cat['ID'] .'"'; 
                                            if ($cat['ID'] == $cats['parent']) { echo ' selected'; }
                                            echo '>' . $cat['Name'] . '</option>'; 
                                        }
                                    ?>
	            		        </select>
	            		    </div>
	            		</div>
	            		<!-- End Category Type -->
	            		<!-- Start Visibility Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Visible</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cats['Visibility'] == 0) { echo 'checked'; } ?>>
	            					<label for="vis-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cats['Visibility'] == 1) { echo 'checked'; } ?>>
	            					<label for="vis-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Visibility Field -->
	            		<!-- Start Commenting Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Allow Commenting</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cats['Allow_Comment'] == 0) { echo 'checked'; } ?>>
	            					<label for="com-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="com-no" type="radio" name="commenting" value="1" <?php if ($cats['Allow_Comment'] == 1) { echo 'checked'; } ?>>
	            					<label for="com-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Commenting Field -->
	            		<!-- Start Ads Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Allow Ads</label>
	            			<div class="col-sm-10 col-md-6">
	            				<div>
	            					<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cats['Allow_Ads'] == 0) { echo 'checked'; } ?>>
	            					<label for="ads-yes">Yes</label>
	            				</div>
	            				<div>
	            					<input id="ads-no" type="radio" name="ads" value="1" <?php if ($cats['Allow_Ads'] == 1) { echo 'checked'; } ?>>
	            					<label for="ads-no">No</label>
	            				</div>
	            			</div>
	            		</div>
	            		<!-- End Ads Field -->
	            		<!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Save" class="btn btn-success btn-lg ">
	            			</div>
	            		</div>
	            		<!-- End Save Button -->
	            	</form>
	            </div>

 		<?php	
			  } else { 

			  		echo '<div class="container">';   
						$errorMsg = '<div class="alert alert-danger">There is no such id</div>';
						redirectHome($errorMsg);
					echo '</div>';
			  }  

     	} elseif ($do == 'Update') {

     		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

					echo '<h1 class="text-center">Update Member</h1>'; 
					echo '<div class="container">';

					// Get Variables From The Form
					$id 		= $_POST['catid'];
					$name 		= ltrim(rtrim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)));
					$desc    	= ltrim(rtrim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)));
					$order 	    = $_POST['ordering'];
                    $parent     = $_POST['parent'];
					$visible    = $_POST['visibility'];
					$comment 	= $_POST['commenting'];
					$ads 		= $_POST['ads']; 
                            // Update user record in the database with the niew given data
                            $stmt = $db->prepare('UPDATE 
                            							categories 
                            					  SET 
                            					  	     Name = ?, 
                            					  	     Description = ?, 
                            					  	     Ordering = ?, 
                                                         parent = ?,
                            					  	     Visibility = ?,  
                            					  	     Allow_Comment = ?, 
                            					  	     Allow_Ads = ? 
                            					   WHERE 
                            					   		 ID = ?');
                            $stmt->execute(array($name, $desc, $order, $parent,$visible, $comment, $ads, $id));

							// Echo Success Message
							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated</div>';
							redirectHome($theMsg, 'categories');


			} else {
					echo '<div class="container">';   
					$errorMsg = '<div class="alert alert-danger">You cant browse this page directly</div>';
					redirectHome($errorMsg);
					echo '</div>';
 				}

 				echo '</div>';

     	} elseif ($do == 'Delete') {

     		// Delete Category
				echo '<h1 class="text-center">Delete Category</h1>'; 
				echo '<div class="container">';

				// Check of catid is numeric 
           		$id = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 
            
            	// Select user record with the given userid000
           		// $stmt = $db->prepare('SELECT * FROM users WHERE UserID = ?');
          	 	// $stmt->execute(array($user));
          	 	 $check = checkItem('ID', 'categories', $id);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('DELETE FROM categories WHERE ID = :catid');
           			$stmt->bindValue(':catid', $id, PDO::PARAM_INT);
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

     	}

     		include $tpl . 'footer.php';
     } else {
     	header('Location: index.php');
     	exit(); 
     }