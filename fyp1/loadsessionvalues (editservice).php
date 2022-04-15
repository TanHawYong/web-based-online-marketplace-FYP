<?php
 	include "Server_Access.php";

	 $_SESSION['title']=$_POST['ServiceTitle'];
	 $title=$_POST['ServiceTitle'];
	 $sql= "SELECT * FROM service_profile WHERE Title = '$title'";
	 $result=mysqli_query($conn,$sql);

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
			 $_SESSION['servicetitle'] = $data['Title'];
			 $_SESSION['servicedesc'] = $data['Detail'];
			 $_SESSION['image'] = $data['Img_directory'];
			 $_SESSION['duration'] = $data['Duration'];
			 $_SESSION['price'] = $data['Price'];
			 $_SESSION['servicestatus'] = $data['ServiceStatus'];
			 $_SESSION['startworkhour'] = $data['StartWorkHour'];
			 $_SESSION['endworkhour'] = $data['EndWorkHour'];
			 $_SESSION['offday'] = $data['offday'];
			 $_SESSION['category'] = $data['Category'];
			 $_SESSION['subcategory1'] = $data['SubCategory1'];
			 $_SESSION['subcategory2'] = $data['SubCategory2'];
			


		 
		 }
		 
	 }
	 else
	 {
		 die(mysqli_connect_error());
	 }


	 


	 header("Location: ../fyp1/EditService page (Consultant).php");
?>