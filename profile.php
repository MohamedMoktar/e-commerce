<?php
session_start();
$pagetittele='profile';
include 'init.php';
if (isset($_SESSION['user'])) {
	$getUser = $db->prepare("SELECT * FROM users WHERE user_name = ?");
	$getUser->execute(array($sessionUser));
	$user_info = $getUser->fetch();
	$userid = $user_info['user_id'];
}
?>
	<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>Login Name</span> : <?php echo $user_info['user_name'] ?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span> : <?php echo $user_info['email'] ?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span> : <?php echo $user_info['full_name'] ?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Registered Date</span> : <?php echo $user_info['Date'] ?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Fav Category</span> :
					</li>
				</ul>
				<a href="#" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>
<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
			<div class="panel-body">
			Items
			<?php
				
				 $myItems = getAllFrom("*", "items", "where member_id = $userid", "", "Item_ID");
				 if (! empty($myItems)) {
					echo '<div class="row">';
					foreach ($myItems as $item) {
						echo '<div class="col-sm-6 col-md-3">';
							echo '<div class="thumbnail item-box">';
								if ($item['Approve'] == 0) { 
									echo '<span class="approve-status">Waiting Approval</span>'; 
								}
									echo  '<div class="card" style="width: 18rem;">';
									echo '<img src="img.png" class="card-img-top" alt="...">';
									echo '<div class="card-body">';
									echo "<h4 class='card-title' > ".$item['name'] ."</h4>";
									echo "<p class='card-text'>". $item['Description']." </p>";
									echo "<p class='card-text price-tag'>price: ". $item['price']."</p>";
									echo "<p class='card-text'>".  $item['Add_date']." </p>";
									echo '
									<a href="items.php?itemid='. $item['item_id'] .'" class="btn btn-primary">Go Item page</a>';
									echo '</div>';
									echo '</div>';
								/******************************************* */
								/*
								echo '<span class="price-tag">$' . $item['price'] . '</span>';
								echo '<img class="img-responsive" src="img.png" alt="" />';
								echo '<div class="caption">';
									echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
									echo '<p>' . $item['Description'] . '</p>';
									echo '<div class="date">' . $item['Add_Date'] . '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
								 */
					}
					echo '</div>';
				} else {
					echo 'Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>';
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
				comments
			<?php
				
				$myComments = getAllFrom("comment", "comments", "where user_id = $userid", "", "comment_id");
				if (! empty($myComments)) {
					foreach ($myComments as $comment) {
						echo '<p>' . $comment['comment'] . '</p>';
					}
				} else {
					echo 'There\'s No Comments to Show';
				}
				 
			?>
			</div>
		</div>
	</div>
</div>

	
	
	

<?php	include $tbl.'footer.php';
?>