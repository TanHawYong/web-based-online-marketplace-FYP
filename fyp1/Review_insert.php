<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	$date = date('m/d/Y');
	$Title =$_POST['Title'];
	$review =$_POST['review'];
	$rating = $_POST['rating'];
	$uname= $_POST['username'];

	if($conn)
	{
		$sql = "INSERT INTO `review`
		(`Title`, `Username`, `Review`, `RatingGiven`, `TimeReview`) VALUES
		 ('$Title','$uname','$review','$rating',curdate())";
	

		mysqli_query($conn,$sql);


		$sqlgetavg = "SELECT AVG(RatingGiven) AS average FROM review WHERE Title='$Title'";

		$result = mysqli_query($conn,$sqlgetavg); 
		while($row = mysqli_fetch_array($result)){
			 $rating = $row['average']; 
		} 

		$sqlupdrating = "UPDATE `service_profile` SET `Rating`='$rating' WHERE Title='$Title'";
		mysqli_query($conn,$sqlupdrating); 

		echo '<script type="text/javascript">';  
		echo 'alert("Review successfully submitted. Thank you!");'; 
		echo 'window.location.href = "Appointments page (Client).php";';
		echo '</script>';
	}
	else
	{
		die(mysqli_connect_error());
	}
	echo '<script type="text/javascript">';  
	echo 'window.location.href = "Appointments page (Client).php";';
	echo '</script>';
?>