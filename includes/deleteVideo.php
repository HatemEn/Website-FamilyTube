<?php 
	 include('./connection.php');
	 $video_id 		= $_GET['video_id'];
	 $query 		= "SELECT * FROM videos WHERE id ='$video_id'";
	 $video_detail  = mysqli_query($conn,$query);
	 $video 		= mysqli_fetch_assoc($video_detail);
	 $video_dir 	= "../".$video['location'];
	 //////////////////////////////////////////////
	 $query 		= "DELETE FROM videos WHERE id ='$video_id'";
	 $delete_video  = mysqli_query($conn,$query);
	 unlink($video_dir);
	 header("location: ../profile.php");
 ?>