<?php // include '../functions/functions.php';?>
<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="UTF-8" />
	    
		<title><?php print_tittle(); ?></title>
		<link rel="stylesheet" href="layout/css/bootstrap.min.css" />
		<link rel="stylesheet" href="layout/css/bootstrap.css" />
		<link rel="stylesheet" href="layout/css/fontawesome.min.css" />
		<link rel="stylesheet" href="layout/css/front.css" />
	</head>
	<body>
	
	<div class="upper-bar">
	<div class="container">
		<?php 
				if (isset($_SESSION['user'])) { 
						echo "hallo ".$_SESSION['user'].' ';
						?><a href="profile.php">My Profile-</a>
						<a href="newad.php">New Item-</a>
						<a href="logout.php">Logout</a>
						<?php
						 $userstat=checkuserstatus($_SESSION['user']);
						if($userstat==1){
							//echo"not active";
						}
					
					?>
				
				<!--
					
				<img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php// echo $sessionUser ?>
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="profile.php">My Profile</a></li>
						<li><a href="newad.php">New Item</a></li>
						<li><a href="profile.php#my-ads">My Items</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
						-->
				<?php
					
					} else {
						?>
						
								<a href="login.php">
									<span class="pull-right">Login/Signup</span>
								</a>
								<?php }
					
				 ?>
		</div>
	</div>
    
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN')?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent" >
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-right" >
    <?php
	      	$allCats = getAllFrom("*", "categoeries", "","","id", "ASC");
			foreach ($allCats as $cat) {
				echo 
				"<li class='nav-item'>
					<a  class='nav-link' href='categories.php?pageid=" . $cat['id'] . "'>
						" . $cat['name'] . "
					</a>
				</li>";
			}
	      ?>
    
 
    </ul>
    
  </div>
</div>
</nav>