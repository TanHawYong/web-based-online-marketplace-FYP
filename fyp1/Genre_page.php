<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>Genre</title>
	   <link rel="stylesheet" href="css/Home page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
	
	<body>
		<section class="header">
			<?php include "header.php"; ?>
		</section>
	</div>


	<?php
		$genre = $_GET['genre'];
		$subcat = $_GET['subcat'];
		$label = $_GET['label'];
		echo "<h2> Services with genre labeled:  $label</h2>";

	?>
	
	
	<div class ='serviceButtons'>
		<?php
			if($subcat == 'true'){
				$sql = "SELECT * FROM service_profile WHERE ServiceStatus = 'active' AND SubCategory1 = $genre";
			}else{	
				$sql = "SELECT * FROM service_profile WHERE ServiceStatus = 'active' AND Category= $genre";
			}
			
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
				$i=1;
				foreach($datas as $data)
				{
					$image = $data['Img_directory'];
					$title = $data['Title'];
					$consultantname = $data['Username'];
					$duration = $data['Duration'];
					$restday = $data['offday'];
					$starthour = $data['StartWorkHour'];
					$endhour = $data['EndWorkHour'];

						echo "<div class= leftImg>";
						echo "<form id='service' method='post' action='loadsessionvalues.php'>";
						echo "<label for='imageService'>$title</label><br>";
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
			else
			{
				die(mysqli_connect_error());
			}
		?>
	</div>
	</body>

</html>