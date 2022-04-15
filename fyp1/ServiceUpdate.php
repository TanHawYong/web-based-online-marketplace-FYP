<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	$UserName=$_POST['Username'];
	$Title=htmlspecialchars($_POST['servicetitle']);
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

		if($catvalue == $exist1){
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

		if($subcatvalue == $exist2){
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

		if($subcatvalue == $exist2){
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
	



	
		$fileNameNew = uniqid('', true).".".$fileActualExt;
		$path = "images/".$fileName;
		move_uploaded_file($fileTmpName,$path);
		$img=$path;
	
	
	if($conn){   
		if($img == 'images/'){
			$sql = "UPDATE `service_profile` SET 
			`Title`='$Title',`Detail`='$Detail',`Username`='$UserName',`Duration`='$Duration',
			`Price`='$Price',`StartWorkHour`='$StartHour',`EndWorkHour`='$EndHour',
			`offday`='$WorkDays' WHERE `Title`='$Title'";
		}else{
			$sql = "UPDATE `service_profile` SET 
			`Title`='$Title',`Detail`='$Detail',`Username`='$UserName',`Img_directory`='$img',`Duration`='$Duration',
			`Price`='$Price',`StartWorkHour`='$StartHour',`EndWorkHour`='$EndHour',
			`offday`='$WorkDays' WHERE `Title`='$Title'";
		}
		mysqli_query($conn,$sql);
		if($catvalue != "0"){
			$sql = "UPDATE `service_profile` SET `Category`='$catvalue' WHERE `Title`='$Title'";
			mysqli_query($conn,$sql);
		}
		if($subcatvalue != "0"){
			$sql = "UPDATE `service_profile` SET `SubCategory1`='$subcatvalue' WHERE `Title`='$Title'";
			mysqli_query($conn,$sql);
		}
		if($StatusCat != "0" ){
			$sql = "UPDATE `service_profile` SET `SubCategory2`='$StatusCat' WHERE `Title`='$Title'";
			mysqli_query($conn,$sql);
		}
		

		


		echo '<script type="text/javascript">';  
		echo 'alert("Service successfully updated!");'; 
		echo 'window.location.href = "Your services page.php";';
		echo '</script>';
			

		
	}else{
		die(mysqli_connect_error());
	}
?>