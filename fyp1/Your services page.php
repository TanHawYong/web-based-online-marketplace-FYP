<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Your service</title>
	   <link rel="stylesheet" href="css/Home page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
	
	<body>
		<section class="header">
			<?php include "header.php"; ?>
		</section>
	<br><br>


	<a style="color:blue;margin-left:4em;;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;" href='Create service page.php'>Create New</a>
	<div class ='serviceButtons'>
		<?php
			$uname = $_SESSION['Username'];
			$sql = "SELECT * FROM service_profile WHERE Username = '$uname';";
			$result = mysqli_query($conn,$sql);
			$datas = array();
			
			if($conn)
			{
				if(mysqli_num_rows($result)>0)
				{
					while ($row = mysqli_fetch_assoc($result))
					{
						$datas[] = $row;
					}
				}
		
				foreach($datas as $data)
				{
					$image = $data['Img_directory'];
					$title = $data['Title'];
					$servicestatus= $data['ServiceStatus'];
					//echo "<br>";
			
						echo "<div class= leftImg>";
						echo "<form id='service' method='post' action='loadsessionvalues (editservice).php'>";
						echo "<label for='imageService'>$title  <br>Status : </label>";
						if($servicestatus == 'active'){echo "✔️ Active";}else{echo "⌛ Pending ";};
						echo "<input type='hidden' class = 'servicestatus' id='servicestatus' name ='servicestatus' value=$servicestatus>";
						echo "<input type='hidden' class = 'imageDir' id='serviceImgDir' name ='ServiceTitleImg' value='".$data['Img_directory']."'>";

						echo "<button id='".$title."' class='imageService' name ='ServiceTitle' value='".$data['Title']."' ><img src='".$image."' /></button>";

						echo "</form>";	
						echo "</div>";		
					//	echo "<br>";		
				
				}
				
			}
			else
			{
				die(mysqli_connect_error());
			}

			
		?>
	</div>
	</body>


</html>