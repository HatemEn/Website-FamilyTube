<?php $page	= 'login'; include('./includes/header.php');
	if (isset($_POST['update'])) {

		$username 	= strip_tags($_POST['username']);
		$email 		= strip_tags($_POST['email']);
		$password1 	= strip_tags($_POST['password']);
		$password2 	= strip_tags($_POST['repeated_password']);

		if ($username) {
			if ($email) {
				if ($password1) {
					if ($password1 == $password2) {
						/// Encrypt the password ///
						$salt1		= 'future';
						$salt1		= md5($salt1);
						$salt2		= 'of';
						$salt2		= md5($salt2);
						$salt3		= 'world';
						$salt3		= md5($salt3);
						$password 	= $salt2.$password1.$salt3;
						$password 	= md5($password.$salt1);
						/////////////// update ///////////
						$query 	= "UPDATE accounts SET password = '$password' WHERE username ='$username' AND email = '$email'";
						mysqli_query($conn,$query);
						header('location: login.php');
					} else $errer 	= 'repeated_password';
				} else $errer 	= 'password';
			} else $errer 	= 'email';
		} else $errer 	= 'username';
	}



?>
	
	<br>
	<div class="container well">
		<form action="changePassword.php" method="post" class="form-group">
			<div class="col-sm-5">
				<input type="text" name="username" placeholder="Username..." onblur="placeholder='Username...'"
					onfocus="placeholder=''" class="form-control <?php if($errer == 'username') echo 'alert-danger'; ?>">
				<hr style="margin: 8px 0">
				<input type="text" name="email" placeholder="Email..." onblur="placeholder='Email...'"
					onfocus="placeholder=''" class="form-control <?php if($errer == 'email') echo 'alert-danger'; ?>">
				<hr style="margin: 8px 0">
				<input type="password" name="password" placeholder="New Password..." onblur="placeholder='New Password...'"
					onfocus="placeholder=''" class="form-control <?php if($errer == 'password') echo 'alert-danger'; ?>">
				<hr style="margin: 8px 0">
				<input type="password" name="repeated_password" placeholder="Repeat The Password..." onblur="placeholder='Repeat The Password...'" 			onfocus="placeholder=''" class="form-control <?php if($errer == 'repeated_password') echo 'alert-danger'; ?>">
				<hr style="margin: 8px 0">
				<p style="font-size: 12px; padding: 4px 0" class="pull-right"><a href="login.php">Back To Login</a></p>
				<hr style="margin: 24px 0">
				<input type="submit" name="update" value="Update" class="btn btn-primary" style="width: 100%">
			</div>
		</form>
	</div>
	
<?php include('./includes/footer.php'); ?>