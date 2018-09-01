<?php 
	$page 				= 'profile';
	include('./includes/header.php');
	if (isset($_POST['upload'])) {
	 	$dir 				= 'storage/uploaded_videos/';
		$file_uploaded		= $_FILES['video']['name'];
		$file_dir			= $dir.$file_uploaded;
		$file_type			= $_FILES['video']['type'];
		$title 				= strip_tags($_POST['title']);
		$description		= strip_tags($_POST['description']);
		$keywords 			= strip_tags($_POST['keywords']);
		$username			= $_SESSION['username'];
		$size 				= filesize($_FILES["video"]["tmp_name"])/1000000;
		$date				= date("F j, Y");
		$total_videos_size 	= 0;
		if (isset($_POST['privacy'])) {
			$privacy = $_POST['privacy'];
		} else $privacy = 'public';

		$query 		= "SELECT * FROM videos WHERE upload_by = '$username'";
		$check_size = mysqli_query($conn,$query);
		$rows_video = mysqli_num_rows($check_size);
		if ($rows_video != 0) {
			while ($video = mysqli_fetch_assoc($check_size)) {
				$total_videos_size = $total_videos_size + $video['size'];
			}
		}
		$total_videos_size = $total_videos_size + $size;
		if ($total_videos_size <= 500) { 	// For space limeting //
			if (!empty($title) && !empty($description) && !empty($keywords) && !empty($privacy)) {
				if ($file_type == 'video/mp4') {
					if (file_exists($file_dir)) {
						$error	= "File exist";
					} else { 
						move_uploaded_file($_FILES['video']['tmp_name'], $file_dir);
						$query	= "INSERT INTo videos VALUES(null,'$title','$description','$keywords','$username','$privacy','$date','0','$file_dir',
							'Storage/thumbnails_video/def.png','$size')";
						mysqli_query($conn,$query);
						header("location:profile.php");
					}		
				} else $error = "The video is not mp4!";
			} else $error = "All section in the form should not be empty!";
		} else die("You don't have enough space!");
		
	 } 
?>

	<br>
	<div class="container well">
		<?php if(isset($error)) echo '<p  class="alert-warning">'.$error.'</p>'; ?>
		<form action="uploadVideo.php" method="post" enctype="multipart/form-data" class="form-group">
			<input type="text" name="title" placeholder="Title..." onfocus="placeholder=''" onblur="placeholder='Title...'"
				class="form-control" style="width: <?php if($mobile) echo '60';else echo '20'; ?>%">
				<hr>
			<textarea placeholder="Description..." onfocus="placeholder=''" onblur="placeholder='Description...'" name="description" 
				rows="5" cols="50" class="form-text form-control" style="width: <?php if($mobile) echo '80';else echo '40'; ?>%"></textarea>
				<hr>
			<input type="text" name="keywords" placeholder="Keywords..." onfocus="placeholder=''" onblur="placeholder='Keywords...'"
				class="form-control" style="width: <?php if($mobile) echo '70';else echo '30'; ?>%">	
			<hr>
			Privacy :<br>&nbsp;&nbsp;&nbsp; <input type="radio" name="privacy" value="public"> Public&nbsp;&nbsp;<input type="radio" 	name="privacy" value="private"> Private
			<hr>
			<input type="file" name="video" class="btn btn-default">
			<hr>
			<input type="submit" name="upload" value="Upload" class="btn btn-primary">
		</form>
	</div>

<?php include('./includes/footer.php'); ?>