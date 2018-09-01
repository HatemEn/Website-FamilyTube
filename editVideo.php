<?php 
	$page 				= 'profile';
	include('./includes/header.php');
	$video_id 		= $_GET['video_id'];
	/////////// show the details of video selected /////////////////
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
		$size			= $video['size'];
		$privacy 		= $video['privacy'];
	}
	//////////// Take the change and update it ////////////////////
	if (isset($_POST['update'])) {
		if (isset($_FILES['thumbnail'])) {
			$file_type			= $_FILES['thumbnail']['type'];
			if ($file_type == 'image/jpeg' || $file_type == 'image/png' || $file_type == 'image/gif' ) {
				$dir 			= 'storage/thumbnails_video/';
				$file_uploaded	= $_FILES['thumbnail']['name'];
				$file_dir		= $dir.$file_uploaded;
				if (file_exists($file_dir)) {
					$errer		= "File exist";
				} else { 
					move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file_dir);
					$query			= "UPDATE videos SET thumbnail='$file_dir' WHERE id ='$video_id'";
					mysqli_query($conn,$query);
					$image_account 	= $file_dir;
				}
			}
		} else $errer 	= "The thumbnail didn't uploaded!";
		/////////////////////////
		$title 			= strip_tags($_POST['title']);
		$description	= strip_tags($_POST['description']);
		$keywords 		= strip_tags($_POST['keywords']);
		$privacy 		= $_POST['privacy'];
		$query			= "UPDATE videos SET title='$title',description='$description',keywords='$keywords',privacy='$privacy' WHERE id ='$video_id'";
		mysqli_query($conn,$query);
		header("location: videoDetail.php?video_id=".$video_id);
	}
?>

	<br>
	<div class="container well">
		<form action="editVideo.php?video_id=<?php echo $video_id; ?>" method="post" enctype="multipart/form-data" class="form-group">
			<input type="text" name="title" placeholder="Title..." onfocus="placeholder=''" onblur="placeholder='Title...'"
				class="form-control" style="width: <?php if($mobile) echo '60';else echo '20'; ?>%" value="<?php echo $title; ?>">
				<hr>
			<textarea placeholder="Description..." onfocus="placeholder=''" onblur="placeholder='Description...'" name="description" 
				rows="5" cols="50" class="form-text form-control" style="width: <?php if($mobile) echo '80';else echo '40'; ?>%"><?php echo $description; ?></textarea>
				<hr>
			<input type="text" name="keywords" placeholder="Keywords..." onfocus="placeholder=''" onblur="placeholder='Keywords...'"
				class="form-control" style="width: <?php if($mobile) echo '70';else echo '30'; ?>%" value="<?php echo $keywords; ?>">	
			<hr>
			Privacy :<br>&nbsp;&nbsp;&nbsp; <input type="radio" name="privacy" value="public" <?php if ($privacy == 'public') echo 'checked'; ?>> 			Public&nbsp;&nbsp;<input type="radio" 	name="privacy" value="private" <?php if ($privacy == 'private') echo 'checked'; ?>> Private
			<hr>
			<p><em>Thumbnail :</em></p>
			<input type="file" name="thumbnail" class="btn btn-default">
			<hr>
			<input type="submit" name="update" value="Update" class="btn btn-primary">
		</form>
	</div>

<?php include('./includes/footer.php'); ?>