<?php 
session_start();
$pagetittele = 'login';
if(isset($_SESSION['user'])){
	header('Location: index.php');
}
include 'init.php';
//check if it post
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['login'])){
		$user=$_POST['username'];
		$pass=$_POST['password'];

		$stmt=$db->prepare("SELECT user_name password FROM users WHERE user_name=? AND password=?  ");
		$stmt->execute(array($user, $pass));
		$row=$stmt->fetch();
		$count=$stmt->rowCount();

		if($count>0){
			$_SESSION['user']=$user;
			$_SESSION['user_id']=$row['user_id'];
			header('Location: index.php'); // Redirect To Dashboard Page

				exit();
		}

	}
	else{
		$formErrors = array();

			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['password2'];
			$email 		= $_POST['email'];

			if(isset($_POST['username'])){
				$filteruser=filter_var($username,FILTER_SANITIZE_STRING);
				if(strlen($filteruser)<4){
					$formErrors[]="Username Must Be Larger Than 4 Characters";
				}
			}

			if(isset($_POST['password']) && isset($_POST['password2'])){
				if(empty( $password)){
					$formErrors[] ="Sorry Password Cant Be Empty";

				}
				if($password!== $password2){
					$formErrors[] = "Sorry Password Is Not Match";
				}

			}
			if (isset($_POST['email'])) {

				$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

				if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

					$formErrors[] = 'This Email Is Not Valid';

				}

			}
		if(empty($formErrors)){
			$check=checkitem('user_name','users',$user);
			if($check==1){
				$formErrors[] = 'Sorry This User Is Exists';
			}
			else{
				$stmt = $db->prepare("INSERT INTO 
											users(user_name, Password, email, red_stauts, Date)
										VALUES(:zuser, :zpass, :zmail, 0, now())");
					$stmt->execute(array(

						'zuser' => $username,
						'zpass' => $password,
						'zmail' => $email

					));

					// Echo Success Message

					$succesMsg = 'Congrats You Are Now Registerd User';
			}
		}

	}
}

?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> | 
		<span data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input 
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type your password" 
				required />
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input 
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input 
				minlength="3"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type a Complex password" 
				required />
		</div>
		<div class="input-container">
			<input 
				minlength="3"
				class="form-control" 
				type="password" 
				name="password2" 
				autocomplete="new-password"
				placeholder="Type a password again" 
				required />
		</div>
		<div class="input-container">
			<input 
				class="form-control" 
				type="email" 
				name="email" 
				placeholder="Type a Valid email" />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
	</form>
	<!-- End Signup Form -->
	<div class="the-errors text-center">
		<?php 

			if (!empty($formErrors)) {

				foreach ($formErrors as $error) {

					echo '<div class="msg error">' . $error . '</div>';

				}

			}

			if (isset($succesMsg)) {

				echo '<div class="msg success">' . $succesMsg . '</div>';

			}

		?>
	</div>
</div>
 <?php
 include $tbl.'footer.php';