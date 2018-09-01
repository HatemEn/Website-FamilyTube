<?php $page	= 'members'; include('./includes/header.php');?>
 	<div class="well" style="padding: 5px">
	<?php
	$username 		= $_GET['username'];
	$query			= "SELECT * FROM videos WHERE upload_by ='$username'";
	$videos_result	= mysqli_query($conn,$query);
	$rows			= mysqli_num_rows($videos_result);
	if ($rows > 0) {
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
 		<a href="watch.php?video_id=<?php echo $video_id; ?>">
	 		<div class="video_show_way">
	 			<img width="120px" height="120px" src="<?php echo $thumbnail; ?>" style="height: 120px;width: 120px;float: left;"><br>
	 			<div class="pull-left"  style="padding-left: 5px;color: black">
	 				<h4 style="margin-bottom: 0"><em><?php echo $title; ?></em></h4>
	 				<p  style="margin-bottom: 5px"><em><?php echo $description; ?></em></p>
	 			</div>
	 		</div>
 		</a>
	 <?php }} else die('there is no videos here!'); ?>
	</div>
 <?php include('./includes/footer.php'); ?>