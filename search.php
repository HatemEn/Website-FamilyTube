<?php $page 	= ''; include('./includes/header.php');?>
<div class="well" style="padding: 5px">
<?php
	$search 		= $_POST['search_box'] ;
	$query			= "SELECT * FROM videos WHERE title LIKE '%$search%' OR description LIKE '%$search%'OR keywords LIKE '%$search%'";
	$videos_result	= mysqli_query($conn,$query);
	$rows			= mysqli_num_rows($videos_result);
	echo "<h4>No. Of Resault Is : ".$rows."</h4><hr>";
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
	 		<img width="180px" height="140px" src="<?php echo $thumbnail; ?>" style="height: 140px;width: 180px;float: left;"><br>
	 		<div class="pull-left"  style="padding-left: 5px;color: black">
	 			<h4 style="margin-bottom: 0"><em><?php echo $title; ?></em></h4>
	 			<p  style="margin-bottom: 5px"><em><?php echo $description; ?></em></p>
	 			<p><strong>Tag : </strong><em><?php echo $keywords; ?></em>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Views : </strong>
	 				<em><?php echo $views; ?></em></p>
	 		</div>
	 	</div>
 	</a>
 	<?php }} else echo "No Resault!"; ?>
<?php include('./includes/footer.php') ?>