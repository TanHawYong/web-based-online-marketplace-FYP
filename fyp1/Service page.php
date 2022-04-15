<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Wap Games</title>
   <link rel="stylesheet" href="gamedetail_style.css" /> 
</head>
	<?php include "Server_Access.php"; ?>
	<img src="images/sixerrlogo.png" alt="sixerr logo" width="250" height="250">
	<?php include "header.php"; ?>
<body>

	 
     <!-- move this header into PHP to reuse-->
	<!-- img source , price , dev email , dev username , -->
	<!-- trymake thumbnails database -->
    
		<?php
			
		?>
	
	
        <!--sliding Image thumbnails-->
        <h2>
			<?php		
			$selectedTitle =$_POST['ServiceTitle'];

			$conn = mysqli_connect("localhost","root","","sixerr_db");
			
			if($conn){			
				$sql = "SELECT Title FROM service_profile WHERE Title='$selectedTitle'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
				  // output data of each row
				  $row = $result->fetch_assoc() ;
					echo "Service Title <br><u>". $row["Title"]. "</u><br>";
				  
				} else {
				  echo "0 results";
				}
					
			}else{
				die(mysqli_connect_error());
			}
				
			
			mysqli_close($conn);
			?>
		
		
		</h2>
        
 	
        <div class="price">	
            <?php
		
			$selectedTitle =$_POST['ServiceTitle'];
			
			$conn = mysqli_connect("localhost","root","","sixerr_db");
			
			if($conn){			
				$sql = "SELECT Price FROM service_profile WHERE Title='$selectedTitle'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
					echo "Price : RM " . $row["Price"]. ".00<br>";
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
        
        <div class="Description">
			<?php
			
				$selectedTitle =$_POST['ServiceTitle'];
				
				$conn = mysqli_connect("localhost","root","","sixerr_db");
				
				if($conn){			
					$sql = "SELECT Detail FROM service_profile WHERE Title='$selectedTitle'";
					$result = $conn->query($sql);
					
					if ($result->num_rows > 0) {
					  // output data of each row
					  while($row = $result->fetch_assoc()) {
						echo "Description : " . $row["Detail"]. "<br>";
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
  
		
		<div class="revbutton">
		<?php
			
			$selectedTitle =$_POST['ServiceTitle'];
			$selectedTitleimg = $_POST['ServiceTitleImg'];
			$conn = mysqli_connect("localhost","root","","sixerr_db");
			
			if($conn){			
				
				if(empty($_SESSION['Username'])){	
						echo     "<form action='Register.php' method='post' name='dynamicAction'  >
								 <button type='submit' value='purchase'>Register</button>
								 <input type='hidden' name='Title' value='$selectedTitle' />								 
								 <input type='hidden' name='Titleimg' value='$selectedTitleimg' />								 
								  </form>";					
						
				}else{						
						$purchased =false;
						$currUser=$_SESSION['Username'];
						
						$sql = "SELECT Username FROM order_detail WHERE ServiceTitle='$selectedTitle'";
						$result = $conn->query($sql);
						//check if game is purchased or not
						
						if ($result > 0) {
							while($row = $result->fetch_assoc()){							
								if($currUser == $row["Username"]){
									echo "<form action='Review.php' method='post' name='dynamicAction'  >
										  <button type='submit' value='Review'>Review</button>
										  <input type='hidden' name='Title' value='$selectedTitle' />
										  <input type='hidden' name='Titleimg' value='$selectedTitleimg' />
									      </form>";
									$purchased = true;
								}						
							}
							if($purchased==false){
									 echo "<form action='Payment.php' method='post' name='dynamicAction'  >
									  <button type='submit' value='purchase'>Purchase</button>
									  <input type='hidden' name='Title' value='$selectedTitle' />	
									  <input type='hidden' name='Titleimg' value='$selectedTitleimg' />									  
									  </form>";	
							}

						} else if($purchased==false){
									 echo "<form action='Payment.php' method='post' name='dynamicAction'  >
									  <button type='submit' value='purchase'>Purchase</button>
									  <input type='hidden' name='Title' value='$selectedTitle' />	
									  <input type='hidden' name='Titleimg' value='$selectedTitleimg' />	
									  </form>";	
						  
						}										
				}

					
			}else{
				die(mysqli_connect_error());
			}
			
			mysqli_close($conn);
	
		?>
		</div>
  
    </br>
    <!-- move this footer into PHP to reuse-->
    

</body>
</html>