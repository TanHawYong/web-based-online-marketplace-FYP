<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	$UserName=$_POST['Username'];
	$Email=$_POST['Email'];
	$Title=htmlspecialchars($_POST['Title']);
	$Detail=htmlspecialchars($_POST['Detail']);


	$file = $_FILES['inpFile'];
	$fileName = $_FILES['inpFile']['name'];
	$fileTmpName = $_FILES['inpFile']['tmp_name'];
	$fileExt = explode('.',$fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png','pdf');
	
	$Duration=$_POST['Duration'];
	$Price=$_POST['Price'];

	$StartHour=$_POST['StartWorkHour'];
	$EndHour=$_POST['EndWorkHour'];

	$WorkDays=$_POST['WorkingDays'];

	$Category=$_POST['sel_Category'];
	$SubCategory=$_POST['sel_SubCategory'];
	$StatusCat=$_POST['sel_StatusCategory'];

	$catvalue = $Category;
	$subcatvalue = $SubCategory;


	if($Category == "4"){
		$NewCategory=$_POST['NewCategory'];
		$NewSubCategory=$_POST['NewSubCategory'];
		$catvalue = $NewCategory;
		$subcatvalue = $NewSubCategory;

		//check if there is already a same category exist
		$sqlcategorycheck = "SELECT * FROM service_category WHERE Category = '$catvalue' ";
		$result1 = mysqli_query($conn,$sqlcategorycheck); 
		while($row = mysqli_fetch_array($result1)){
			 $exist1 = $row['Category']; 
		} 

		if($exist1){
			echo '<script type="text/javascript">';  
			echo 'alert("Category already exist");'; 
			echo 'window.location.href = "Create service page.php";';
			echo '</script>';
		}else{	
			$sql1 = "INSERT INTO `service_category`(`Category`) VALUES ('$catvalue')";      								//insert new category
			mysqli_query($conn,$sql1);

			$sqlgetcatnum= "SELECT MAX(id) AS highid from service_category;";												//get new id to assign 
			$resultscat=mysqli_query($conn,$sqlgetcatnum);
			
			while($row = mysqli_fetch_assoc($resultscat)){
				$catnumber = $row['highid'];
			}

			$catvalue = $catnumber;	 //new category id
		}

		//check if there is already a same sub category exist
		$sqlsubcategorycheck = "SELECT * FROM service_sub_category WHERE SubCategory = '$subcatvalue' ";
		$result2 = mysqli_query($conn,$sqlsubcategorycheck); 
		while($row = mysqli_fetch_array($result2)){
			 $exist2 = $row['SubCategory']; 
		}

		if($exist2){
			echo '<script type="text/javascript">';  
			echo 'alert("SubCategory already exist");'; 
			echo 'window.location.href = "Create service page.php";';
			echo '</script>';

		}else{
			$sql2 = "INSERT INTO `service_sub_category`(`SubCategory`, `Category`) VALUES ('$subcatvalue','$catnumber');";  //insert new sub category
			mysqli_query($conn,$sql2);


			$sqlgetsubcatnum= "SELECT MAX(id) AS highid from service_sub_category;";										//get new id to assign 
			$resultssubcat=mysqli_query($conn,$sqlgetsubcatnum);									
			
			while($row = mysqli_fetch_assoc($resultssubcat)){
				$subcatnumber = $row['highid'];
			}
								
			$subcatvalue =  $subcatnumber; //new sub category id
		}
			

					
		
	}else if($SubCategory == "8"){
		$NewSubCategory=$_POST['NewSubCategory'];
		$catvalue = $Category;
		$subcatvalue = $NewSubCategory;

		//check if there is already a same sub category exist
		$sqlsubcategorycheck = "SELECT * FROM service_sub_category WHERE SubCategory = '$subcatvalue' ";
		$result2 = mysqli_query($conn,$sqlsubcategorycheck); 
		while($row = mysqli_fetch_array($result2)){
			 $exist2 = $row['SubCategory']; 
		}

		if($exist2){
			echo '<script type="text/javascript">';  
			echo 'alert("SubCategory already exist");'; 
			echo 'window.location.href = "Create service page.php";';
			echo '</script>';

		}else{
			$sql3 = "INSERT INTO `service_sub_category`(`SubCategory`, `Category`) VALUES ('$subcatvalue','$catvalue');";		//insert new sub category
			mysqli_query($conn,$sql3);
	
			$sqlgetsubcatnum= "SELECT MAX(id) AS highid from service_sub_category;";											//get new id to assign
			$resultssubcat=mysqli_query($conn,$sqlgetsubcatnum);							
			
			while($row = mysqli_fetch_assoc($resultssubcat)){
				$subcatnumber = $row['highid'];
			}
			$subcatvalue =  $subcatnumber;							//new subcategory id

		}

	}
	



	if(in_array($fileActualExt,$allowed))
	{
		$fileNameNew = uniqid('', true).".".$fileActualExt;
		$path = "images/".$fileName;
		move_uploaded_file($fileTmpName,$path);
		$img=$path;
	}
	else
	{
		echo "<script>
			alert('The Service is Already Exist!');
			window.location.href='http://localhost/fyp1/Create Service page.php';
			</script>";
		
	}
	
	if($conn)
	{   
		$res = mysqli_query($conn,"SELECT COUNT(*) FROM service_profile WHERE Title = '$Title'");
		$total = mysqli_fetch_array($res);
		
		if($total[0]>0)
		{
			$detail1 = "";
			$detail2 = "";
			if ($totalU[0]>0)
			{
				$detail1 = $detail1.$uname. " is already Exist ";
			}
			
			if ($totalE[0]>0)
			{
				$detail2 = $detail2.$email. " is already Exist ";
			}
			
			$detail=$detail1."<br>".$detail2;
			
			echo "<script>
			alert('$detail');
			window.location.href='http://localhost/fyp1/RegistrationLogin page.php';
			</script>"; 
			
		}
		else
		{
			echo "inserted";

			$sql = "INSERT INTO service_profile
			(`Title`, `Detail`, `Username`, `Img_directory`, `Duration`, `Price`, `ServiceStatus`, `Rating`, `StartWorkHour`, `EndWorkHour`, `offday`, `Category`, `SubCategory1`, `SubCategory2`) VALUES 
			('$Title','$Detail','$UserName','$img','$Duration','$Price','inactive',0,'$StartHour','$EndHour','$WorkDays','$catvalue','$subcatnumber','$StatusCat')";


			mysqli_query($conn,$sql);
			echo '<script type="text/javascript">';  
			echo 'alert("Service successfully registered!");'; 
			echo 'alert("Please wait for approvement from the adminstration.");'; 
			echo 'window.location.href = "Create service page.php";';
			echo '</script>';
			

		}
	}
	else
	{
		die(mysqli_connect_error());
	}
?>


