<?php
session_start();
$pagetittele='categories';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do=isset($_GET['do'])?$_GET['do']:'manage';
  
    if ($do == 'manage') {

        $sort='Asc';
        $sort_array=array('Desc','Asc');

        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort=$_GET['sort'];
        }

        $stmt2=$db->prepare("SELECT * FROM categoeries ORDER BY ordering $sort");
        $stmt2->execute();
        $cats= $stmt2->fetchAll();

        ?>
        <h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> Manage Categories
						<div class="option pull-right" style='float:right;'>
							<i class="fa fa-sort"></i> Ordering: [
							<a class="<?php if ($sort == 'Asc') { echo 'active'; } ?>" href="?sort=Asc">Asc</a> | 
							<a class="<?php if ($sort == 'Desc') { echo 'active'; } ?>" href="?sort=Desc">Desc</a> ]
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Full</span> |
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						<?php
							foreach($cats as $cat) {
								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='categories.php?do=Edit&catid=" . $cat['id'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
										echo "<a href='categories.php?do=Delete&catid=" . $cat['id'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
									echo "</div>";
									echo "<h3>" . $cat['name'] . '</h3>';
									echo "<div class='full-view'>";
										echo "<p>"; if($cat['describtion'] == '') { echo 'This category has no description'; } else { echo $cat['describtion']; } echo "</p>";
										if($cat['visabilty'] == 1) { echo '<span class="visibility cat-span"><i class="fa fa-eye"></i> Hidden</span>'; } 
										if($cat['allow_comment'] == 1) { echo '<span class="commenting cat-span"><i class="fa fa-close"></i> Comment Disabled</span>'; }
										if($cat['allow_ads'] == 1) { echo '<span class="advertises cat-span"><i class="fa fa-close"></i> Ads Disabled</span>'; }  
									echo "</div>";

									// Get Child Categories
							      	/*
                                    $childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID", "ASC");
							      	if (! empty($childCats)) {
								      	echo "<h4 class='child-head'>Child Categories</h4>";
								      	echo "<ul class='list-unstyled child-cats'>";
										foreach ($childCats as $c) {
											echo "<li class='child-link'>
												<a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>" . $c['Name'] . "</a>
												<a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'> Delete</a>
											</li>";
										}
										echo "</ul>";
									}
                                    */ 

								echo "</div>";
								echo "<hr>";
							}
						?>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
			</div>

			<?php 
            /*
            } else {

				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Categories To Show</div>';
					echo '<a href="categories.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Category
						</a>';
				echo '</div>';

			}
            */
             ?>

			<?php
        
/** * ** ** * * * *  ************************************************************************** */
    } elseif ($do == 'Add') {
        ?>

			<h1 class="text-center">Add New Category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" placeholder="Describe The Category" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- Start Category Type -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Parent?</label>
						<div class="col-sm-10 col-md-6">
							<select name="parent">
								<option value="0">None</option>
								<?php 
									/*$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
									foreach($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									} */
								?>
							</select>
						</div>
					</div>
					<!-- End Category Type -->
					<!-- Start Visibility Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" checked />
								<label for="vis-yes">Yes</label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1" />
								<label for="vis-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Visibility Field -->
					<!-- Start Commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked />
								<label for="com-yes">Yes</label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" />
								<label for="com-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Ads Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
                        </div>
					<!-- End Submit Field -->
				</form>
			</div>

			<?php


/** * ** ** * * * *  ************************************************************************** */

    } elseif ($do == 'Insert') {
        echo'  <h1 class="text-center">Insert Category</h1>';
		echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $name 	    = $_POST['name'];
            $desc 	    = $_POST['description'];
            $order 	    = $_POST['ordering'];
            $visible 	= $_POST['visibility'];
            $comment 	= $_POST['commenting'];
            $ads 	    = $_POST['ads'];
            $check=checkitem('name','categoeries',$name);
            if($check==1){
                $msg= '<div class="alert alert-danger">Sorry This category Is Exist</div>';
				redirect_home($msg,'back');
            }
            else{
                $stmt = $db->prepare("INSERT INTO 

                categoeries(name, describtion, ordering, visabilty, allow_comment, 	allow_ads)

					VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");

					$stmt->execute(array(
						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zorder' 	=> $order,
						'zvisible' 	=> $visible,
						'zcomment' 	=> $comment,
						'zads'		=> $ads
					));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' category Inserted</div>';

					redirect_home($theMsg, 'back');
            }


        }
        else{
            $msg='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
			redirect_home(  $msg);
        }
        echo '</div>';

/** * ** ** * * * *  ************************************************************************** */
    } elseif ($do == 'Edit') {
    	$catid=isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;
		$stmt=$db->prepare("SELECT * FROM  categoeries WHERE id =?");
		$stmt->execute(array($catid));
		$cat=$stmt->fetch();
		$count=$stmt->rowCount();

		if($count>0){
			?>
            <h1 class="text-center">Edit Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Category" value="<?php echo $cat['name'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?php echo $cat['describtion'] ?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Ordering Field -->

			<div class="form-group form-group-lg">
			<label class="col-sm-2 control-label">Ordering</label>
			<div class="col-sm-10 col-md-6">
				<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="<?php echo $cat['ordering'] ?>" />
			</div>
		</div>
		<!-- End Ordering Field -->
		<!-- Start Category Type 
		<div class="form-group form-group-lg">
			<label class="col-sm-2 control-label">Parent?</label>
			<div class="col-sm-10 col-md-6">
				<select name="parent">
					<option value="0">None</option>
					<?php 
						/*
						$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
						foreach($allCats as $c) {
							echo "<option value='" . $c['ID'] . "'";
							if ($cat['parent'] == $c['ID']) { echo ' selected'; }
							echo ">" . $c['Name'] . "</option>";
						}
						*/
					?>
				</select>
			</div>
		</div>
		-->
		<!-- End Category Type -->
		<!-- Start Visibility Field -->
		<div class="form-group form-group-lg">
			<label class="col-sm-2 control-label">Visible</label>
			<div class="col-sm-10 col-md-6">
				<div>
					<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['visabilty'] == 0) { echo 'checked'; } ?> />
					<label for="vis-yes">Yes</label> 
				</div>
				<div>
					<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['visabilty'] == 1) { echo 'checked'; } ?> />
					<label for="vis-no">No</label> 
				</div>
			</div>
		</div>
		<!-- End Visibility Field -->
		<!-- Start Commenting Field -->
		<div class="form-group form-group-lg">
			<label class="col-sm-2 control-label">Allow Commenting</label>
			<div class="col-sm-10 col-md-6">
				<div>
					<input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['allow_comment'] == 0) { echo 'checked'; } ?> />
					<label for="com-yes">Yes</label> 
				</div>
				<div>
					<input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['allow_comment'] == 1) { echo 'checked'; } ?> />
					<label for="com-no">No</label> 
				</div>
			</div>
		</div>
		<!-- End Commenting Field -->
		<!-- Start Ads Field -->
		<div class="form-group form-group-lg">
			<label class="col-sm-2 control-label">Allow Ads</label>
			<div class="col-sm-10 col-md-6">
				<div>
					<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['allow_ads'] == 0) { echo 'checked'; } ?>/>
					<label for="ads-yes">Yes</label> 
				</div>
				<div>
					<input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['allow_ads'] == 1) { echo 'checked'; } ?>/>
					<label for="ads-no">No</label> 
				</div>
			</div>
		</div>
		<!-- End Ads Field -->
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

// If There's No Such ID Show Error Message

} else {

echo "<div class='container'>";

$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

redirect_home($theMsg);

echo "</div>";

}
		

/*************************************************************************************** */		
	

    } elseif ($do == 'Update') {
		echo'  <h1 class="text-center">Update Category</h1>';
		echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='POST'){

			$id 		= $_POST['catid'];
            $name 	    = $_POST['name'];
            $desc 	    = $_POST['description'];
            $order 	    = $_POST['ordering'];
            $visible 	= $_POST['visibility'];
            $comment 	= $_POST['commenting'];
            $ads 	    = $_POST['ads'];

		    $stmt=$db->prepare("UPDATE categoeries 
								SET 
									name =?, 
									describtion =?, 
									ordering=?,
									visabilty=?,
									allow_comment=?,
									allow_ads=?
								WHERE
								     id =?");					  
									
           $stmt->execute(array($name, $desc, $order,  $visible, $comment, $ads, $id));

			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

			redirect_home($theMsg, 'back');


		}

		else{
            $msg='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
			redirect_home(  $msg);
        }
        echo '</div>';
/*************************************************************************************************** */

    } elseif ($do == 'Delete') {
		echo "<h1 class='text-center'>Delete category</h1>";
		echo "<div class='container'>";

		$catid=isset($_GET['catid'] )&& is_numeric($_GET['catid'])?intval($_GET['catid']):0;
			$stmt = $db->prepare("SELECT 
										*
									FROM 
										categoeries 
									WHERE 
									id = ? 
									
									");

			$stmt->execute(array($catid));
			
			$count = $stmt->rowCount();
			if($count>0){

				$stmt = $db->prepare("DELETE 
				
			FROM 
				categoeries 
			WHERE 
			id = :zuser
			
			");
			$stmt->bindParam(':zuser',$catid);
			$stmt->execute();
			/*
			$stmt->execute(array(
				'zuser'=>$userid,
			));
			*/
			$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
			redirect_home($msg,'back');	

			}
			else{
				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

				redirect_home($theMsg);

			}

			echo '</div>';

    }
    

    include $tbl.'footer.php';
}
else{
    header('location:index.php');
    exit();
}
?>