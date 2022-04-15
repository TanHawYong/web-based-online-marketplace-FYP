<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	$date = date('m/d/Y');
	$boardtitle = $_POST['boardtitle'];
	$comment =$_POST['comment'];
	$uname= $_POST['username'];

	if($conn)
	{

		$sql="INSERT INTO `comments`
			         (`Username`, `TimeComment`, `BoardTitle`, `comments`) 
			  VALUES ('$uname',now(),'$boardtitle','$comment')";


		mysqli_query($conn,$sql);

		

		echo '<script type="text/javascript">';  
		echo 'window.location.href = "DiscussionBoard page.php";';
		echo '</script>';
	}
	else
	{
		die(mysqli_connect_error());
	}
	echo '<script type="text/javascript">';  
	echo 'window.location.href = "DiscussionBoard page.php";';
	echo '</script>';
?>