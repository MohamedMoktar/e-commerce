<?php


session_start();

if(isset($_SESSION['username'])){
    $pagetittele='dashbord';
    include 'init.php';
	$numUsers = 6; // Number Of Latest Users

		$latestUsers = get_latest_items("*", "users", "user_id", $numUsers); // Latest Users Array

		$numItems = 6; // Number Of Latest Items

		$latestItems = get_latest_items("*", 'items', 'item_id', $numItems); // Latest Items Array

		$numComments = 4;
	
    //start page

    ?>

		<div class="home-stats">
			<div class="container text-center">
				<h1>Dashboard</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-users"></i>
							<div class="info">
								Total Members
								<span>
									<a href="members.php"><?php echo count_item('user_id', 'users') ?></a>
								</span>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								Pending Members
								<span>
									<a href="members.php?do=manage&page=pending">
                                       
                                    <?php echo checkItem("red_stauts", "users", 0) ?>
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php"><?php echo count_item('item_iD', 'items') ?></a>
									
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
									<a href="comments.php"><?php echo count_item('comment_id', 'comments') ?></a>
									
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
				<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> 
								Latest <?php echo $numUsers ?> Registerd Users 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							
							<div class="panel-body   " >
								<ul class="list-unstyled latest-users">
								<?php
									if (! empty($latestUsers)) {
										foreach ($latestUsers as $user) {
											
											echo '<li>';
												echo $user['user_name'];
												echo '<a href="members.php?do=Edit&userid=' . $user['user_id'] . '">';
													echo "<span class='btn btn-success pull-right' style='float:right'; >";
													
														echo '<i class="fa fa-edit" ></i> Edit';
														
														if ($user['red_stauts'] == 0) {
															echo "<a 
																	href='members.php?do=Activate&userid=" . $user['user_id'] . "' 
																	class='btn btn-info pull-right activate'
																	style='float:right;'>
																	<i class='fa fa-check'></i> Activate</a>";
														}
													echo '</span>';
													
												echo '</a>';
											echo '</li>';
										}
									} else {
										echo 'There\'s No Members To Show';
									}
								?>
								</ul>
							</div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest <?php echo $numItems ?> Items 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php
										if (! empty($latestItems)) {
											foreach ($latestItems as $item) {
												echo '<li>';
													echo $item['name'];
													echo '<a href="items.php?do=Edit&itemid=' . $item['item_id'] . '">';
														echo "<span class='btn btn-success pull-right ' style='float:right'>";
															echo '<i class="fa fa-edit"></i> Edit';
															if ($item['Approve'] == 0) {
																echo "<a 
																		href='items.php?do=Approve&itemid=" . $item['item_id'] . "' 
																		class='btn btn-info pull-right  activate'
																		style='float:right'>
																		<i class='fa fa-check'></i> Approve</a>";
															}
														echo '</span>';
													echo '</a>';
												echo '</li>';
											}
										} else {
											echo 'There\'s No Items To Show';
										}
									?>
								</ul>
							</div>
						</div>

					</div>
					<!-- Start Latest Comments -->
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> 
								Latest <?php echo $numComments ?> Comments 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$stmt = $db->prepare("SELECT 
																comments.*, users.user_name AS Member  
															FROM 
																comments
															INNER JOIN 
																users 
															ON 
																users.user_id = comments.user_id
															ORDER BY 
																comment_id DESC
															LIMIT $numComments");

									$stmt->execute();
									$comments = $stmt->fetchAll();

									if (! empty($comments)) {
										foreach ($comments as $comment) {
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
														' . $comment['Member'] . '</a></span>';
												echo '<p class="member-c">' . $comment['comment'] . '</p>';
											echo '</div>';
										}
									} else {
										echo 'There\'s No Comments To Show';
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End Latest Comments -->
				</div>
				
                    <?php
    //end page
  
    include 'footer.php';
  
}
else{
    header('location:index.php');
   
    exit();
}
?>