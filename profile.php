<?php
   
    session_start(); 

    $pageTitle = 'Profile';

 	include 'init.php';

 	if ($_SESSION['user']) {

 	 	$getUser = $db->prepare('SELECT * FROM users WHERE Username = ?');
 	 	$getUser->execute(array($sessionUser));
 	 	$info = $getUser->fetch(PDO::FETCH_ASSOC);
        $userid = filter_var($info['UserID'], FILTER_SANITIZE_NUMBER_INT);
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
				<a href="#" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>

<div id="my-ads" class="ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
			<div class="panel-body">
				<?php
                $myItems = getAll("*", "items", "WHERE Member_ID={$userid}", "", "Item_ID");
				if (!empty($myItems)) {
					echo '<div class="row">';
					foreach ($myItems as $item) {
                        echo '<div class="col-sm6 col-md-3 ">';
						echo '<div class="thumbnail item-box">';
						if ($item['Approve'] == 0) { 
                            echo '<span class="approve-status">Waiting Approval</span>'; 
                        }
                        echo '<span class="price-tag">' . $item['Price'] . '</span>'; 
						echo '<img class="img-responive" src="image.jpeg" alt="iamge">';
						echo '<div class="caption">';
						echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] .'">' . $item['Name'] . '</a></h3>';
						echo '<p>' . $item['Description'] . '</p>';
                        echo '<div class="date">' .$item['Add_Date'] . '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';

					}
					echo '</div>';
				} else {
					echo 'Sorry there \'s no ads to show, creat <a href="newad.php">New Ad</a>';
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
					$comments = getAll("comment", "comments", "WHERE user_id={$userid}", "","c_id");

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