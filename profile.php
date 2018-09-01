<?php 
	$page = "profile";
	include('./includes/header.php') ;
	$user_id			= $_SESSION['id'];
	$query				= "SELECT * FROM accounts WHERE id = '$user_id'";
	$the_account		= mysqli_query($conn,$query);
	$account 			= mysqli_fetch_assoc($the_account);

	$username 			= $account['username'];
	$email 				= $account['email'];
	$dob 				= $account['dob'];
	$img 				= $account['image'];

	/// For storage space ///
	$total_videos_size	= 0;
	$free_space 		= 0;
	$query 		= "SELECT * FROM videos WHERE upload_by = '$username'";
	$check_size = mysqli_query($conn,$query);
	$rows_video = mysqli_num_rows($check_size);
	if ($rows_video != 0) {
		while ($video = mysqli_fetch_assoc($check_size)) {
			$total_videos_size = $total_videos_size + $video['size'];
		}
	}
	$free_space = 500 - $total_videos_size;

	if (!$mobile) echo "<br>";
?>

	<div class="container" style="width: 100%; padding: <?php if($mobile) echo '0'; ?>">
		<div class="well pull-left" style="width: <?php if($mobile) echo '100';else echo'30' ?>%;">
		<hr>
			<a href="changeAccountImage.php?"><img src="<?php echo $img; ?>" width="150px" height="150px" 
				class="center-block image_account" style="border-radius: 200px" ></a>

			<hr>
			<br>
			<p><strong>Username : </strong><em><?php echo $username; ?></em></p>
			<p><strong>Eamil : </strong><em><?php echo $email; ?></em></p>
			<p><strong>Date Of Birth : </strong><em><?php echo $dob; ?></em></p>
			<p><strong>Your Space :</strong>&nbsp;<em><?php echo intval($free_space).'/'.intval($total_videos_size); ?>&nbsp;&nbsp;MB</em></p>
			<hr>
			<a href="uploadVideo.php" class="btn btn-primary center-block">Add New Video</a>
		</div>
		<!--<div style="margin-left: 30px;float: left;width: 60%;height: 20px;background: #ccc;
			text-align: center;">Channel Videos</div>-->
		<?php if (!$mobile) { ?>
			<div style="height: 400px;width: 70% ;overflow: scroll; overflow-x: auto;float: right;">
		<?php } else { ?>	
			<div style="height: 500px;width: 100% ;overflow: scroll; overflow-x: auto;float: left;">
			<?php }
				$query			= "SELECT * FROM videos WHERE upload_by = '$username'";
				$videos_result	= mysqli_query($conn,$query);
				$rows			= mysqli_num_rows($videos_result);
				if ($rows != 0) {
					while ($video = mysqli_fetch_assoc($videos_result)) {
						$video_id 		= $video['id'];
						$title			= $video['title'];
						$description	= $video['description'];
						$keywords		= $video['keywords'];
						$uploader		= $video['upload_by'];
						$date			= $video['date'];
						$location		= $video['location'];
						$views			= $video['views'];
						$thumbnail 		= $video['thumbnail'];
			 ?>
			 <?php if (!$mobile) { ?>
				 <a href="videoDetail.php?video_id=<?php echo $video_id; ?>">
					<div class="pull-right video_show_way_2" style="padding: 10px">
						<img src="<?php echo $thumbnail; ?>" width="200px" height="140px">
						<p class="text-center"><?php echo $title; ?></p>
					</div>
				</a>
			<?php } else { ?>
			 		<a href="videoDetail.php?video_id=<?php echo $video_id; ?>">
				 		<div class="video_show_way">
				 			<img width="120px" height="120px" src="<?php echo $thumbnail; ?>" style="height: 120px;width: 120px;float: left;"><br>
				 			<div class="pull-left" style="padding-left: 5px;color: black">
				 				<p style="margin-bottom: 0"><em><?php echo $title; ?></em></p>
				 			</div>
				 		</div>
			 		</a>
			<?php }}} ?>
		</div>
	</div>
	
<?php include('./includes/footer.php') ?>
