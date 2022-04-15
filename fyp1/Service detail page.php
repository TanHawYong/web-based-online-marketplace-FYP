<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Service detail page</title>
	   <link rel="stylesheet" href="css/Service detail page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
				
			
	<body>
		<section class="header">
			<?php include "header.php"; ?>
		</section>



	
	<?php		
	   $selectedTitle =$_SESSION["title"];
	   echo "<h2 style='margin-left:2em;margin-top:2em'><u>$selectedTitle</u><br></h2>";
	?> 
   
   <div class="servicedetailcontainer">
   <div class="Thumbnail">
   <?php
   
   $selectedTitle =$_SESSION["title"];
   
   $conn = mysqli_connect("localhost","root","","sixerr_db");
   
   if($conn){			
	   $sql = "SELECT Img_directory FROM service_profile WHERE Title='$selectedTitle'";
	   $result = $conn->query($sql);
	   
	   if ($result->num_rows > 0) {
		 // output data of each row
		 while($row = $result->fetch_assoc()) {
			echo "<img class='thumbnail' src='$row[Img_directory]' height='508'>";
		 }
	   }else{
		 echo "0 results";
	   }
		   
	}else{
		die(mysqli_connect_error());
    }
	   
   
   			mysqli_close($conn);
   		?>	
			
   </div>

   <div class="Category">	
	   <?php
   
	   $selectedTitle =$_SESSION["title"];
	   
	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   
	   if($conn){			
		   $sql = "SELECT * FROM service_profile WHERE Title='$selectedTitle'";
		   $result = $conn->query($sql);
		   
		   if ($result->num_rows > 0) {
			 // output data of each row
			 while($row = $result->fetch_assoc()) {
			   $categoryid = $row["Category"];
			   $subcategory1id = $row["SubCategory1"];
			   $subcategory2 = $row["SubCategory2"];

			   $sqlcat= "SELECT Category from service_category WHERE id = $categoryid";
			   $rescat=mysqli_query($conn,$sqlcat);
			   while($catrow= $rescat->fetch_assoc()){
				   $category=$catrow['Category'];
					echo "Category : $category";
			   };

			   $sqlsubcat= "SELECT SubCategory from service_sub_category WHERE id = $subcategory1id";
			   $ressubcat=mysqli_query($conn,$sqlsubcat);
			   while($subcatrow= $ressubcat->fetch_assoc()){
				   $subcategory=$subcatrow['SubCategory'];
					echo ", $subcategory";
			   };			   

			   
			   echo ", " . $row["SubCategory2"]. "<br>";

			 }
		   } else {
			 echo "0 results";
		   }
			   
	   }else{
		   die(mysqli_connect_error());
	   }
		   
	   
	   mysqli_close($conn);
	   ?>					
   </div> 
   <br><br>
   
   <div class="servicedetails">	
	   <?php
   
	   $selectedTitle =$_SESSION["title"];
	   
	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   
	   if($conn){			
		   $sql = "SELECT * FROM service_profile WHERE Title='$selectedTitle'";
		   $result = $conn->query($sql);
		   
		   if ($result->num_rows > 0) {
			 while($row = $result->fetch_assoc()) {
			   
			   echo "Your consultant : " . $row["Username"]. "<br><br>";
			   echo "Description : " . $row["Detail"]. "<br><br>";
			   echo "Duration : " . $row["Duration"]. " minutes <br>";
			   echo "Rating : " . $row["Rating"]. "<br>";

			   $dt1=new Datetime($row["StartWorkHour"]);
			   $time1 = $dt1->format(' h:i A');
			   $dt2=new Datetime($row["EndWorkHour"]);
			   $time2 = $dt2->format(' h:i A');

			   echo "Availability :  $time1   to ";
			   echo " $time2 <br>";

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
					echo $days[date($day)];
					echo " ";
			   }

			   echo "<br>Price : RM " . $row["Price"]. ".00<br>";

			 }
		   } else {
			 echo "0 results";
		   }
			   
	   }else{die(mysqli_connect_error());}   
	   mysqli_close($conn);
	   ?>					
   </div> <br><br>
   <div class="dynamicbutton">
		<?php
			
			$selectedTitle =$_SESSION["title"];
			$selectedConsultant =$_SESSION["consultantname"];
			$duration=$_SESSION["duration"];
			$conn = mysqli_connect("localhost","root","","sixerr_db");
			
			if($conn){			
				
				if(empty($_SESSION['Username'])){	
					echo "<form action='RegistrationLogin page.php' method='post' name='dynamicAction'  >
					<button class='submit' type='submit' value='client'>Login as client</button>									  
					</form>";					
						
				}else{						
						$purchased =false;
						$currUser=$_SESSION['Username'];
						
						$sql = "SELECT * FROM user_profile WHERE username='$uname' AND IsConsultant= '1' ";
						$result = $conn->query($sql);
						//check if the person is an consultant or consultee
						
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()){							
								if($currUser == $row["Username"]){
									$purchased = true;
									echo "<form action='RegistrationLogin page.php' method='post' name='dynamicAction'  >
									<button class='submit' type='submit' value='client'>Login as client</button>									  
									</form>";	 
								}					
							}

						} else{
							echo "<form action='Schedule page.php' method='post' name='dynamicAction'  >
							<button class='submit' type='submit' value='purchase'>Purchase</button>
							<input type='hidden' name='Title' value='$selectedTitle' />	
							<input type='hidden' name='consultantname' value='$selectedConsultant' />		
							<input type='hidden' name='duration' value='$duration' />	
							</form>";	
						}
									
						  
														
				}

					
			}else{
				die(mysqli_connect_error());
			}
			
			mysqli_close($conn);
	
		?>
		</div>
		</div>
		<br><br>
    <div class="tab">
		<button class="tablinks" onclick="opentab(event, 'Reviews')">Reviews</button>
		<button class="tablinks" onclick="opentab(event, 'DiscussionTitles')">DiscussionTitles</button>
	</div>

   <div id="Reviews" class="tabcontent">
	   <?php
		echo "<br>Reviews<br><br>";
	   $selectedTitle =$_SESSION["title"];
	   
	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   
	   if($conn){			
		   $sql = "SELECT * FROM review WHERE Title='$selectedTitle'";
		   $result = $conn->query($sql);
		   
		   if ($result->num_rows > 0) {
			 while($row = $result->fetch_assoc()) {
			   $Date = date("Y/m/d", strtotime($row['TimeReview']));
			   $user = $row["Username"];
			   $review = $row["Review"];
			   echo "User: $user<br>"; 
			   echo "Date: $Date <br> ";
			   echo "$review <br><br>" ;
			 }
		   } else {
			 echo "No reviews";
		   }
			   
	   }else{
		   die(mysqli_connect_error());
	   }
		   
	   
	   mysqli_close($conn);
	   ?>
	</div>




	<div id="DiscussionTitles" class="tabcontent">
	   <?php
		echo "<br>Discussions<br>";
	   $selectedTitle =$_SESSION["title"];
	   ?>

	   <?php
		//create new discussion
	   echo "<form action='create_discussion.php' method='post'>
			 <input type='text' id='discustitle' name='discustitle'>
			 <input type='hidden' name='Title' value='$selectedTitle' />	
	   		 <button type='submit' >Create new discussion</button>	
		     </form>";
	   
	   $conn = mysqli_connect("localhost","root","","sixerr_db");
	   


	   //load existing discussions
	   if($conn){			
		   $sql = "SELECT * FROM discussion_board WHERE Title='$selectedTitle'";
		   $result = $conn->query($sql);
		   
		   if ($result->num_rows > 0) {
	
			 while($row = $result->fetch_assoc()) {
				$boardtitle = $row['BoardTitle'];
				$servicetitle = $row['Title'];

			   echo "<form action='loadsessionvalues (discussionboard).php' method='post'>
					<input type='hidden' name='boardtitle' value='$boardtitle'/>
					<button type='submit' style='border:none;background:none' ><u> $boardtitle</u> </button>
					</form>";

			 }
		   } else {
			 echo "0 results<br><br>";
		   }
			   
	   }else{
		   die(mysqli_connect_error());
	   }
		   
	   
	   mysqli_close($conn);
	   ?>
	</div>






</br>

<script>
function opentab(evt, tabvalue) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabvalue).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

</body>
	

</html>