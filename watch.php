<?php 
	$page 			= '';
	include('./includes/header.php');
	$video_id		= $_GET['video_id'];
	$disable_like 	= "";
	$disable_dislike 	= "";
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
		///// increase the views /////
		if (isset($_GET['view']) && $_GET['view'] == 's') {
			echo ""; /// no icreamant to the views
		} else {
			$views 	= $views + 1;
			$query 	= "UPDATE videos SET views = '$views' WHERE id = '$video_id'";
		}
		
		mysqli_query($conn,$query);
		////// Load the comment /////
		$query		= "SELECT * FROM comments WHERE video_id = '$video_id' ORDER BY id DESC";
		$comments_tbl 	= mysqli_query($conn,$query);
	} else header('location: index.php');
	/////////// For Comments ///////////////////////////
	if (isset($_POST['comment'])) { 
		$comment 	= trim(htmlentities(strip_tags(mysql_real_escape_string($_POST['comment_on_video']))));
		$today_date = date("d F Y");
		if (isset($_SESSION['username'])) {
			$username 	= $_SESSION['username'];
			$query 		= "INSERT INTO comments VALUES(null,'$username','$comment','$date','$video_id')";
			mysqli_query($conn,$query);
			////// Load the comment /////
			$query		= "SELECT * FROM comments WHERE video_id = '$video_id' ORDER BY id DESC";
			$comments_tbl 	= mysqli_query($conn,$query);
		} else header('location: login.php?watch='.$video_id);
	}
	//////////// For ratings system //////////////
	$query 				= "SELECT * FROM ratings WHERE video_id = '$video_id' AND type = 'like'";
	$check_like_rate 	= mysqli_query($conn,$query);
	$like_rows 			= mysqli_num_rows($check_like_rate);

	$query 				= "SELECT * FROM ratings WHERE video_id = '$video_id' AND type = 'dislike'";
	$check_dislike_rate = mysqli_query($conn,$query);
	$dislike_rows 		= mysqli_num_rows($check_dislike_rate);

	$total_width 		= 200;
	if ($like_rows == 0 && $dislike_rows == 0) { $like_rows = $dislike_rows = 1; }
	$total_num 			= $like_rows + $dislike_rows;
	$width_of_one 		= $total_width/$total_num;
	$green				= $width_of_one * $like_rows;
	$red				= $width_of_one * $dislike_rows;
	///////// for ratings Like/Dislike //////////////////
	if (isset($_POST['like']) || isset($_POST['dislike'])) {
		if (isset($_SESSION['id'])) {
			$user_id 		= $_SESSION['id'];
			$query 			= "SELECT * FROM ratings WHERE video_id = '$video_id' AND user_id = '$user_id'";
			$check_rating 	= mysqli_query($conn,$query);
			$row 			= mysqli_num_rows($check_rating);
			$rate 			= mysqli_fetch_assoc($check_rating);
			if (isset($_POST['like'])) {
				if ($row == 0) {
					$query 		= "INSERT INTO ratings VALUES(null,'$video_id','like','$user_id')";
					$first_rate = mysqli_query($conn,$query);
				} 
				elseif ($rate['type'] == 'dislike') {
					$query 		= "UPDATE ratings SET type = 'like' WHERE video_id = '$video_id' AND user_id = '$user_id'";
					$change_rate= mysqli_query($conn,$query);
				}else $disable_like 	= 'disabled=""';
			}
			elseif (isset($_POST['dislike'])) {
				if ($row == 0) {
					$query 		= "INSERT INTO ratings VALUES(null,'$video_id','dislike','$user_id')";
					$first_rate = mysqli_query($conn,$query);
				} 
				elseif ($rate['type'] == 'like') {
					$query 		= "UPDATE ratings SET type = 'dislike' WHERE video_id = '$video_id' AND user_id = '$user_id'";
					$change_rate= mysqli_query($conn,$query);
				}else $disable_dislike 	= 'disabled=""';
			}
			header('location: watch.php?video_id='.$video_id."&&view=s");
		} else header('location: login.php?watch='.$video_id);
	}
 ?>

 	<div class="well clearfix" <?php if ($mobile) { ?> style="padding: 10px 2px" <?php ;} ?>>
 		<div <?php if (!$mobile) { ?> style="width: 50%;height: 50%" <?php ;} ?>>
	 		<div class="embed-responsive embed-responsive-16by9">
	 			<video width="100%" height="100%" controls="" style="background: #000" class="">
	 				<source src="<?php echo $location; ?>" type="video/mp4">
	 				<!--<track kind="subtitles" src="storage/EP4.vtt" srclang="en" label="ar">-->
	 				Your browser doesn't support the HTML5 video tag.
	 			</video>
	 		</div>
 		</div>
 		<br>
 		<div class="col-lg-6" style="padding: 0">
	 		<div class="">
	 			<h4><?php echo $title; ?></h4>
	 			<p><em class="pull-left"><?php echo $views; ?> Views </em></p>
	 			<!-- for ratings system -->
	 			<div class="pull-left">
	 				<form action="watch.php?video_id=<?php echo $video_id; ?>&&view=s" method="post">
	 					<input type="submit" name="like" value="" style="background: url('includes/images/like.png') no-repeat; 
	 						background-size: 25px;border: none; width: 25px;height: 25px;margin-left: 10px" <?php echo $disable_like; ?>>
	 					<input type="submit" name="dislike" value="" style="background: url('includes/images/dislike.png') no-repeat; 
	 						background-size: 25px;border: none; width: 25px;height: 25px;margin-left: 20px" <?php echo $disable_dislike; ?>>
	 				</form>
	 			</div>
	 			<div class="pull-right" style="width: <?php echo $total_width; ?>px; height: 8px;padding-top:<?php 
	 				if($mobile)echo '10px';else echo '0'; ?>">
	 				<div class="pull-left" style="width:<?php echo $green; ?>px; height: 8px; background: green"></div>
	 				<div class="pull-left" style="width:<?php echo $red; ?>px; height: 8px; background: red"></div>
	 			</div>
	 			<br>
	 			<hr>
	 			<a href="personalVideos.php?username=<?php echo $uploader ?>"><em>Uploaded By : <?php echo $uploader; ?></em></a>
	 			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>On <?php echo $date; ?></em></p>
	 			<p><?php echo $description ?></p>
	 		</div>
	 		<hr>
	 		<div class="" style="margin-top: 40px">
				<div>
					<?php 
						$rows = mysqli_num_rows($comments_tbl);
						if ($rows !=0) {
							while ($comment_row = mysqli_fetch_assoc($comments_tbl)) {
								$who_commented 	= $comment_row['who_commented'];
								$comment 		= $comment_row['comment'];
								$date 			= $comment_row['date'];
					 ?>
					<a href="personalVideos.php?username=<?php echo $who_commented ?>"><em><?php echo $who_commented ?></em></a>
					<p style="padding-left: 10px; font-size: 80%"><?php echo $date; ?></p>
					<p><?php echo $comment; ?></p>
					<?php }} ?>
				</div> 		
	 			<form action="watch.php?video_id=<?php echo $video_id; ?>" method="post">
	 				<textarea placeholder="Comment On This Video..." onfocus="placeholder=''" onblur="placeholder='Comment On This Video...'" 
	 					name="comment_on_video" rows="1" cols="50" class="form-text form-control pull-left" style="width: 70%"></textarea>
					<input type="submit" name="comment" class="btn btn-default pull-left" value="Comment" 
						style="height:<?php if (!$mobile) echo '50px'?>">
	 			</form>
	 		</div>
	 	</div>
 	</div>





 <?php include('./includes/footer.php'); ?>