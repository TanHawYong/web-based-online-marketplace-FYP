<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Service detail page</title>
	 <link rel="stylesheet" href="css/Appointments page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
				 
			
	<body>
	<section class="header">
			<?php include "header.php"; ?>
	</section>



	 <h2>Here is a list of your current appointments</h2>

	<div class='appointmentcontainer'>
	   <?php		
	   $currUser=$_SESSION['Username'];

	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   $sql = "SELECT * FROM order_detail WHERE Username='$currUser' ORDER BY AppointmentTimeStart DESC LIMIT 20";
	   $result = $conn->query($sql);
	   
	   if($conn){				   
		if(mysqli_num_rows($result)>0){
			while ($row = mysqli_fetch_assoc($result)){
				$datas[] = $row;
			}

		
		
		foreach($datas as $data){
			$Title= $data["Title"];
			echo "<div class='appointmentdetailclient' >";
			echo "<div class='title'><u>". $data["Title"]. "</u></div>";
			echo "<div class='datetimes' style='border-right: 4px dotted orange;border-left: 4px dotted orange;'>";
			$dt1=new Datetime($data['AppointmentTimeStart']);
			$time1 = $dt1->format('  Y-m-d h:i A');
			$dt2=new Datetime($data['AppointmentTimeEnd']);
			$time2 = $dt2->format(' h:i A');
			
			echo "". $time1. " - ";
			echo "". $time2. "";




			//get consultant info
			$sqlconinfo= "SELECT user_profile.* FROM user_profile 
						  INNER JOIN service_profile ON user_profile.Username = service_profile.Username 
						  INNER JOIN Order_detail ON service_profile.Title = Order_detail.Title
						  WHERE service_profile.Title = '$Title'";
			$resultcon = mysqli_query($conn,$sqlconinfo);
			if(mysqli_num_rows($resultcon)>0){
				while ($rowcon = mysqli_fetch_assoc($resultcon)){

					echo "<br> Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ";
					echo $rowcon['Email'];
					echo "<br> Company &nbsp; : ";
					echo $rowcon['Company'];
					echo "<br> Position &nbsp;&nbsp;&nbsp; : ";
					echo $rowcon['JobPos'];
					echo "<br>";
					break;
				}
			}


			$specialreq =$data['SpecialReq'];
			echo "<br>You requested: <br> $specialreq<br>";

			echo "</div>";
			$status =$data["OrderStatus"];

			echo "<div class='status'>";
			echo "   Status : ". $data["OrderStatus"]. "";
			if($data["OrderStatus"] == "pending"){
				echo "⌛";
			}else if ($data["OrderStatus"] == "confirmed"){
				echo "✔️<br>";
				$message=$data['message'];
				if($message != ""){
					echo "consultant replied: <br><br>";
					echo "$message";
				}

			}else{
				echo "❌<br>";
				$message=$data['message'];
				if($message != ""){
					echo "Reason of cancelation: <br> ";
					echo "$message";
				}
				
			}
			echo "</div>";

			if($status == 'confirmed'){
				echo "<div='appointmentbuttons'>";
				echo "<form id = 'review'  method='post' action='Review page.php' >";
				echo	"<input type='hidden' name='Title' value='$Title'/>";
				echo "<input type='submit' id='submit' value='review'>";
				echo "</form>";
				echo "</div>";
			}


			echo "</div>";
		}

	}else{
		echo "You have no apppointment";
	}
			   
	   }else{
		   die(mysqli_connect_error());
	   }
		   
	   
	   mysqli_close($conn);
	   ?>

	</div>
			
							
	


   
   
   
   
   
 
 










</body>
	

</html>