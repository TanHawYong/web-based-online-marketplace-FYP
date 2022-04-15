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


	<div class='title'>
		<h3>Confirm appointment<h3>
	</div>

	<div class='cancelappointmentpage'>


		

   
	   <?php		
	   	$Title=$_POST['Title'];
		$client=$_POST['client'];
		$clientdate=$_POST['appointmenttime'];
		$dt1=new Datetime($clientdate);
		$time1 = $dt1->format('  Y-m-d h:i A');
		
		echo "$Title<br>";
		echo "Client : $client<br>";
		echo "Date : $time1<br><br>";


		echo "Message : <br><br>";

		echo "<form id = 'cancelmessage'  method='post' action='update appointment.php' >";
		echo 	"<input type='text' style='width:70em;height:20em;' name='message' maxlength ='255' ><br><br>";
		echo	"<input type='hidden' name='Title' value='$Title'/>";
		echo    "<input type='hidden' name='client' value='$client'/>";
		echo    "<input type='hidden' name='appointmenttime' value='$clientdate'/>";
		echo "<input type='submit'  id='submit' style='background-color:green' name='submit' value='accept'>";
		echo "</form>";
	   ?>

	</div>

</body>
	

</html>