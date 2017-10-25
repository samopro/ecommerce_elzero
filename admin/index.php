<?php
 session_start();
 $noNavbar = '';
 $pageTitle = 'Login';
 if (isset($_SESSION['Username'])) {
 	header('Location: dashboard.php'); // If session al ready exist, redirect direclty to Dashboard page
 } 
 include 'init.php';

// Check if user coming from HTTP request 
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	 $username = $_POST['user'];
 	 $password = $_POST['pass'];

 	 $hashedPass = sha1($password);

 	 // Check if the user exit in database
 	 $stmt = $db->prepare('SELECT userID, Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1');
 	 $stmt->execute(array($username, $hashedPass));
 	 $row = $stmt->fetch();
 	 $count = $stmt->rowCount();

 	 // If count > 0, this mean the database contain record about this username
 	 if ($count > 0) {
 	 	$_SESSION['Username'] = $username; // Register session name
 	 	$_SESSION['ID'] = $row['userID'];  // Register session ID
 	 	header('Location: dashboard.php'); // Redirect to Dashboard page
 	 	exit();	
 	 } 
 }

?>
    
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="Login">
	</form>
 
<?php 
	include $tpl . 'footer.php';
?>