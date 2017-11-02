<!DOCTYPE html>
<html>
 <head>
 	<meta charset="utf-8">
 	<title><?php  getTitle() ?></title>
 	<!-- font awesome css -->
 	<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
 	<!-- Bootstrap css -->
 	<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
 	<!-- Backend CSS -->
 	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>front.css">
 </head>
 <body>
 	<div class="upper-bar">
 		<div class="container">
 			<?php
 				if (isset($_SESSION['user'])) { ?>
 				<img class="my-avatar img-circle img-thumbnail" src="image.jpeg" alt="profile-image">
 				<div class="btn-group my-info">
 				    <span class="btn dropdown-toggle" data-toggle="dropdown">
 				        <?php echo $sessionUser ?>
 				        <span class="caret"></span>
 				     </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newad.php">New Item</a></li>
                        <li><a href="profile.php#my-ads">My Items</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
 			    </div>	
 				<?php				
 				} else {		
 			?>
	 			<a href="login.php">
	 				<span class="pull-right">Login/Signup</span>
	 			</a>
	 		<?php } ?>
 		</div>
 	</div>
 	<nav class="navbar navbar-inverse">
 		<div class="container">
 			<div class="navbar-header">
 				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
 					<span class="sr-only">Toggle navigation</span>
 					<span class="icon-bar"></span>
 					<span class="icon-bar"></span>
 					<span class="icon-bar"></span>
 				</button>
 				<a class="navbar-brand" href="index.php">Home </a>
 			</div>
 			<div id="navbar" class="collapse navbar-collapse">
 				<ul class="nav navbar-nav navbar-right">
 					<?php
 					 	foreach (getAll('ID, Name', 'categories', 'WHERE parent=0', '', 'ID', 'ASC') as $cat) {
 					 		echo '<li>';
 					 			echo '<a href="categories.php?catid=' . $cat['ID'] . '">' . $cat['Name'] . '</a>';
 					 		echo '</li>';
 					 	}
 					?>
 				</ul> 
 			</div><!--/.nav-collapse -->
 		</div>
 	</nav>


  