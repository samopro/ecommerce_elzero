<?php

	/*
	 ====================================================================
	 == Manage Members Page
	 == You Can Add | Edit | Delete Members From Here
	 ====================================================================
	*/

	session_start();

	$pageTitle = 'Members';

 	if (isset($_SESSION['Username'])) {

 		include 'init.php';

 		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

 		if ($do == 'Manage') { // Manage Page 

 			$query = '';

 			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
 				$query = ' AND RegStatus = 0';
 			}

 			$stmt = $db->prepare('SELECT * FROM users WHERE GroupID != 1' . $query);
 			$stmt->execute();
 			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			// echo '<pre>'; print_r($rows); echo '</pre>'; 
 		?>
 			<h1 class="text-center">Manage Members</h1>
 			<div class="container">
 				<div class="table-responsive">
 					<table class="table manage-members text-center table-bordered table-striped">
 						<thead>
	 						<tr>
	 							<th>#ID</th>
								<th>Avatar</th>
	 							<th>Username</th>
	 							<th>Email</th>
	 							<th>Full Name</th>
	 							<th>Registerd Date</th>
	 							<th>Control</th>
	 						</tr>
 						</thead>
 				   <?php foreach ($rows as $row) {
 				 	 		echo '<tr>';
								echo '<td>' . $row['UserID'] . '</td>';
								echo '<td>';
								if (empty($row['profile_img'])) {
									echo '<img src="uploads/profile_img/placeholder_profile.png" alt="avatar">';
								} else {
									echo '<img src="uploads/profile_img/' . $row['profile_img'] . '" alt="avatar">';
								}
								
								echo '</td>';
 				 	 			echo '<td>' . $row['Username'] . '</td>';
 				 	 			echo '<td>' . $row['Email'] . '</td>';
 				 	 			echo '<td>' . $row['FullName'] . '</td>';
 				 	 			echo '<td>' . $row['Date'] .'</td>';
 				 	 			echo '<td>';
 				 	 				echo '<a href="?do=Edit&userid='. $row['UserID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>';
 				 	 				echo '<a href="?do=Delete&userid='. $row['UserID'] . '" class="btn btn-danger confirm"><i class="fa fa-trash-o"></i>Delete</a>';
 				 	 			if ($row['RegStatus'] == 0) {
 				 	 				echo '<a href="?do=Activate&userid=' . $row['UserID'] . '" class="btn btn-warning"><i class="fa fa-check"></i>Activate</a>';
 				 	 			}
 				 	 			echo '</ td>';
 				 	 		echo '</tr>';
 					     }
 				    ?>
 					</table>
 				</div>
 				<a href=" ?do=Add" class="btn btn-primary "><i class="fa fa-plus"></i>&nbsp;New Member</a>
 			</div>

 	<?php	} elseif ($do == 'Add') { // Add Member Page
 		?>
 			<h1 class="text-center">Add Member</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
	            		<!-- Start Username Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Username</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="username" class="form-control" autocomplete="off" required="required" 
	            				>
	            			</div>
	            		</div>
	            		<!-- End Username Field -->
	            		<!-- Start Password Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Password</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="password" name="password" class="form-control password" autocomplete="new-password" required="required ">
	            				<i class="show-pass fa fa-eye fa-2x"></i>
	            			</div>
	            		</div>
	            		<!-- End Password Field -->
	            		<!-- Start Email Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Email</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="email" name="email" class="form-control" required="required">
	            			</div>
	            		</div>
	            		<!-- End Email Field -->
	            		<!-- Start Full Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Full Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="fullname" class="form-control" required="required">
	            			</div>
	            		</div>
	            		<!-- End Full Name Field -->
						<!-- Start Profile Image Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Profile Image</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="file" name="profile_img" class="form-control" required="required">
	            			</div>
	            		</div>
	            		<!-- End Profile Image Field -->
	            		<!-- Start Save Button -->
	            		<div class="form-group">
	            			<div class="col-sm-offset-2 col-sm-10 col-md-6">
	            				<input type="submit" value="Add Member" class="btn btn-primary btn-lg pull-right">
	            			</div>
	            		</div>
	            		<!-- End Save Button -->
	            	</form>
	            </div>

 	<?php	} elseif ($do == 'Insert') { // Insert Member Page 

				if ($_SERVER['REQUEST_METHOD'] == 'POST') { // If the request come from REQUEST METHOD 

					echo '<h1 class="text-center">Insert Member</h1>'; 
					echo '<div class="container">';

					// Upload Variables
					$profileImgName = $_FILES['profile_img']['name'];
					$profileImgSize = $_FILES['profile_img']['size'];
					$profileImgTmp	= $_FILES['profile_img']['tmp_name'];
					$profileImgType = $_FILES['profile_img']['type'];

					//List of allowed file extentions to upload
					$profileImgAllowedExtention = array('jpeg', 'jpg', 'png', 'gif');

					// Get profile image extention
					$profileImgExtention = strtolower(end(explode('.', $profileImgName)));

					// Get Variables From The Form
					$username 	= $_POST['username'];
					$email 		= $_POST['email'];
					$name 		= $_POST['fullname'];
					$pass 		= $_POST['password'];
		                        $hashedPass = sha1($pass); 

					// Validate The Form
					$formErrors = array();

					if (empty($username)) {
						$formErrors[] = 'User name Cant be <strong>empty</strong>';
					} 

					if (strlen($username) < 4) {
						$formErrors[] = 'Username cant be less than <strong>4 characters</strong>';
					}

					if (strlen($username ) > 20) {
						$formErrors[] = 'Username cant be more than <strong>20 characters</strong>';
					}

					if (empty($pass)) {
						$formErrors[] = 'Password Cant be <strong>empty</strong>';
					} 


					if (empty($name)) {
						$formErrors[] = 'Full name cant be <strong>empty</strong>';
					}

					if (strlen($name) < 2) {
						$formErrors[] = 'Full name cant be less than <strong>2 characters</strong>';
					}

					if (empty($email)) {
						$formErrors[] = 'Email cant be <strong>empty</strong>';
					}

					if (!empty($profileImgName) && !in_array($profileImgExtention, $profileImgAllowedExtention)) {
						$formErrors[] = 'This extension not <strong>Allowed</strong>';
					}

					if (empty($profileImgName)) {
						$formErrors[] = 'Profile image is <strong>required</strong>';
					}

					if ($profileImgSize > 4194304) {
						$formErrors[] = 'Profile image can\'t be larger than <strong>4MB</strong>';
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

						// File Upload
						$profileImg = rand(0, 100000) . '_' . $profileImgName;
						move_uploaded_file($profileImgTmp, "uploads\profile_img\\" . $profileImg);

						// Check If User Exist in Database
						if (checkItem('Username', 'users', $username))  {
							$errorMsg = '<div class="alert alert-danger">Sorry this user is exist</div>';
							redirectHome($errorMsg, 'members');
						} else {

							// Insert userinfo in database
                        	$stmt = $db->prepare("INSERT INTO users (Username, Password, Email, FullName, RegStatus, Date, profile_img) 
												  VALUES (:username, :pass, :email, :fullname, 1, CURDATE(), :profile_img) ");
                        	$stmt->execute(array(
                                'username' 		=> $username, 
                            	'pass'     		=> $hashedPass,
                            	'email'    		=> $email, 
								'fullname' 		=> $name,
								'profile_img'	=> $profileImg
                            ));

					    	// Echo Success Message
							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Added</div>';
							redirectHome($theMsg, 'members');
						}	
                        
					}


				 } else {
					  echo '<div class="container">';
					  $errorMsg =  '<div class="alert alert-danger">You cant browse this page directly</div>';
					  redirectHome($errorMsg);
					  echo '</div>';
 				}

 				echo '</div>';

 			} elseif ($do == 'Edit') { // Edit Member Page 
            
            // Check of userid is numeric 
           $user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
            
            // Select user record with the given userid
           $stmt = $db->prepare('SELECT * FROM users WHERE UserID = ?');
           $stmt->execute(array($user));
           $row = $stmt->fetch();
           
           
           // If userid exist in database table, show the form with the user data
           if ($stmt->rowCount() > 0) { ?>
             
	            <h1 class="text-center">Edit Member</h1> 
	            <div class="container">
	            	<form class="form-horizontal" action="?do=Update" method="POST">
	            		<input type="hidden" name="userid" value="<?php echo $user ?>">
	            		<!-- Start Username Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Username</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required" 
	            				>
	            			</div>
	            		</div>
	            		<!-- End Username Field -->
	            		<!-- Start Password Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Password</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
	            				<input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Leave blank if you dont want to change 't">
	            			</div>
	            		</div>
	            		<!-- End Password Field -->
	            		<!-- Start Email Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Email</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required">
	            			</div>
	            		</div>
	            		<!-- End Email Field -->
	            		<!-- Start Full Name Field -->
	            		<div class="form-group form-group-lg">
	            			<label class="col-sm-2 control-label">Full Name</label>
	            			<div class="col-sm-10 col-md-6">
	            				<input type="text" name="fullname" value="<?php echo $row['FullName'] ?>" class="form-control" required="required">
	            			</div>
	            		</div>
	            		<!-- End Full Name Field -->
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

					echo '<h1 class="text-center">Update Member</h1>'; 
					echo '<div class="container">';

					// Get Variables From The Form
					$id 		= $_POST['userid'];
					$username 	= $_POST['username'];
					$email 		= $_POST['email'];
					$name 		= $_POST['fullname'];

					// Password
					// If password empty // Save the old password // Else save the new password with sha1 encryption
					$pass = empty($_POST['password']) ? $_POST['oldpassword'] : sha1($_POST['password']); 

					// Validate The Form
					$formErrors = array();

					if (empty($username)) {
						$formErrors[] = 'User name Cant be <strong>empty</strong>';
					} 

					if (strlen($username) < 4) {
						$formErrors[] = 'Username cant be less than <strong>4 characters</strong>';
					}

					if (strlen($username ) > 20) {
						$formErrors[] = 'Username cant be more than <strong>20 characters</strong>';
					}

					if (empty($name)) {
						$formErrors[] = 'Full name cant be <strong>empty</strong>';
					}

					if (strlen($name) < 2) {
						$formErrors[] = 'Full name cant be less than <strong>2 characters</strong>';
					}

					if (empty($email)) {
						$formErrors[] = 'Email cant be <strong>empty</strong>';
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

						    $stmt2 = $db->prepare('SELECT * FROM users WHERE Username = ? AND UserID != ?');
						    $stmt2->execute(array($username, $id));

							if($stmt2->rowCount() != 1) {

	                            // Update user record in the database with the niew given data
	                            $stmt = $db->prepare('UPDATE users SET Username = ?, Password = ?, Email = ?, FullName = ? WHERE UserID = ?');
	                            $stmt->execute(array($username, $pass, $email, $name, $id));

								// Echo Success Message
								$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated</div>';
								redirectHome($theMsg, 'members');
							} else {
								echo '<div class="container">';   
								$errorMsg = '<div class="alert alert-danger">This username is already exist.</div>';
								redirectHome($errorMsg, 'back');
								echo '</div>';
							}
					}


				} else {
					echo '<div class="container">';   
					$errorMsg = '<div class="alert alert-danger">You cant browse this page directly</div>';
					redirectHome($errorMsg);
					echo '</div>';
 				}

 				echo '</div>';
			} elseif ($do == 'Delete') {
				// Delete Member Page
				echo '<h1 class="text-center">Delete Member</h1>'; 
				echo '<div class="container">';

				// Check of userid is numeric 
           		$user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
            
            	// Select user record with the given userid000
           		// $stmt = $db->prepare('SELECT * FROM users WHERE UserID = ?');
          	 	// $stmt->execute(array($user));
          	 	 $check = checkItem('UserID', 'users', $user);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('DELETE FROM users WHERE UserID = :userid');
           			$stmt->bindValue(':userid', $user, PDO::PARAM_INT);
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

			} elseif ($do == 'Activate') {
				// Activate Member 
				echo '<h1 class="text-center">Activate Member</h1>'; 
				echo '<div class="container">';

				// Check of userid is numeric 
           		$user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
            
            	// Select user record with the given userid
          	 	 $check = checkItem('UserID', 'users', $user);
       
           		// If user exist, delete 't from users table
           		if ($check) {
           			$stmt = $db->prepare('UPDATE users SET RegStatus = 1 WHERE UserID = :userid');
           			$stmt->bindValue(':userid', $user, PDO::PARAM_INT);
           			$stmt->execute(); 

           			// Echo Success Message
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Member Activated</div>';
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