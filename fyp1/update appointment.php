<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	$title = $_POST['Title'];
	$client =$_POST['client'];
	$appointmenttime= $_POST['appointmenttime'];
	$submit = $_POST['submit'];
	$message=$_POST['message'];

	if($conn)
	{
		$sql="UPDATE `order_detail` SET `OrderStatus`='canceled',`message`='$message' WHERE Username='$client' AND Title='$title' AND AppointmentTimeStart='$appointmenttime'";
		
		if($submit == 'accept'){
			$sql= "UPDATE `order_detail` SET `OrderStatus`='confirmed' ,`message`='$message' WHERE Username='$client' AND Title='$title' AND AppointmentTimeStart='$appointmenttime'";
			//$sql="UPDATE 'order_detail' SET 'OrderStatus'='confirmed' WHERE Username='$client'";
		}
		
		mysqli_query($conn,$sql);

		

		echo '<script type="text/javascript">';  
		echo 'window.location.href = "Appointments page (Consultant).php";';
		echo '</script>';
	}
	else
	{
		die(mysqli_connect_error());
	}
	echo '<script type="text/javascript">';  
	//echo 'window.location.href = "Appointments page (Consultant).php";';
	echo '</script>';
?>