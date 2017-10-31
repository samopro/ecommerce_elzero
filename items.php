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
    <div class="row">
        <div class="col-md-3">
            User Image
        </div>
        <div class="col-md-9">
            User Comment
        </div>
    </div>
</div> 

<?php
 	
    } else {
        echo '<div class="alert alert-danger">There\'s no shuch id</div>'; 
    }

	include $tpl . 'footer.php';

?>