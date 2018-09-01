<?php 
	$page			= 'profile';
	include('./includes/header.php'); 
	$user_id 		= $_SESSION['id'];
	$query 			= "SELECT * FROM accounts WHERE id='$user_id'";
	$result 		= mysqli_query($conn,$query);
	$row 			= mysqli_fetch_assoc($result);
	$image_account	= $row['image'];
	if (isset($_POST['update'])) {
		$file_type		= $_FILES['account_image']['type'];
		if ($file_type == 'image/jpeg' || $file_type == 'image/png' || $file_type == 'image/gif' ) {
			$dir 			= 'storage/image_accounts/';
			$file_uploaded	= $_FILES['account_image']['name'];
			$file_dir		= $dir.$file_uploaded;
			if (file_exists($file_dir)) {
				$errer	= "File exist";
			} else { 
				move_uploaded_file($_FILES['account_image']['tmp_name'], $file_dir);
				$query			= "UPDATE accounts SET image='$file_dir' WHERE id ='$user_id'";
				mysqli_query($conn,$query);
				$image_account 	= $file_dir;
			}

		} else die('Something went wrong!');
	}

?>
	<br>
	<div class="well container">
		<form action="changeAccountImage.php?user_id=<?php echo $user_id; ?>" 
			method="post" enctype="multipart/form-data">
			<img src="<?php echo $image_account; ?>" width="150px" height="150px" 
				class="center-block" style="border-radius: 200px" >
				<hr>
			<input type="file" name="account_image" class="btn btn-default pull-left" 
				<?php if ($mobile) echo 'style="width: 70%"'; ?>>
			<input type="submit" name="update" value="Update" class="btn btn-primary" style="margin-left: 10px"><br><br>
			<a href="profile.php" style="padding-left: <?php if ($mobile) echo '175px'; else echo '220px'; ?>">Go Back</a>
		</form>
	</div>

<?php include('./includes/footer.php'); ?>