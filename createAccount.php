<?php 
	$page = "login";
	include('./includes/header.php');
	include('./includes/connection.php');
	if (isset($_POST['create_account'])) {
		$firstname 	= strip_tags($_POST['firstname']);
		$lastname 	= strip_tags($_POST['lastname']);
		$username 	= strip_tags($_POST['username']);
		$email 		= strip_tags($_POST['email']);
		$password1 	= strip_tags($_POST['password']);
		$password2 	= strip_tags($_POST['repeated_password']);
		$dob_day 	= strip_tags($_POST['dob_day']);
		$dob_month 	= strip_tags($_POST['dob_month']);
		$dob_year 	= strip_tags($_POST['dob_year']);
		$errer 		= "";
		
		///////////////////////////////////////////////////////////////////////////
		if ($firstname) {
			if ($lastname) {
				if ($username) {
					if ($email) {
						if ($password1) {
							if ($password2 && $password1 == $password2) {
								if ($dob_day || $dob_month || $dob_year) {
									/// check if the username is exist ///
									$query 	= "SELECT * FROM accounts WHERE username = '$username'";
									$check_username	= mysqli_query($conn,$query);
									if ($check_username->num_rows == 0) {
										// check the email if exist ///
										$query 	= "SELECT * FROM accounts WHERE email = '$email'";
										$check_email	= mysqli_query($conn,$query);
										if ($check_email->num_rows == 0) {
											/// Encrypt the password ///
											$salt1		= 'future';
											$salt1		= md5($salt1);
											$salt2		= 'of';
											$salt2		= md5($salt2);
											$salt3		= 'world';
											$salt3		= md5($salt3);
											$password 	= $salt2.$password1.$salt3;
											$password 	= md5($password.$salt1);
											//// put dob -> date of berth ///
											$dob 		= $dob_day."/".$dob_month."/".$dob_year;
											//// deffult image for the account ///
											$image 		= './storage/image_accounts/user.png';
											/// create the account ///
											$query 		= "INSERT INTO accounts VALUES(null,'$firstname','$lastname',
												'$username','$email','$password','$dob','$image','no')";
											$result		= mysqli_query($conn,$query);
											header('location: login.php');
											/// End the register ///
										} else $errer	= 'email';
									} else $errer	= 'username';
								} else $errer 	= 'dob';
							} else $errer	= 'repeated_password';
						} else $errer	= 'password';
					} else $errer	= 'email';
				} else $errer	= 'username';
			} else $errer	= 'lastname';
		} else $errer = 'firstname'; 
		/////////////////////////////////////////////////////////////////////////////
echo $errer;
	}
	
?>

	<br>
		<div class="container well">
			<form action="createAccount.php" method="POST" class="form-group">
				<div class="col-sm-5 pull-right">
					<h4 class="text-primary text-center">Create New Account Right Now</h4><hr>

					<input type="text" name="firstname" placeholder="Firstname..." onblur="placeholder='Firstname...'"
						 onfocus="placeholder=''" class="form-control <?php if($errer == 'firstname') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">
					<input type="text" name="lastname" placeholder="Lastname..." onblur="placeholder='Lastname...'"
						 onfocus="placeholder=''" class="form-control <?php if($errer == 'lastname') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">
					<input type="text" name="username" placeholder="Username..." onblur="placeholder='Username...'"
						 onfocus="placeholder=''" class="form-control <?php if($errer == 'username') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">
					<input type="text" name="email" placeholder="Email..." onblur="placeholder='Email...'"
						 onfocus="placeholder=''" class="form-control <?php if($errer == 'email') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">
					<input type="password" name="password" placeholder="Password..." onblur="placeholder='Password...'"
						 onfocus="placeholder=''" class="form-control <?php if($errer == 'password') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">
					<input type="password" name="repeated_password" placeholder="Repeat The Password..." 
						onblur="placeholder='Repeat The Password...'" onfocus="placeholder=''" 
							class="form-control <?php if($errer == 'repeated_password') echo 'alert-danger'; ?>">
					<hr style="margin: 8px 0">

					<input type="text" name="dob_day" placeholder="Day..." onblur="placeholder='Day...'" maxlength ="2" 
						onfocus="placeholder=''" class="form-control pull-left text-center <?php if($errer == 'dob') echo 'alert-danger'; ?>" style="width: 20%;margin-right: 20px;">

					<input type="text" name="dob_month" placeholder="Month..." onblur="placeholder='Month...'" maxlength ="2" 
						onfocus="placeholder=''" class="form-control pull-left text-center <?php if($errer == 'dob') echo 'alert-danger'; ?>" style="width: 25%;margin-right: 20px;">

					<input type="text" name="dob_year" placeholder="Year..." onblur="placeholder='Year...'" maxlength ="4" 
						onfocus="placeholder=''" class="form-control text-center <?php if($errer == 'dob') echo 'alert-danger'; ?>" 	style="width: 25%">
					<hr style="margin: 8px 0">	
					<p style="font-size: 12px; padding: 4px 0" class="pull-right"><a href="login.php">Back To Login</a></p>
					<hr style="margin: 24px 0">
					<input type="submit" name="create_account" value="Create Account" class="btn btn-primary" style="width: 100%">
				</div>
			</form>
		</div>



<?php include('./includes/footer.php') ?>