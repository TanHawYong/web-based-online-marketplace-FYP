<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Home page</title>
	   <link rel="stylesheet" href="css/Home page.css" />
	   <?php include "Server_Access.php"; $_SESSION['appointments']='empty'; $purchasehistory = false; $exclude = 'none';?>
	</head>
	
	<body>
	<section class="header">		 
			<?php include "header.php"; ?>
	</section>
	


	<?php
		$todaydate=date("Y-m-d H:i:s");
		if($_SESSION['Consultant'] == 'true'){
			$sql = "SELECT order_detail.* FROM order_detail INNER JOIN service_profile ON order_detail.Title = service_profile.Title 
			WHERE service_profile.Username = '$uname' AND order_detail.AppointmentTimeStart > '$todaydate' ORDER BY order_detail.AppointmentTimeStart LIMIT 3";
		}else{
			$sql = "SELECT * FROM order_detail WHERE Username = '$uname' AND order_detail.AppointmentTimeStart > '$todaydate' ORDER BY AppointmentTimeStart LIMIT 3";
		}
			
			echo "<div class='reminder'>";
			echo "Upcoming Appointments <br><br>";

	   
	   		$result = mysqli_query($conn,$sql);
	   
	   		if($conn){			
				if(mysqli_num_rows($result)>0){
					while ($row = mysqli_fetch_assoc($result)){
						$_SESSION['appointments']='exist';
						$datas[] = $row;
					}
				

					foreach($datas as $data){
						echo "<div class='title'><u>". $data["Title"]. "</u><br></div>";
						$client = $data['Username'];
						echo "Client :  $client  ";
					
						$clientdate = $data['AppointmentTimeStart'];
						$dt1=new Datetime($data['AppointmentTimeStart']);
						$time1 = $dt1->format('  Y-m-d h:i A');
						$dt2=new Datetime($data['AppointmentTimeEnd']);
						$time2 = $dt2->format('h:i A');
						
						echo "<br>". $time1. " - ";
						echo "". $time2. "";
		
						echo "<div class='status'>";
						echo "   Status : ". $data["OrderStatus"]. "";
						if($data["OrderStatus"] == "pending"){
							echo "⌛";
						}else if ($data["OrderStatus"] == "confirmed"){
							echo "✔️";
						}else{
							echo "❌";
						}
						echo "</div> <br>";
					}
					
				}
			   
			}else{
				die(mysqli_connect_error());
			}

		

		
		echo "</div>";
		unset($result);unset($datas);unset($data);
	?>
	

	<?php
		if($_SESSION['Consultant'] == 'true'){
			
			echo " <h3>&nbsp;&nbsp;&nbsp;&nbsp;Your services : </h3>";
			echo " <div class ='yourservices'>";	
			$uname = $_SESSION['Username'];
			$sql = "SELECT * FROM service_profile WHERE Username = '$uname';";
			$result = mysqli_query($conn,$sql);
			$datas = array();
			
			if($conn){
				if(mysqli_num_rows($result)>0){
					while ($row = mysqli_fetch_assoc($result)){
						$datas[] = $row;
					}
				}



				foreach($datas as $data){
					$image = $data['Img_directory'];
					$title = $data['Title'];
					$servicestatus= $data['ServiceStatus'];
					//echo "<br>";
			
						echo "<div class= leftImg>";
						echo "<form id='service' method='post' action='loadsessionvalues (editservice).php'>";
						echo "<label for='imageService'>$title  <br>&nbsp&nbsp; Status : </label>";
						if($servicestatus == 'active'){echo "✔️ Active";}else{echo "⌛ Pending ";};
						echo "<input type='hidden' class = 'servicestatus' id='servicestatus' name ='servicestatus' value=$servicestatus>";
						echo "<input type='hidden' class = 'imageDir' id='serviceImgDir' name ='ServiceTitleImg' value='".$data['Img_directory']."'>";

						echo "<button id='".$title."' class='imageService' name ='ServiceTitle' value='".$data['Title']."' ><img src='".$image."' /></button>";

						echo "</form>";	
						echo "</div>";		

					//	echo "<br>";		
			
				}
				echo "<div class='addservice'>";
				echo "<form id='service' method='post' action='Create service page.php'>";
				echo "<label for='imageService'></label>";
				echo "<button class='imageService' name ='ServiceTitle' style='height:9em;width:9em; margin-top:7em;'>
					 <img style='height:8em;width:8em;' src='../fyp1/images/plusicon.png' /></button>";			
				echo "</form>";	
				echo "</div>";
				
				


				echo "</div>";
				
			}else{
				die(mysqli_connect_error());
			}


		
			echo "</div>";
		
	}elseif($_SESSION['Consultant'] == 'true'){
		echo " <br><br><div class ='yourservices'>";
		echo "<h4>Your services: <br><br>Please create your service in the 'Your services' tab above.</h4>";
		echo " </div><br>";
	}
	?>


	<div class="FeaturedPurchaseHistoryContainer">
		<?php	
		if($_SESSION['purchasability'] == 'true'){
							//return the category that is most purchased by the user
			$sql ="SELECT service_profile.Category
			FROM order_detail INNER JOIN service_profile ON order_detail.Title =  service_profile.Title WHERE order_detail.Username='$uname'
			Group BY order_detail.Title 
			ORDER By Count(service_profile.Category) DESC LIMIT 1";
			

			$result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){
				while($row= mysqli_fetch_assoc($result)){
					$mostpurchasedcategory = $row['Category'];
					$purchasehistory = true;
				}
			}
			unset($datas);unset($result);unset($data);
			
			if($purchasehistory == true){
				echo "<h3>Featured based on your previous purchases :</h3>";
				$sql ="SELECT * FROM `service_profile` WHERE Category = '$mostpurchasedcategory' ORDER BY Rating DESC LIMIT 3";
	
				$result=mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)>0){
					
					while($row= mysqli_fetch_assoc($result)){
	
						$image = $row['Img_directory'];$title = $row['Title'];$consultantname = $row['Username'];$duration = $row['Duration'];
						$restday = $row['offday'];$starthour = $row['StartWorkHour'];$endhour = $row['EndWorkHour'];
	
						echo "<div class= Featured>";
						echo "<form id='service' method='post' action='loadsessionvalues.php'>";
						echo "<label for='imageService' >$title</label><br>";
						echo "<button id='".$title."' class='imageService' name ='ServiceTitle' value='".$row['Title']."' ><img src='".$image."' /></button>";
						echo "<input type='hidden' class = 'consultantname' id='consultantname' name ='consultantname' value='".$consultantname."'>";
						echo "<input type='hidden' class = 'duration' id='duration' name ='duration' value='".$duration."'>";
						echo "<input type='hidden' class = 'workhour' id='restday' name ='restday' value='".$restday."'>";
						echo "<input type='hidden' class = 'starthour' id='starthour' name ='starthour' value='".$starthour."'>";
						echo "<input type='hidden' class = 'endhour' id='endhour' name ='endhour' value='".$endhour."'>";
						echo "<input type='hidden' class = 'imageDir' id='serviceImgDir' name ='ServiceTitleImg' value='".$row['Img_directory']."'>";
						echo "</form>";	
						echo "</div>";
	
					}
				}else{
					echo "error";
					
				}	

			}
			unset($datas);unset($result);unset($data);
		}

		if($purchasehistory == true){
			echo   
			"<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
			<a class='next' onclick='plusSlides(1)'>&#10095;</a>
		
			<div style='text-align:center'>
			<span class='dot' onclick='currentSlide(1)'></span> 
			<span class='dot' onclick='currentSlide(2)'></span> 
			<span class='dot' onclick='currentSlide(3)'></span> 
			</div>";
		}
		?>
	</div>





<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("Featured");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

	<div class="FeaturedSearchHistoryContainer">
	

	<div class="FeaturedSearchHistory">
		<?php
		    $arrayresult=array('0'); 
			$sql = "SELECT * FROM `keyword_search` WHERE Username = '$uname'";
			$result = mysqli_query($conn,$sql);
			$datas = array();
			
			if($conn){
				if(mysqli_num_rows($result)>0){
					while ($row = mysqli_fetch_assoc($result)){
						$datas[] = $row;
					}
				}
			
				foreach($datas as $data){	
					$keywordsearch = $data['Searches'];
					$sql = "SELECT * FROM service_profile WHERE Title LIKE '%$keywordsearch%'";
					$res = mysqli_query($conn,$sql);
					if(mysqli_num_rows($res)>0){
						while ($row = mysqli_fetch_assoc($res)){
							$arrayresult[] = $row['Title'];
						}

						
					}
				}

				unset($result);unset($data);unset($datas);


				$values = array_count_values($arrayresult);
				arsort($values);
				$filteredsearchtitle = array_slice(array_keys($values), 0, 2, true);
				$featuredtitle = $filteredsearchtitle[0];

				$sql="SELECT * FROM service_profile WHERE Title = '$featuredtitle'";
				$result=mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)>0){			
					while($row= mysqli_fetch_assoc($result)){
						echo "<h3 style='color:white;'>Recommended based on your previous searches<h3>";
						$image = $row['Img_directory'];$title = $row['Title'];$consultantname = $row['Username'];$duration = $row['Duration'];
						$restday = $row['offday'];$starthour = $row['StartWorkHour'];$endhour = $row['EndWorkHour'];
						$desc =   $row['Detail'];
	
						echo "<div class= FeaturedSearch>";
						echo "<form id='service' method='post' action='loadsessionvalues.php'>";
						echo "<button id='".$title."' class='imageService' name ='ServiceTitle' value='".$row['Title']."' ><img src='".$image."' /></button>";
						echo "<input type='hidden' class = 'consultantname' id='consultantname' name ='consultantname' value='".$consultantname."'>";
						echo "<input type='hidden' class = 'duration' id='duration' name ='duration' value='".$duration."'>";
						echo "<input type='hidden' class = 'workhour' id='restday' name ='restday' value='".$restday."'>";
						echo "<input type='hidden' class = 'starthour' id='starthour' name ='starthour' value='".$starthour."'>";
						echo "<input type='hidden' class = 'endhour' id='endhour' name ='endhour' value='".$endhour."'>";
						echo "<input type='hidden' class = 'imageDir' id='serviceImgDir' name ='ServiceTitleImg' value='".$row['Img_directory']."'>";
						echo "</form>";	
						echo "</div>";

						echo "<label style='color:white;text-align:center'>  $title style<br> $desc</label>";
						$exclude=$title;
					}
				}


				
			}
			else{
				die(mysqli_connect_error());
			}	

			unset($result);unset($data);unset($datas);unset($arrayresult);
		?>
		</div>
	</div>



	<?php
		if(isset($_POST['search'])){
			$search=$_POST['search'];
			//check for number of searches
			$sql = "SELECT * FROM keyword_search WHERE Username='$uname'";
			$result=mysqli_query($conn,$sql);

			if(mysqli_num_rows($result)> 4){

				$sql = "DELETE FROM `keyword_search` WHERE Username='$uname' ORDER BY Timeofsearch ASC LIMIT 1 ";
				mysqli_query($conn,$sql);
				
			}	
			unset($result);unset($data);

			//save searches
			$sql = "INSERT INTO `keyword_search`(`Username`, `Searches`, `Timeofsearch`) VALUES ('$uname','$search',now())";
			mysqli_query($conn,$sql);


			$sql = "SELECT * FROM service_profile WHERE ServiceStatus = 'active' AND Title LIKE '%$search%';";
			echo "<h2 style='margin-left:2em;'>Search result : </h2>";
		}elseif($exclude != 'none'){
			$sql = "SELECT * FROM service_profile WHERE ServiceStatus = 'active' AND Title != '$exclude'";
		}else{
			$sql = "SELECT * FROM service_profile WHERE ServiceStatus = 'active';";
		}		
	?>
	<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; more consulting services :  </h3>
	<div class ='serviceButtons'>
		<?php	
			$result = mysqli_query($conn,$sql);
			$datas = array();
			
			if($conn){
				if(mysqli_num_rows($result)>0){
					while ($row = mysqli_fetch_assoc($result)){
						$datas[] = $row;
					}
				}
			
				foreach($datas as $data){
					$image = $data['Img_directory'];
					$title = $data['Title'];
					$consultantname = $data['Username'];
					$duration = $data['Duration'];
					$restday = $data['offday'];
					$starthour = $data['StartWorkHour'];
					$endhour = $data['EndWorkHour'];

						echo "<div class= Img>";
						echo "<form id='service' method='post' action='loadsessionvalues.php'>";
						echo "<label for='imageService' >$title</label><br>";
						echo "<button id='".$title."' class='imageService' name ='ServiceTitle' value='".$data['Title']."' ><img src='".$image."' /></button>";
						echo "<input type='hidden' class = 'consultantname' id='consultantname' name ='consultantname' value='".$consultantname."'>";
						echo "<input type='hidden' class = 'duration' id='duration' name ='duration' value='".$duration."'>";
						echo "<input type='hidden' class = 'workhour' id='restday' name ='restday' value='".$restday."'>";
						echo "<input type='hidden' class = 'starthour' id='starthour' name ='starthour' value='".$starthour."'>";
						echo "<input type='hidden' class = 'endhour' id='endhour' name ='endhour' value='".$endhour."'>";
						echo "<input type='hidden' class = 'imageDir' id='serviceImgDir' name ='ServiceTitleImg' value='".$data['Img_directory']."'>";
						echo "</form>";	
						echo "</div>";				
				
				}
				
			}
			else{
				die(mysqli_connect_error());
			}
		?>
	</div>
	</body>

</html>