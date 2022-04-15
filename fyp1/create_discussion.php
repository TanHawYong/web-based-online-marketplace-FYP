<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	
	$distitle=$_POST['discustitle'];
	$title=$_POST['Title'];
	
	if($conn)
	{
		$sql= "INSERT INTO `discussion_board`(`Title`, `BoardTitle`) 
			   VALUES ('$title','$distitle')";
				mysqli_query($conn,$sql);	
	
			
	}
	else
	{
		die(mysqli_connect_error());
	}
	
	header("Location: ../fyp1/Service detail page.php");
?>






