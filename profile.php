<?php
   
    session_start(); 

    $pageTitle = 'Profile';

 	include 'init.php';

 	if ($_SESSION['user']) {

 	 	$getUser = $db->prepare('SELECT * FROM users WHERE Username = ?');
 	 	$getUser->execute(array($sessionUser));
 	 	$info = $getUser->fetch(PDO::FETCH_ASSOC);

?>
     
<h1 class="text-center">My Profile</h1>

<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw "></i>
						<span>Name:</span> <?php echo $info['Username'] ?> 		
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email:</span> <?php echo $info['Email'] ?> 		
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name:</span> <?php echo $info['FullName'] ?> 	
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Regiter Date:</span> <?php echo $info['Date'] ?> 	
					</li> 
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Ads</div>
			<div class="panel-body">
				<?php
				if (!empty(getItems('Member_ID', $info['UserID']))) {
					echo '<div class="row">';
					foreach (getItems('Member_ID ', $info['UserID']) as $item) {
						echo '<div class="col-sm6 col-md-3 ">';
						echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' . $item['Price'] . '</span>'; 
						echo '<img class="img-responive" src="image.jpeg" alt="iamge">';
						echo '<div class="caption">';
						echo '<h3>' . $item['Name'] . '</h3>';
						echo '<p>' . $item['Description'] . '</p>';
						echo '</div>';
						echo '</div>';
						echo '</div>';

					}
					echo '</div>';
				} else {
					echo 'Sorry there \'s no ads to show';
				}

				?>
			</div>
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comments</div>
			<div class="panel-body">
				<?php
					$stmt = $db->prepare('SELECT comment FROM comments WHERE user_id = ?');
					$stmt->execute(array($info['UserID']));
					$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (!empty($comments)) {

						foreach ($comments as $comment) {
						echo '<p>' . $comment['comment'] . '</p>';
						}

					} else {
						echo 'There\'s no comments to show'; 
					}
					
				?>
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