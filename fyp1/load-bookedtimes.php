<?php
 	include "Server_Access.php";
	$selectedtime =$_POST['checktime'];
	$selectedconsultant =$_POST['checkconsultant'];

	//chg date format for sql
	$selectedtimeconv = date("Y-m-d", strtotime($selectedtime));  

	//Get only the order_detail(appointment time and date)of a specific consultant and filtered by the date input of the user.
	$sql= "SELECT * FROM order_detail INNER JOIN service_profile ON order_detail.Title = service_profile.Title  
	  WHERE service_profile.Username ='$selectedconsultant' AND order_detail.AppointmentTimeStart like '%$selectedtimeconv%'
	  AND OrderStatus !=  'canceled' ORDER BY order_detail.AppointmentTimeStart";

	
	//$sql= "select * FROM order_detail where AppointmentTimeStart like '%$selectedtimeconv%'";

	
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		while($row= mysqli_fetch_assoc($result)){
			$dt1=new Datetime($row['AppointmentTimeStart']);
			$time1 = $dt1->format('h:i A');
			$dt2=new Datetime($row['AppointmentTimeEnd']);
			$time2 = $dt2->format('h:i A');
			echo "";
			echo $time1;
		
			echo " - ";
			echo $time2;

			echo "  ❌ ";
			echo "<br><br>";
			echo "";
		}
	}else{
		echo "Available ✔️";
		echo "<br><br>";
	}

?>