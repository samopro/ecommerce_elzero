<?php
   
    session_start(); 

    $pageTitle = 'Show Items';

 	include 'init.php';


    
    // Check if get request item is numeric & get its integer value
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
    // Select Item depende on itemid
    $stmt = $db->prepare('SELECT items.*, categories.Name AS cat_name, users.Username
                          FROM
                            items
                          INNER JOIN categories ON items.Cat_ID = categories.ID
                          INNER JOIN users ON items.Member_ID = users.UserID
                          WHERE
                            Item_ID = ?');
    $stmt->execute(array($itemid));
       
    if ($stmt->rowCount() > 0) {
        
       $item = $stmt->fetch(PDO::FETCH_ASSOC);
?>
     
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="img-responive img-thumbnail center-block" src="image.jpeg" alt="item-image">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span>Added Date: </span><?php echo $item['Add_Date'] ?></li>
                <li>
                    <i class="fa fa-usd fa-fw"></i>
                    <span>Price:</span> <?php echo $item['Price'] ?>
                </li>
                <li>
                    <i class="fa fa-globe fa-fw"></i>
                    <span>Made In:</span> <?php echo $item['Country_Made'] ?>
                </li>
                <li>
                    <i class="fa fa-tag fa-fw"></i>
                    <span>Category:</span><a href="categories.php?catid=<?php echo $item['Cat_ID'] ?>"><?php  echo $item['cat_name'] ?></a> 
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>Added By:</span><a href="#"><?php  echo $item['Username']  ?></a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    <?php if (isset($_SESSION['user'])) { ?>
    <!--  Start Add Comment Section  -->
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comment">
                <h3>Add You Comment</h3>
                <form action="<?php $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                    <textarea name="comment"></textarea>
                    <input class="btn btn-primary" type="submit" value="Add Comment">
                </form>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
                        $comment =  filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                        $userid  = $_SESSION['uid'];
                        $itemid  = $item['Item_ID'];
                        
                        if (!empty($comment)) {
                            $stmt = $db->prepare('INSERT INTO comments (comment, comment_date, item_id, user_id)
                                                 VALUES (:comment, CURDATE(), :itemid, :userid)');
                            $stmt->execute(array(
                                                 'comment' => $comment,
                                                 'itemid' => $itemid,
                                                 'userid' => $userid
                                                ));
                            if ($stmt) {
                                echo '<div class="alert alert-success">Comment Added</div>';
                            }
                            
                        } else {
                            echo '<div class="alert alert-danger"></div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php } else {
             echo '<a href="login.php">Login</a> or <a href="login.php">register</a> to add comment';  
          }
    ?>
    <!--  End Add Comment Section  -->
    <hr class="custom-hr">
    <?php
        $stmt2 = $db->prepare('SELECT comments.*, users.Username
                               FROM comments
                               INNER JOIN users ON users.UserID = comments.user_id
                               WHERE comments.item_id = ? AND status = 1
                               ORDER BY c_id DESC');
                
        $stmt2->execute(array($itemid));
        $comments = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($comments as $comment) {
            echo '<div class="comment-box">';
                echo '<div class="row">';
                    echo '<div class="col-md-2 text-center">';
                        echo '<img class="img-responive img-thumbnail img-circle center-block" src="image.jpeg" alt="user-image">';
                        echo $comment['Username'];
                    echo '</div>';
                    echo '<div class="col-md-10">';
                        echo '<p class="lead">' . $comment['comment'] . '</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<hr class="custom-hr">';
        }
        
    ?>
</div> 

<?php
 	
    } else {
        echo '<div class="alert alert-danger">There\'s no shuch id</div>'; 
    }

	include $tpl . 'footer.php';

?>