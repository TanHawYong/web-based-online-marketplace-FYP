<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>schedule page</title>
	   <link rel="stylesheet" href="css/schedule page.css" />
	   <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	   <script>src="jquery.js"</script>
	   
	   
	   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
	   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

	   <?php include "Server_Access.php"; ?>
	</head>

	<section class="header">
		<?php include "header.php"; ?>
	</section>

	<?php
		$Title = $_SESSION["title"];
		$conname = $_SESSION["consultantname"];
		$duration = $_SESSION["duration"];
		$restday = $_SESSION["restday"];
		//echo "<p id='title'>Title : $Title</p>";
		//echo "<p id='consultant' value=$conname >Consultant: $conname</p>";
	?>
	<body>		

	<script>
	  $(function() {

		var days = "<?php echo"$restday"?>";
		var daysArray=days.split(',');

		for (day in daysArray ) {
			daysArray[day] = parseInt(daysArray[day], 10);
		}

		$('#prefereddate').datepicker({
			dateFormat: 'yy-mm-dd',
			beforeShowDay: disabledaysfor,
			minDate: 2,
		});

		function disabledaysfor(date) {
			var day = date.getDay();
			for (i = 0; i < daysArray.length; i++) {
				if ($.inArray(day, daysArray) != -1) {
					return [false];
				}
			}
			return [true];
		}
		});

		$('#preferedtime').timepicker({

		});

   </script>
<div class='scheduler'>
	<div class="servicedetails">
	   <?php
	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   
	   if($conn){			
		   $sql1 = "SELECT * FROM service_profile WHERE Title='$Title'";
		   $result = $conn->query($sql1);
		   
		   if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {

				$dt1=new Datetime($row['StartWorkHour']);
				$time1 = $dt1->format('h:i A');
 
				$dt2=new Datetime($row['EndWorkHour']);
				$time2 = $dt2->format('h:i A');
			   

			   echo "<br><br>Title : " . $row["Title"]. "<br>";
			   echo "Your consultant : " . $row["Username"]. "<br><br>";
			   echo "Description : " . $row["Detail"]. "<br><br>";
			   echo "Duration : " . $row["Duration"]. "<br>";
			   echo "Rating : " . $row["Rating"]. "<br>";
			   echo "WorkHour : from " . $time1.  " to ";
			   echo "" . $time2. "<br>";

			   $days = [
				0 => 'Sunday',
				1 => 'Monday',
				2 => 'Tuesday',
				3 => 'Wednesday',
				4 => 'Thursday',
				5 => 'Friday',
				6 => 'Saturday'
			  ];

			   $offday = $row["offday"];
			   $offdayarray = explode(",",$offday);
			   echo "Unavailable on : ";
			   foreach($offdayarray as $day){
					echo $days[date($day)] ;
					echo " ";
			   }
		   
			   echo "<br>Price : RM " . $row["Price"]. ".00<br>";

			 }
		   } else {
			 echo "0 results";
		   }
			   
	   }else{
		   die(mysqli_connect_error());
	   }
	   

	   ?>					
   </div> 


	<script>//ajax
		$(document).ready(function(){
			$("button").click(function(){
				var date = new Date($('#bookdate').val()).toISOString();
				var consultant = "<?php echo "$conname" ?>";

				$("#bookedtime").load("load-bookedtimes.php", {
						checktime: date,
						checkconsultant:  consultant
				});

			});

		});
		
	</script>

	

	<div class="bookedtimecontainer" id="bookedtimecontainer">
	<br><br>
	<label for='Date'>Please choose a date: </label>
	<input type='date' id='bookdate' name='bookdate'>
	
	<button> check if available</button>
	<br>
	Below are the already booked time by other customers:
	<br><br>
	<div class="bookedtime" id="bookedtime">
		
		<?php
		$sql= "SELECT * FROM order_detail";
		$result=mysqli_query($conn,$sql);

		//reformat date

		if(mysqli_num_rows($result)>0){
			while($row= mysqli_fetch_assoc($result)){
				$dt1=new Datetime($row['AppointmentTimeStart']);
				$time1 = $dt1->format('h:i: A');
				$dt2=new Datetime($row['AppointmentTimeEnd']);
				$time2 = $dt2->format('h:i A');
			}
		}else{
			echo "No booked dates";
		}
		?>
	</div>
	
	</div>

	
	

	<div class='purchasedetail'>
	<form id = "purchasedetail"  method="post" action="schedulecheck.php" >
					<br><br>
					<!--<label for="preferedtime">please enter your prefered time: </label>-->
					<!--<input type="datetime-local" id="preferedtime" name="preferedtime" step="any"><br>-->
					<tr><td><label>Select Date: </label>
        			</td><td><input type='text' id='prefereddate' name='prefereddate' placeholder="select date" required/>
					</p>
					<p>
					<tr><td><label>Select Time: </label>
					<?php
						//echo "<input type='time' id='myTime' min='$_SESSION['starthour']' max='$_SESSION['starthour']'>";
						$starthour = $_SESSION['starthour'];
						$endhour = $_SESSION['endhour'];
						echo "</td><td><input type='time' id='preferedtime' name='preferedtime' min='$starthour' max='$endhour' step='any' required> ";
					?>
        					

					</p>
					<p>
					<tr><td><label for="Medium">Medium:</label>
					</td><td><input type="text" id="Medium" name="Medium" required>
					</p>
					<p>
					<tr><td><label for="Special">Special Requests: </label>
					</td><td><input type="text" id="Special" name="Special"><br><br>
					<?php
						echo	"<input type='hidden' name='Title' value='$Title'/>";
						echo	"<input type='hidden' name='consultantname' value='$conname'/>";
						echo	"<input type='hidden' name='duration' value='$duration'/>";
						echo	"<input type='hidden' name='username' value='$uname'/>";
					?>

					
					</td><td><input class="submit" type="submit" id="submit" value="enter">
					 
					
	</form>
	</div>


</div>
	</body>

</html>