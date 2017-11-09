<?php 
    session_start();
    include 'init.php'; 
?>

<div class="container">
	<div class="row">
		<?php
		    if (isset($_GET['name'])) {
				$tag = $_GET['name'];
                echo '<h1 class="text-center">' . $tag . "</h1>";
				foreach (getAll("*", "items", "WHERE Tags LIKE '%$tag%'", " AND Approve=1", "Item_ID") as $item) {
					echo '<div class="col-sm6 col-md-3 ">';
						echo '<div class="thumbnail item-box">';
							echo '<span class="price-tag">' . $item['Price'] . '</span>'; 
							echo '<img class="img-responive" src="image.jpeg" alt="item-image">';
							echo '<div class="caption">';
								echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
								echo '<p>' . $item['Description'] . '</p>';
								echo '<div class="date">' .$item['Add_Date'] . '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			}
		?>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>

<!-- Les 124 -->