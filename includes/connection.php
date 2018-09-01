<?php 
	
	$server   = "localhost";
	$username = "root";
	$passward = "";
	$db       = "db_videotube";

	$conn     = mysqli_connect($server,$username,$passward,$db);
	if(!$conn)
	{
		die("connection failed :". mysqli_connect_error());
	} 
		//echo "connected successfully";
	

 ?>