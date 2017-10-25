<?php include 'init.php'; ?>

<div class="container">
	<h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['catname']) ?></h1>
	<div class="row">
		<?php
			foreach (getItems('Cat_ID ', $_GET['catid']) as $item) {
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
		?>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>

<!-- Les 84 -->