<?php

	/*
	================================================
	== Items Page
	================================================
	*/



	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
          //select
	 $stmt=$db->prepare("SELECT 
	 items.*, 
	 categoeries.name AS category_name, 
	 users.user_name 
 FROM 
	 items
 INNER JOIN 
 	 categoeries
 ON 
     categoeries.id = items.cat_id  
 INNER JOIN 
	 users 
 ON 
	 users.user_id = items.member_id
ORDER BY item_id DESC	 
");
	 $stmt->execute();
	 $rows=$stmt->fetchAll();
	 ?>
	
	 <h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Price</td>
							<td>Description</td>
							<td>Add Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
					<?php
					foreach($rows as $row){
						echo "<tr>";
						    echo "<td>" . $row['item_id'] . "</td>";
							echo "<td>" . $row['name'] . "</td>";
							echo "<td>" . $row['price'] . "</td>";
							echo "<td>" . $row['Description'] . "</td>";
							echo "<td>" .$row['Add_date'] . "</td>";
							echo "<td>" .$row['category_name'] . "</td>";
							echo "<td>" .$row['user_name'] . "</td>";

							
							echo "<td> <a href='items.php?do=Edit&itemid=". $row['item_id'] ." 'class='btn btn-success'> Edit</a>
							 <a href='items.php?do=Delete&itemid=". $row['item_id'] ." 'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
							 if ($row['Approve'] == 0) {
								echo "<a 
										href='items.php?do=Approve&itemid=" . $row['item_id'] . "' 
										class='btn btn-info activate'>
										<i class='fa fa-check'></i> Approve</a>";
							}
							echo "</td>";
								echo "</tr>";

					}	
					?>
						
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Item
				</a>
			</div>

<?php

		} elseif ($do == 'Add') {
            ?>

			<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="Name of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="Description of The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="Price of The Item" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="country" 
								class="form-control" 
								required="required" 
								placeholder="Country of Made" />
						</div>
					</div>
					<!-- End Country Field -->
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status" class="form-control">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
                    <!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
								<?php
                                    $stmt=$db->prepare("SELECT * FROM users");
                                    $stmt->execute();
									$allMembers = $stmt->fetchAll();
									foreach ($allMembers as $user) {
										echo "<option value='" . $user['user_id'] . "'>" . $user['user_name'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
								<?php
                                 $stmt=$db->prepare("SELECT * FROM categoeries");
                                    $stmt->execute();
								 
									$allCats = $stmt->fetchAll();
									foreach ($allCats as $cat) {
										echo "<option value='" . $cat['id'] . "'>" . $cat['name'] . "</option>";
										
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
                    	<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>
                    <?php

/*********************************************************************************** */
		} elseif ($do == 'Insert') {
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo "<h1 class='text-center'>Insert Item</h1>";
				echo "<div class='container'>";
                	// Get Variables From The Form
                $name     =$_POST['name'];
                $desc     =$_POST['description'];
                $price    =$_POST['price'];
                $country  =$_POST['country'];
                $status   =$_POST['status'];
                $member   = $_POST['member'];
                $cat      = $_POST['category'];
				

                $formerror=array();

                if (empty($name)) {
					$formErrors[] = 'Name Cant be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Cant be <strong>Empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price Cant be <strong>Empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country Cant be <strong>Empty</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}

                foreach( $formerror as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                
				if ($member == 0) {
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}
 
                if(empty($formerror)){
                   $stmt=$db->prepare("INSERT INTO items (name,Description,price,country_made,status ,Add_date, cat_id, member_id )
                   VALUES
                   (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)
                   ") ;
                   $stmt->execute(array(
                        'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zprice' 	=> $price,
						'zcountry' 	=> $country,
						'zstatus' 	=> $status,
                        'zcat'		=> $cat,
						'zmember'	=> $member,

                   ));
                   $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

                   redirect_home($theMsg, 'back');

                } 



			

            }
            else{
                echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirect_home($theMsg);

				echo "</div>";


            }

/*********************************************************************************** */
		} elseif ($do == 'Edit') {
			$itemid=isset($_GET['itemid'])&& is_numeric( $_GET['itemid'])?intval($_GET['itemid']):0;
			$stmt=$db->prepare("SELECT * FROM items WHERE item_id=?");
			$stmt->execute(array($itemid));
			$item = $stmt->fetch();
			$count=$stmt->rowCount();
			

			if($count>0){
				?>
				<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="name" 
									class="form-control" 
									required="required"  
									placeholder="Name of The Item"
									value="<?php echo $item['name'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="description" 
									class="form-control" 
									required="required"  
									placeholder="Description of The Item"
									value="<?php echo $item['Description'] ?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="price" 
									class="form-control" 
									required="required" 
									placeholder="Price of The Item"
									value="<?php echo $item['price'] ?>" />
							</div>
						</div>
						<!-- End Price Field -->
						<!-- Start Country Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="country" 
									class="form-control" 
									required="required" 
									placeholder="Country of Made"
									value="<?php echo $item['country_made'] ?>" />
							</div>
						</div>
						<!-- End Country Field -->
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status" class="form-control">
									<option value="1" <?php if ($item['status'] == 1) { echo 'selected'; } ?>>New</option>
									<option value="2" <?php if ($item['status'] == 2) { echo 'selected'; } ?>>Like New</option>
									<option value="3" <?php if ($item['status'] == 3) { echo 'selected'; } ?>>Used</option>
									<option value="4" <?php if ($item['status'] == 4) { echo 'selected'; } ?>>Very Old</option>
								</select>
							</div>
						</div>
						<!-- End Status Field -->
						<!-- Start Members Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select name="member" class="form-control">
									<?php
										$stmt=$db->prepare("SELECT * FROM users ");
										$stmt->execute();
										$allMembers = $stmt->fetchAll();
										foreach ($allMembers as $user) {
											echo "<option value='" . $user['user_id'] . "'"; 
											if ($item['member_id'] == $user['user_id']) { echo 'selected'; } 
											echo ">" . $user['user_name'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Members Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10 col-md-6">
								<select name="category" class="form-control">
									<?php
										$stmt=$db->prepare("SELECT * FROM categoeries ");
										$stmt->execute();
										$allCats = $stmt->fetchAll();
										foreach ($allCats as $cat) {
											echo "<option value='" . $cat['id'] . "'";
											if ($item['cat_id'] == $cat['id']) { echo ' selected'; }
											echo ">" . $cat['name'] . "</option>";
											
											
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Categories Field -->
						


			
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-primary btn-sm " />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
						<?php

					// Select All Users Except Admin 

					$stmt = $db->prepare("SELECT 
												comments.*, users.user_name AS Member  
											FROM 
												comments
											INNER JOIN 
												users 
											ON 
												users.user_id = comments.user_id
											WHERE item_id = ?");

					// Execute The Statement

					$stmt->execute(array($itemid));

					// Assign To Variable 

					$rows = $stmt->fetchAll();

					if (! empty($rows)) {
						
					?>
					<h1 class="text-center">Manage [ <?php echo $item['name'] ?> ] Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['comment_date'] ."</td>";
										echo "<td>
											<a href='comments.php?do=Edit&comid=" . $row['comment_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href='comments.php?do=Delete&comid=" . $row['comment_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
											if ($row['status'] == 0) {
												echo "<a href='comments.php?do=Approve&comid="
														 . $row['comment_id'] . "' 
														class='btn btn-info activate'>
														<i class='fa fa-check'></i> Approve</a>";
											}
										echo "</td>";
									echo "</tr>";
								}
							?>
							<tr>
						</table>
					</div>
					<?php } 
				

            
			 // If There's No Such ID Show Error Message
			}
			else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirect_home($theMsg);

				echo "</div>";

			}


		} elseif ($do == 'Update') {
			if($_SERVER['REQUEST_METHOD']=='POST'){
				echo "<h1 class='text-center'>Update Item</h1>";
				echo "<div class='container'>";
                	// Get Variables From The Form
				$id 		= $_POST['itemid'];
                $name     =$_POST['name'];
                $desc     =$_POST['description'];
                $price    =$_POST['price'];
                $country  =$_POST['country'];
                $status   =$_POST['status'];
                $member   = $_POST['member'];
                $cat      = $_POST['category'];
				

                $formerror=array();

                if (empty($name)) {
					$formErrors[] = 'Name Cant be <strong>Empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description Cant be <strong>Empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price Cant be <strong>Empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country Cant be <strong>Empty</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}

                foreach( $formerror as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                
				if ($member == 0) {
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}
          
				if (empty($formErrors)) {

					// Update The Database With This Info

					$stmt = $db->prepare("UPDATE 
												items 
											SET 
												name = ?, 
												Description = ?, 
												price = ?, 
												country_made = ?,
												status = ?,
												cat_id  = ?,
												member_id = ?
												
											WHERE 
												item_id = ?");

					$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirect_home($theMsg, 'back');

				}

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirect_home($theMsg);

			}

			echo "</div>";


		} 
		elseif ($do == 'Delete') {
			echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkitem('item_id', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $db->prepare("DELETE FROM items WHERE item_id = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirect_home($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirect_home($theMsg);

				}

			echo '</div>';



		} 
		elseif ($do == 'Approve') {
			echo "<h1 class='text-center'>Approve Item</h1>";
			echo "<div class='container'>";
			$itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?$_GET['itemid']:0;
			$check=checkitem('item_id','items',$itemid);
			if($check>0){
				
				$stmt = $db->prepare("UPDATE items SET Approve = 1 WHERE item_id = ?");

				$stmt->execute(array($itemid));

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirect_home($theMsg, 'back');

			} else {

				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

				redirect_home($theMsg);

			}

		echo '</div>';
			



		}

		include $tbl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	

?>