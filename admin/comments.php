<?php

	/*
	 ====================================================================
	 == Manage Comments Page
	 == You Can  Edit | Delete Comments From Here
	 ====================================================================
	*/

	session_start();

	$pageTitle = 'Comments';

 	if (isset($_SESSION['Username'])) {

 		include 'init.php';

 		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

 		if ($do == 'Manage') { // Manage Page 

 			$stmt = $db->prepare('SELECT 
 										comments.*, items.Name AS item_name, users.Username AS commenter
 								  FROM 
 								  		comments
 								  INNER JOIN items ON comments.item_id = items.Item_ID
 								  INNER JOIN users ON comments.user_id = users.UserID');
 			$stmt->execute();
 			$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			 // echo '<pre>'; print_r($comments); echo '</pre>'; 
 		?>
 			<h1 class="text-center">Manage Comments</h1>
 			<div class="container">
 				<div class="table-responsive">
 					<table class="table text-center table-bordered table-striped">
 						<thead>
	 						<tr>
	 							<th>ID</th>
	 							<th>Comment</th>
	 							<th>Item Name</th>
	 							<th>Username</th>
	 							<th>Added Date</th>
	 							<th>Control</th>
	 						</tr>
 						</thead>
 				   <?php foreach ($comments as $comment) {
 				 	 		echo '<tr>';
 				 				echo '<td>' . $comment['c_id'] . '</td>';
 				 	 			echo '<td>' . $comment['comment'] . '</td>';
 				 	 			echo '<td>' . $comment['item_name'] . '</td>';
 				 	 			echo '<td>' . $comment['commenter'] . '</td>';
 				 	 			echo '<td>' . $comment['comment_date'] .'</td>';
 				 	 			echo '<td>';
 				 	 				echo '<a href="?do=Edit&comid='. $comment['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>';
 				 	 				echo '<a href="?do=Delete&comid='. $comment['c_id'] . '" class="btn btn-danger confirm"><i class="fa fa-trash-o"></i>Delete</a>';
 				 	 			if ($comment['status'] == 0) {
 				 	 				echo '<a href="?do=Approve&comid=' . $comment['c_id'] . '" class="btn btn-info "><i class="fa fa-check"></i>Approve</a>';
 				 	 			}
 				 	 			echo '</ td>';
 				 	 		echo '</tr>';
 					     }
 				    ?>
 					</table>
 				</div>
 			</div>

 			<?php

 			} elseif ($do == 'Edit') { // Edit Member Page 
            
            // Check of userid is numeric 
           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 
            
            // Select user record with the given userid
           $stmt = $db->prepare('SELECT * FROM comments WHERE c_id = ?');
           $stmt->execute(array($comid));
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           
           // If userid exist in database table, show the form with the user data
           if ($stmt->rowCount() > 0) { ?>
             
	            <h1 class="text-center">Edit Comment</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Update" method="POST">
	            		<input type="hidden" name="comid" value="<?php echo $comid ?>">
	            		<!-- Start Comment Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Comment</label>
	            			<div class="col-sm-10 col-md-6">
	            				<textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
	            			</div>
	            		</div>
	            		<!-- End Comment Field -->
	            		
	                    <!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Save" class="btn btn-success btn-lg pull-right">
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
			} elseif ($do == 'Update') { // Update Page

				if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

					echo '<h1 class="text-center">Update Comment</h1>'; 
					echo '<div class="container">';

					// Get Variables From The Form
					$comid 		= $_POST['comid'];
					$comment 	= $_POST['comment'];
					
                    // Update user record in the database with the niew given data
                    $stmt = $db->prepare('UPDATE comments SET comment = ? WHERE c_id = ?');
                    $stmt->execute(array($comment, $comid));

					// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg, 'comments');


				} else {
					echo '<div class="container">';   
					$errorMsg = '<div class="alert alert-danger">You cant browse this page directly</div>';
					redirectHome($errorMsg);
					echo '</div>';
 				}

 				echo '</div>';
			} elseif ($do == 'Delete') {
				// Delete Member Page
				echo '<h1 class="text-center">Delete Comment</h1>'; 
				echo '<div class="container">';

				// Check of comment id is numeric 
           		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 
            
            	// Select user record with the given userid000
           		// $stmt = $db->prepare('SELECT * FROM users WHERE UserID = ?');
          	 	// $stmt->execute(array($user));
          	 	 $check = checkItem('c_id', 'comments', $comid);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('DELETE FROM comments WHERE c_id = :comid');
           			$stmt->bindValue(':comid', $comid, PDO::PARAM_INT);
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
				// Activate Member 
				echo '<h1 class="text-center">Approve Comment</h1>'; 
				echo '<div class="container">';

				// Check of comment id is numeric 
           		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            
            	// Select user record with the given comid
          	 	 $check = checkItem('c_id', 'comments', $comid);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('UPDATE comments SET status = 1 WHERE c_id = :comid');
           			$stmt->bindValue(':comid', $comid, PDO::PARAM_INT);
           			$stmt->execute(); 

           			// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Comment Approved</div>';
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