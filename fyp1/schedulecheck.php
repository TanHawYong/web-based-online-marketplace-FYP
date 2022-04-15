<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	
	$selecteddate=$_POST['prefereddate'];
	$selectedtime=$_POST['preferedtime'];
	$selectedmedium=$_POST['Medium'];
	$duration=$_POST['duration'];
	$selectedTitle=$_POST['Title'];
	$selectedconsultant=$_POST['consultantname'];
	$specialreq=$_POST['Special'];
	

	$selecteddatetime = date('Y-m-d H:i:s', strtotime("$selecteddate $selectedtime"));

	$minutes_to_add = $duration;

	$selecteddatetimerange = date("Y-m-d H:i:s", strtotime($selecteddatetime.'+'.$duration.'minutes'));
	
	$uname= $_POST['username'];

	if($conn)
	{
		$consultantnoclash = "placeholder";$clientnoclash = "placeholder";

		$sql= "SELECT * FROM order_detail INNER JOIN service_profile ON order_detail.Title = service_profile.Title  
				WHERE service_profile.Username ='$selectedconsultant' 
				AND ('$selecteddatetime'BETWEEN order_detail.AppointmentTimeStart AND order_detail.AppointmentTimeEnd OR '$selecteddatetimerange'BETWEEN order_detail.AppointmentTimeStart AND order_detail.AppointmentTimeEnd)
				AND OrderStatus != 'canceled'";
		$result = mysqli_query($conn,$sql);	
		$resultCheck = mysqli_num_rows($result);


		$sqlclient= "SELECT * FROM order_detail WHERE Username ='$uname' 
		AND ('$selecteddatetime'BETWEEN order_detail.AppointmentTimeStart AND order_detail.AppointmentTimeEnd OR '$selecteddatetimerange'BETWEEN order_detail.AppointmentTimeStart AND order_detail.AppointmentTimeEnd)
		AND OrderStatus != 'canceled'";
		$resultclient = mysqli_query($conn,$sqlclient);	
		$resultCheckclient = mysqli_num_rows($resultclient);
	
		//check if consultant is available.
		if($resultCheck > 0){		
			echo '<script type="text/javascript">'; 
			echo 'alert("The time that you have selected is not available, please select a different time.");'; 
			echo 'window.location.href = "Schedule page.php";';
			echo '</script>';
		}elseif($resultCheck < 1){
				$consultantnoclash = "OK";
		}

		//check if client is available.
		if($resultCheckclient > 0){		
			echo '<script type="text/javascript">'; 
			echo 'alert("You have time clashes with other appointments!");'; 
			echo 'window.location.href = "Schedule page.php";';
			echo '</script>';
		}elseif($resultCheckclient < 1){
				$clientnoclash = "OK";
		}

		//check if both client and consultant is available.
		if($consultantnoclash == "OK"){
			if($clientnoclash == "OK"){
				$sqlinsert = "INSERT INTO `order_detail`
				(`Title`, `Username`, `Medium`, `AppointmentTimeStart`, `AppointmentTimeEnd`, `OrderStatus`, `SpecialReq`) 
				VALUES ('$selectedTitle','$uname','$selectedmedium','$selecteddatetime','$selecteddatetimerange','pending','$specialreq')";
				mysqli_query($conn,$sqlinsert);
	
				echo '<script type="text/javascript">'; 
				echo 'alert("Submitted request for consultation, please check the status of your order in the Your Appointments tab");'; 
				echo 'window.location.href = "Schedule page.php";';
				echo '</script>';
			}
		}

			
	}
	else
	{
		die(mysqli_connect_error());
	}
	
	
?>






