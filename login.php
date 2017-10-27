<?php
	session_start();
    
     $pageTitle = 'Login';

     if (isset($_SESSION['user'])) {
     	header('Location: index.php'); // If session al ready exist, redirect direclty to Homepage
     }

	include 'init.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['login'])) {

			$user 		= $_POST['username'];
			$password 	= $_POST['password'];

			$hashedPass = sha1($password);

		 // Check if the user exit in database
			$stmt = $db->prepare('SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ?');
			$stmt->execute(array($user, $hashedPass));
	 	    $get = $stmt->fetch();

	 	 // If count > 0, this mean the database contain record about this username
			if ($stmt->rowCount() > 0) {
			  $_SESSION['user'] = $user; // Register session name
			  $_SESSION['uid'] = $get['UserID']; // Register session user id +
	 	 	 header('Location: index.php'); // Redirect to Dashboard page
	 	 	 exit();	
	 	 	} 

	 	} else {

	 	 	$formErrors = array();

	 	 	$username  = $_POST['username'];
	 	 	$password  = $_POST['password'];
	 	 	$password2 = $_POST['password-confirm'];
	 	 	$email 	   = $_POST['email'];
            
            // Check the username validation
	 	 	if (isset($username)) {
	 	 		$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

	 	 		if (strlen($filterdUser) < 5) {
	 	 			$formErrors[] = 'Username must be larger than 4 characters';
	 	 		}
	 	 	}

	 	 	// Check the password validation
	 	 	if (isset($password) && isset($password2)) {

	 	 		if (empty(trim($password))) {
	 	 			$formErrors[] = 'Password cant be empty';
	 	 		}

	 	 		if (sha1($password) !== sha1($password2)) {
	 	 			$formErrors[] = 'Sorry password is not match';
	 	 		}

	 	 	}

	 	 	// Check the email validation
	 	 	if (isset($email)) {

	 	 		$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

	 	 		if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
	 	 			$formErrors[] = 'This email is not valid';
	 	 		}
	 	 	}

	 	 	// Check if there's no error, proceed the update operation
			if (empty($formErrors)) { 

				// Check If User Exist in Database
				if (checkItem('Username', 'users', $username))  {
					$formErrors[] = 'Sorry this user is exist';
				} else {

					// Insert userinfo in database
                	$stmt = $db->prepare('INSERT INTO users (Username, Password, Email, Date) VALUES (:username, :pass, :email, CURDATE())');
                	$stmt->execute(array(
                        'username' => $username, 
                    	'pass'     => sha1($password),
                    	'email'    => $email, 
                    ));

			    	// Echo Success Message
					$successMsg = 'Congrats you are now registerd user';
				}	
                
			}


	 	}
		
	}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="login selected">Login</span> | <span class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<input type="text" class="form-control" name="username" autocomplete="off" placeholder="Type your username"> 
		<input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Type your password">
		<input type="submit" class="btn btn-primary btn-block" name="login" value="Login ">
	</form>
	<!-- End Login Form -->

	<!-- Start Signup Form -->
	<form class="signup" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input type="text" class="form-control" name="username" autocomplete="off" placeholder="Your username" required="required">
		</div>
		<div class="input-container">
			<input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Create a password" required="required"> 
		</div>
		<div class="input-container">
			<input type="password" class="form-control" name="password-confirm" autocomplete="new-password" placeholder="Confirm your password" required="required">
		</div>
		<div class="input-container">
			<input type="email" class="form-control" name="email" placeholder="Type a valid email" required="required">
		</div>
		<div class="input-container">
			<input type="submit" class="btn btn-success btn-block" name="signup" value="Signup ">
		</div>
	</form>
	<!-- End Signup Form  -->

	<!-- Start Errors Section -->

	<div class="the-errors text-center">
		<?php

		if (!empty($formErrors)) {
			foreach ($formErrors as $error) {
				echo '<div class="msg error">' . $error . '</div>';
			}
		}

		if (isset($successMsg)) {
			echo '<div class="msg success">' . $successMsg . '</div>';
		}

		?>
	</div>

	<!-- End Errors Section -->

</div>


<?php 
	include $tpl . 'footer.php';
?>