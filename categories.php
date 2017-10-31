<?php include 'init.php'; ?>

<div class="container">
	<h1 class="text-center">Show Catgory</h1>
	<div class="row">
		<?php
			foreach (getItems('Cat_ID ', $_GET['catid']) as $item) {
				echo '<div class="col-sm6 col-md-3 ">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' . $item['Price'] . '</span>'; 
						echo '<img class="img-responive" src="image.jpeg" alt="item-image">';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
							echo '<p>' . $item['Description'] . '</p>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		?>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>

<!-- Les 102 -->