<?php
 session_start();

 if (isset($_SESSION['Username'])) {

 	$pageTitle = 'Dashboard';

 	include 'init.php';

 	$numUsers = 5;
 	$latestUsers = getLatest('*','users', 'UserID', $numUsers);

 	$numItems = 5;
 	$latestItems = getLatest('*', 'items', 'Add_Date', $numItems);

 	$nuComments = 5;

 	/* Start Dashboard Page	*/

 	?>
 	<div class="home-stats">
 		<div class="container text-center">
 			<h1>Dahboard</h1>
 			<div class="row">
 				<div class="col-md-3">
 					<div class="stat st-members">
 						<i class="fa fa-users"></i>
 						<div class="info">
 							Total Members
 							<span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
 						</div>
 					</div>
 				</div>
 				<div class="col-md-3">
 					<div class="stat st-pending">
 						<i class="fa fa-user-plus"></i>
 						<div class="info">
 							Pending Members
	 						<span><a href="members.php?do=Manage&page=Pending">
	 							<?php echo checkItem('RegStatus', 'users', '0') ?>
	 						</a></span>
 						</div>
 					</div>
 				</div>
 				<div class="col-md-3">
 					<div class="stat st-items">
 						<i class="fa fa-tags"></i>
 						<div class="info">
 							Total Items
 							<span>
 								<a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a>
 							</span>
 						</div>
 					</div>
 				</div>
 				<div class="col-md-3">
 					<div class="stat st-comments">
 						<i class="fa fa-comments"></i>
 						<div class="info">
 							Total Comments
 							<span>
 								<a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a>
 							</span>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
	
    <div class="latest">
    	<div class="container">
			<div class="row">
				<!-- Start Latest Registerd Users -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Registerd Users
							<span class="toggle-info pull-right">
								<i class="fa fa-minus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
								<?php
								foreach ($latestUsers as $user) {
									echo '<li>';
									echo  $user['Username'] . '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '"><span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</span></a>';
									if ($user['RegStatus'] == 0) { // Show Not Registerd Users
 				 	 				echo '<a href="members.php?do=Activate&userid=' . $user['UserID'] . '"><span class="btn btn-warning pull-right"><i class="fa fa-check"></i>Activate</span></a>';
 				 	 				}
									echo '</li>';
								}
							?> 
							</ul>
						</div>
					</div>
				</div>
				<!-- End Latest Registerd Users -->

				<!-- Start Latest Items -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tags"></i> Latest <?php echo $numItems ?> Items
							<span class="toggle-info pull-right">
								<i class="fa fa-minus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="liscommentst-unstyled latest-users">
								<?php
								foreach ($latestItems as $item) {
									echo '<li>';
									echo  $item['Name'] . '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '"><span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</span></a>';
									if ($item['Approve'] == 0) { // Show Not Approved Items
 				 	 				echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '"> <span class="btn btn-info pull-right"><i class="fa fa-check"></i>Activate</span></a>';
 				 	 				}
									echo '</li>';
								}
							?> 
							</ul>
						</div>
					</div>
				</div>
				<!-- End Latest Items -->
			</div>
	    </div>
    </div>

     <div class="latest">
    	<div class="container">
			<div class="row">
				<!-- Start Latest Comments -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments-o"></i> Latest <?php echo $nuComments  ?> Comments
							<span class="toggle-info pull-right">
								<i class="fa fa-minus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<?php

								$stmt = $db->prepare("SELECT 
 										comments.*, users.Username AS commenter
 								  FROM 
 								  		comments
 								  INNER JOIN users ON comments.user_id = users.UserID
 								  ORDER BY c_id DESC
 								  LIMIT $nuComments
 								");
					 			$stmt->execute();
					 			$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

					 			foreach ($comments as $comment) {
					 				echo '<div class="comment-box">';
						 				echo '<span class="member-n">' . $comment['commenter'] . '</span>'; 
						 				echo '<div class="member-c">';
						 				echo  '<p>' . $comment['comment'] . '</p>';
						 					echo '<div class="com-control pull-right">';
								 				echo '<a href="comments.php?do=Edit&comid=' . $comment['c_id'] . '"><span class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</span></a>';
								 				echo '<a href="comments.php?do=Delete&comid=' . $comment['c_id'] . '"><span class="btn btn-danger btn-sm confirm"><i class="fa fa-trash-o"></i>Delete</span></a>';
								 				if ($comment['status'] == 0) {
								 					echo '<a href="comments.php?do=Approve&comid=' . $comment['c_id'] . '"><span class="btn btn-info btn-sm"><i class="fa fa-check"></i>Approve</span></a>';
								 				}
								 			echo '</div>'; //end com-control
						 				echo '</div>'; 
					 				echo '</div>';
					 			}
							?>
						</div>
					</div>
				</div>
				<!-- End Latest Comments -->
			</div>
	    </div>
    </div>

 	<?php

 	/* End Dashboard Page	*/

 	include $tpl . 'footer.php';

 } else {

 	header('Location: index.php');
 	exit();
 }