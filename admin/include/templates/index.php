<?php
	session_start();
	$nonavbar='';
	$pagetittele='login';
	if(isset($_SESSION['username'])){
		header('location:dashbord.php');
	}
	
	include 'init.php';

	// Check If User Coming From HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		// Check If The User Exist In Database

		$stmt = $db->prepare("SELECT 
									user_id, user_name, password 
								FROM 
									users 
								WHERE 
								user_name = ? 
								AND 
								password = ? 
								AND 
								group_id = 1
								");

		$stmt->execute(array($username, $password));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		// If Count > 0 This Mean The Database Contain Record About This Username

		if ($count > 0) {
			$_SESSION['username']=$username;
			$_SESSION['id']  =$row['user_id'];
			header('location:dashbord.php');
			exit();

		}

	}

?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary " type="submit" value="Login" />
	</form>

<?php include  'footer.php'; ?>