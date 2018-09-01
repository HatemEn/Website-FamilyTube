<?php 

	$page = "login";
	include('./includes/header.php');
	if (isset($_GET['watch'])) $video_id = $_GET['watch'];
	
	if (isset($_POST['login'])) {
		$username 			= strip_tags($_POST['username']);
		$enteredPassword 	= strip_tags($_POST['password']);
		/// check if the username is exist ///
		$query 	= "SELECT * FROM accounts WHERE username = '$username' OR email = '$username'";
		$check_username_email	= mysqli_query($conn,$query);
		if ($check_username_email->num_rows > 0) {
			/// Encrypt the password ///
			$salt1		= 'future';
			$salt1		= md5($salt1);
			$salt2		= 'of';
			$salt2		= md5($salt2);
			$salt3		= 'world';
			$salt3		= md5($salt3);
			$password 	= $salt2.$enteredPassword.$salt3;
			$password 	= md5($password.$salt1);
			/// check the password ///
			$row = mysqli_fetch_assoc($check_username_email);
			if ($password == $row['password']) {
				$_SESSION['id']			= $row['id'];
				$_SESSION['firstname']	= $row['firstname'];
				$_SESSION['lastname']	= $row['lastname'];
				$_SESSION['username']	= $row['username'];
				$_SESSION['email']		= $row['email'];
				$_SESSION['password']	= $row['password'];
				$_SESSION['dob']		= $row['dob'];
				$_SESSION['image']		= $row['image'];
				$_SESSION['locked']		= $row['locked'];

				if (!empty($video_id)) {
					header('location: watch.php?video_id='.$video_id);
				} else header('location: profile.php');		
			} else $errer	= 'password';
			
		} else $errer	= 'username';
	}
?>
	<br>
	<div class="container well">
		<form action="<?php if (!empty($video_id)) echo 'login.php?watch='.$video_id; else echo 'login.php'; ?>" method="POST" class="form-group">
			<div class="col-sm-5">
				<h4 class="text-primary text-center">Enter To Your Account Very Easy</h4><hr>
				
				<input type="text" name="username" placeholder="Username/Email..." onblur="placeholder='Username/Email...'"
					 onfocus="placeholder=''" class="form-control <?php if($errer == 'username') echo 'alert-danger'; ?>">
				<hr style="margin: 8px 0">
				<input type="password" name="password" placeholder="Password..." onblur="placeholder='Password...'"
					 onfocus="placeholder=''" class="form-control <?php if($errer == 'password') echo 'alert-danger'; ?>">
					 <p style="font-size: 12px; padding: 4px 0" class="pull-right">
					 	<a href="changePassword.php">Forget Your Password</a> 
					 		or <a href="createAccount.php">Create New Account</a></p>
				<hr style="margin: 24px 0">
				<input type="submit" name="login" value="Login" class="btn btn-primary" style="width: 100%">
			</div>
		</form>
	</div>
	<br><br><br><br><br><br><br><br>

<?php include('./includes/footer.php') ?>