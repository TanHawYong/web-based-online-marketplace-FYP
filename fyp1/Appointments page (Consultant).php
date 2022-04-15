<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Appointments</title>
	 <link rel="stylesheet" href="css/Appointments page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
				 
		
			
	<body>
	<section class="header">
			<?php include "header.php"; ?>
		</section>



	 <h2>Here is a list of your current appointments</h2>

   
	   <?php		
	   $currUser=$_SESSION['Username'];

	   $conn = mysqli_connect("localhost","root","","sixerr_db");

	   $sql = "SELECT order_detail.* FROM order_detail INNER JOIN service_profile ON order_detail.Title = service_profile.Title WHERE service_profile.Username = '$currUser'
	   			ORDER BY order_detail.AppointmentTimeStart";	   
	   $result = mysqli_query($conn,$sql);
	   
	   if($conn){			
			if(mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_assoc($result)){
					$datas[] = $row;
				}
			}

			foreach($datas as $data){
			echo "<div class='appointmentdetail' >";
				echo "<div class='titleappointment'><u>". $data["Title"]. "</u></div>";
				$client = $data['Username'];

				echo "<div class='clientdetail' style='border-right: 4px dotted orange;border-left: 4px dotted orange;'>";
				echo "Client :  $client <br>";

				//sql to get client info
				$sqlclientinfo="SELECT * FROM user_profile WHERE Username='$client'";
				$resultclient = mysqli_query($conn,$sqlclientinfo);
				if(mysqli_num_rows($resultclient)>0){
					while ($rowclient = mysqli_fetch_assoc($resultclient)){
						echo "<br> Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ";
						echo $rowclient['Email'];
						echo "<br> Company &nbsp; : ";
						echo $rowclient['Company'];
						echo "<br> Position &nbsp;&nbsp;&nbsp; : ";
						echo $rowclient['JobPos'];
						echo "<br>";
					}
				}

				//get appointment date and time
				$clientdate = $data['AppointmentTimeStart'];
				$dt1=new Datetime($data['AppointmentTimeStart']);
				$time1 = $dt1->format('  Y-m-d h:i A');
				$dt2=new Datetime($data['AppointmentTimeEnd']);
				$time2 = $dt2->format('h:i A');
				
				echo "<br>". $time1. " - ";
				echo "". $time2. "";

				$req = $data['SpecialReq'];
				if($req == ""){
					echo "<br>Special Request: none";
				}else{
					echo "<br>Special Request:<br>$req";
				}
				
				echo "</div>";

				//get appointment status
				echo "<div class='status'>";
				echo "   Status : ". $data["OrderStatus"]. "";
				if($data["OrderStatus"] == "pending"){
					echo "⌛";
				}else if ($data["OrderStatus"] == "confirmed"){
					echo "✔️";
				}else{
					echo "❌";
				}
				echo "</div>";


				echo "<div class='confirmbutton'>";
					$Title=$data["Title"];
					echo "<form id = 'confirm'  method='post' action='accept appointment.php' >";
					echo	"<input type='hidden' name='Title' value='$Title'/>";
					echo    "<input type='hidden' name='client' value='$client'/>";
					echo    "<input type='hidden' name='appointmenttime' value='$clientdate'/>";
					echo "<input type='submit' id='submit' name='submit' value='accept'>";
					echo "</form>";
				echo "</div>";

				echo "<div class='cancelbutton'>";
					echo "<form id = 'cancel'  method='post' action='cancel appointment.php' >";
					echo	"<input type='hidden' name='Title' value='$Title'/>";
					echo    "<input type='hidden' name='client' value='$client'/>";
					echo    "<input type='hidden' name='appointmenttime' value='$clientdate'/>";
					echo "<input type='submit'  id='submit' style='background-color:red' name='submit' value='cancel'>";
					echo "</form>";
				echo "</div>";

			echo "</div>";
			}

	
			   
	   }else{
		   die(mysqli_connect_error());
	   }
		   
	   
	   mysqli_close($conn);
	   ?>

	
			
							
	


   
   
   
   
   
 
 










</body>
	

</html>