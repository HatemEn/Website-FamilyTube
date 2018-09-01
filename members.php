<?php $page	= 'members'; include('./includes/header.php');?>
 	<div class="well" style="padding: 5px">
	<?php

	
	////////
	$query				= "SELECT * FROM accounts";
	$accounts_result	= mysqli_query($conn,$query);
	$rows				= mysqli_num_rows($accounts_result);
	if ($rows > 0) {
		while ($account = mysqli_fetch_assoc($accounts_result)) {
			$id			= $account['id'];
			$firstname 	= $account['firstname'];
			$lastname	= $account['lastname'];
			$username	= $account['username'];
			$email		= $account['email'];
			$password	= $account['password'];
			$dob		= $account['dob'];
			$image		= $account['image'];
			$locked		= $account['locked'];

			$query			= "SELECT * FROM videos WHERE upload_by = '$username'";
			$videos_result	= mysqli_query($conn,$query);
			$no_videos		= mysqli_num_rows($videos_result);
 ?>
 		<a href="personalVideos.php?username=<?php echo $username; ?>">
	 		<div class="video_show_way">
	 			<img width="120px" height="120px" src="<?php echo $image; ?>" style="height: 120px;width: 120px;margin-top: 15px;float: left;border-radius:200px"><br>
	 			<div class="pull-left" style="padding-left: 5px;color: black">
	 				<h4><em><?php echo $username; ?></em></h4>
	 				<p><strong>No. Videos : </strong><em><?php echo $no_videos; ?></em></p>
	 			</div>
	 		</div>
 		</a>
	 <?php }} ?>
	</div>
<?php include('./includes/footer.php'); ?>