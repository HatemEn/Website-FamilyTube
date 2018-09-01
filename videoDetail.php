<?php 
	$page = "profile";
	include('./includes/header.php') ;
	$video_id 		= $_GET['video_id'];
	$query			= "SELECT * FROM videos WHERE id = '$video_id'";
	$video_result	= mysqli_query($conn,$query);
	$row			= mysqli_num_rows($video_result);
	if ($row == 1) {
		$video 			= mysqli_fetch_assoc($video_result);
		$title			= $video['title'];
		$description	= $video['description'];
		$keywords		= $video['keywords'];
		$uploader		= $video['upload_by'];
		$date			= $video['date'];
		$location		= $video['location'];
		$views			= $video['views'];
		$privacy		= $video['privacy'];
		$size			= $video['size'];
	}
	$query 				= "SELECT * FROM ratings WHERE video_id = '$video_id' AND type = 'like'";
	$check_like_rate 	= mysqli_query($conn,$query);
	$like_rows 			= mysqli_num_rows($check_like_rate);

	$query 				= "SELECT * FROM ratings WHERE video_id = '$video_id' AND type = 'dislike'";
	$check_dislike_rate = mysqli_query($conn,$query);
	$dislike_rows 		= mysqli_num_rows($check_dislike_rate);
?>
	<br>
	<div class="container well">
		<p><strong>Title : </strong><em><?php echo $title; ?></em></p>
		<p><strong>Description : </strong><em><?php echo $description; ?></em></p>
		<p><strong>keywords : </strong><em><?php echo $keywords; ?></em></p>
		<p><strong>Privacy : </strong><em><?php echo $privacy; ?></em></p>
		<p><strong>Date : </strong><em><?php echo $date; ?></em></p>
		<p><strong>Size : </strong><em><?php echo $size; ?>&nbsp;&nbsp;MB</em></p>
		<p><strong>Views : </strong><em><?php echo $views; ?></em></p>
		<p><strong>Like : </strong><em><?php echo $like_rows; ?></em><strong style="padding-left: 10px">Dislike : </strong><em>
			<?php echo $dislike_rows; ?></em></p>
		<div class="btn-group btn-group-justified">
			<a class="btn btn-default" href="profile.php">Cancel</a>
			<a class="btn btn-primary" href="editVideo.php?video_id=<?php echo $video_id; ?>">Edit</a>
			<a class="btn btn-success" href="Watch.php?video_id=<?php echo $video_id; ?>">Watch</a>
			<a class="btn btn-danger" name="delete" href="includes/deleteVideo.php?video_id=<?php echo $video_id; ?>">Delete</a>
		</div>
	</div>

<?php include('./includes/footer.php') ?>