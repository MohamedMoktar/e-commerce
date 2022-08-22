<?php
session_start();
$pagetittele='members';

if(isset($_SESSION['username'])){
    
    include 'init.php';
	include $tbl.'footer.php';
    $do=isset($_GET['do'])?$_GET['do']:'manage';
    //start manage page
    if($do=='manage'){
		$query='';
		if(isset( $_GET['page'])&& $_GET['page']=='pending'){
			$query='AND red_stauts = 0';
		}
     //select
	 $stmt=$db->prepare("SELECT *FROM users WHERE group_id !=1 $query  ORDER BY user_id DESC");
	 $stmt->execute();
	 $rows=$stmt->fetchAll();
	 ?>
	
	 <h1 class="text-center">Manage Members</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registered Date</td>
							<td>Control</td>
						</tr>
					<?php
					foreach($rows as $row){
						echo "<tr>";
						    echo "<td>" . $row['user_id'] . "</td>";
							echo "<td>" . $row['user_name'] . "</td>";
							echo "<td>" . $row['email'] . "</td>";
							echo "<td>" . $row['full_name'] . "</td>";
							echo "<td>" .$row['Date'] . "</td>";

							
							echo "<td> <a href='members.php?do=Edit&userid=". $row['user_id'] ." 'class='btn btn-success'> Edit</a>
							 <a href='members.php?do=delete&userid=". $row['user_id'] ." 'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
							 if($row['red_stauts']==0){
								 echo "<a href='members.php?do=Activate&userid=". $row['user_id'] ." 'class='btn btn-info '><i class='fa fa-close'></i> Active </a>";

							 }
							echo "</td>";
								echo "</tr>";

					}	
					?>
						
					</table>
				</div>
				<a href="members.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Member
				</a>
			</div>

<?php
	


/********************************************************************************** */
	}elseif($do=='Add'){// Add Page ?>

		<h1 class="text-center">Add New Member</h1>
		<div class="container">
			<form class="form-horizontal" action="?do=Insert" method="POST">
				<!-- Start Username Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop" />
					</div>
				</div>
				<!-- End Username Field -->
				<!-- Start Password Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10 col-md-6">
						<input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password Must Be Hard & Complex" />
						<i class="show-pass fa fa-eye fa-2x"></i>
					</div>
				</div>
				<!-- End Password Field -->
				<!-- Start Email Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
					</div>
				</div>
				<!-- End Email Field -->
				<!-- Start Full Name Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
					</div>
				</div>
				<!-- End Full Name Field -->
				<!-- Start Submit Field -->
				<div class="form-group form-group-lg">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
					</div>
				</div>
				<!-- End Submit Field -->
			</form>
		</div>

<?php 
	

/************************************************************************ */

	}elseif($do=='Edit'){
        $userid=isset($_GET['userid'] )&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
        $stmt = $db->prepare("SELECT 
									*
								FROM 
									users 
								WHERE 
								user_id = ? 
								
								");

		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
        if($count>0){
            
        
        ?>
        <h1 class="text-center">Edit Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $userid?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control" value="<?php echo $row['user_name']?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row['password']?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
							</div>
						</div>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" value="<?php echo $row['email']?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full" value="<?php echo $row['full_name']?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
				<?php

        
    	}
	
    	else{
			echo "<div class='container'>";

			$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

			redirect_home($theMsg);

			echo "</div>";
       }
    
    
  
	

	
/****************************************************************************** */



	}elseif($do=='Update'){
    	echo'  <h1 class="text-center">Update Member</h1>';
		echo "<div class='container'>";

        if($_SERVER['REQUEST_METHOD']=='POST'){
        $id   =$_POST['userid'];
        $user =$_POST['username'];
        $email=$_POST['email'];
        $name =$_POST['full'];
        $pass=empty($_POST['newpassword'])? $pass=$_POST['oldpassword']:$pass=$_POST['newpassword'];
       //server side validate

	   $formErrors=array();

	    if (strlen($user)>20){
		$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
	   }

	    if(strlen($user)<4){
		$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
	   }

	    if (empty($user)) {
		$formErrors[] = 'Username Cant Be <strong>Empty</strong>';
	   }

		if (empty($name)) {
		$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
		}

		if (empty($email)) {
		$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
		}

	// Loop Into Errors Array And Echo It

		foreach($formErrors as $error) {
		echo '<div class="alert alert-danger">' . $error . '</div>';
		}

        //update in datbase
        if(empty($formErrors)){
			$stmt2=$db->prepare("SELECT * FROM users WHERE  user_name=? AND user_id!=? ");
            $stmt2->execute(array($user,$id  ));
			$count=$stmt2->rowCount();
			if($count>0){
				echo "this user is already Esixt";
			}		
			else{

			$stmt=$db->prepare("UPDATE users SET user_name=?, email =?, full_name=?,password=? WHERE user_id=?");
            $stmt->execute(array($user,$email,$name, $pass,$id  ));
            $mass="<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
			redirect_home($mass,'back');
			}
		}
        

   		 }
    	else{
          $errormsg='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
		  redirect_home(  $errormsg);
    	}
	echo "</div>";
	}
/*************************************************************************** */
	
	
	elseif($do=='Insert')
	{
	if($_SERVER['REQUEST_METHOD']=='POST'){
		echo'  <h1 class="text-center">Insert Member</h1>';
		echo "<div class='container'>";
		// Get Variables From The Form

		$user 	= $_POST['username'];
		$pass 	= $_POST['password'];
		$email 	= $_POST['email'];
		$name 	= $_POST['full'];
		// Validate The Form

		$formErrors = array();

		if (strlen($user) < 4) {
			$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
		}

		if (strlen($user) > 20) {
			$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
		}

		if (empty($user)) {
			$formErrors[] = 'Username Cant Be <strong>Empty</strong>';
		}

		if (empty($pass)) {
			$formErrors[] = 'Password Cant Be <strong>Empty</strong>';
		}

		if (empty($name)) {
			$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
		}

		if (empty($email)) {
			$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
		}

		// Loop Into Errors Array And Echo It

		foreach($formErrors as $error) {
			echo '<div class="alert alert-danger">' . $error . '</div>';
		}
		//insert
		if(empty($formErrors )){

			$check=checkitem("user_name","users",$user );
			if($check==1){
				$msg= '<div class="alert alert-danger">Sorry This User Is Exist</div>';
				redirect_home($msg,'back');
				
			}
			else{
				
				$stmt=$db->prepare("INSERT INTO users

				(user_name, password,email,full_name,red_stauts,Date)

				VALUES

				(:zuser_name ,:zpassword, :zemail ,:zfull_name,1,now())
				
				");
				$stmt->execute(array(
				'zuser_name'=>$user,
				'zpassword' => $pass,
				'zemail'    => $email,
				'zfull_name'=> $name));

				$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
				redirect_home($msg,'back');
			}
			
		}

	}
		else {
			$msg='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
			redirect_home(  $msg);
		
		}
	

		echo '</div>';
	}	
/************************************************************************** */

/*************************************************************************** */
	
	elseif($do=='delete'){
	
		echo "<h1 class='text-center'>Delete Member</h1>";
		echo "<div class='container'>";

		$userid=isset($_GET['userid'] )&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
			$stmt = $db->prepare("SELECT 
										*
									FROM 
										users 
									WHERE 
									user_id = ? 
									
									");

			$stmt->execute(array($userid));
			
			$count = $stmt->rowCount();
			if($count>0){

				$stmt = $db->prepare("DELETE 
				
			FROM 
				users 
			WHERE 
			user_id = :zuser
			
			");
			$stmt->bindParam(':zuser',$userid);
			$stmt->execute();
			/*
			$stmt->execute(array(
				'zuser'=>$userid,
			));
			*/
			$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
			redirect_home($msg ,'back');	

			}
			else{
				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

				redirect_home($theMsg);

			}

			echo '</div>';
	}
	

 /**************************************************************** */   
	elseif($do=='Activate')
	{
		echo "<h1 class='text-center'>Delete Member</h1>";
		echo "<div class='container'>";
		$userid=isset($_GET['userid'] )&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
		$check=checkItem('user_id', 'users',$userid);
			if($check>0){

				$stmt = $db->prepare("UPDATE 
 
			users 
			SET red_stauts=1	
			WHERE 
			user_id = :zuser
			
			");
			$stmt->bindParam(':zuser',$userid);
			$stmt->execute();
			
			$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';
			redirect_home($msg);	

			}
			else{
				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

				redirect_home($theMsg);

			}

			echo '</div>';
	}
	
	
	
		
}

else{
    header('location:index.php');
   
    exit();
}
?>