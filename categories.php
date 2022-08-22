<?php
$pagetittele = 'categories';
session_start();

include 'init.php';
?>
<div class="container">
	<h1 class="text-center">Show Category Items</h1>
	<div class="row">
		<?php
		if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
			$category = intval($_GET['pageid']);
			$allItems = getAllFrom("*", "items", "where cat_id = {$category}", "AND Approve = 1", "item_id");
			foreach ($allItems as $item) {

				
				echo  '<div class="card" style="width: 18rem;">';
				echo '<img src="img.png" class="card-img-top" alt="...">';
				echo '<div class="card-body">';
				echo "<h4 class='card-title'> ".$item['name'] ."</h4>";
				echo "<p class='card-text'>". $item['Description']." </p>";
				echo "<p class='card-text price-tag'>price: ". $item['price']."</p>";
				echo "<p class='card-text'>".  $item['Add_date']." </p>";
				echo '
				<a href="items.php?itemid='. $item['item_id'] .'" class="btn btn-primary">Go Item page</a>';
				echo '</div>';
				echo '</div>';
				/*
				echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' . $item['price'] . '</span>';
						echo '<img class="img-responsive" src="img.png" alt="" />';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='. $item['item_id'] .'">' . $item['name'] .'</a></h3>';
							echo '<p>' . $item['Description'] . '</p>';
							echo '<div class="date">' . $item['Add_date'] . '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				*/
			}
		} else {
			echo 'You Must Add Page ID';
		}
		?>
	</div>
</div>
<?php
include $tbl.'footer.php';?>