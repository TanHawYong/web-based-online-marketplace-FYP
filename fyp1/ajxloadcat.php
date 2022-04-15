<?php 

	include "Server_Access.php";
	
	$Categoryname = 0;
	
	if(isset($_POST['Category'])){
	   $Categoryname = mysqli_real_escape_string($con,$_POST['Category']); // category id
	}
	
	$subcat_arr = array();
	
	if($Categoryname > 0){
	   $sql = "SELECT SubCategory FROM service_sub_category WHERE Category=".$Categoryname;
	
	   $result = mysqli_query($con,$sql);
	
	   while( $row = mysqli_fetch_array($result) ){
		  $subCategory = $row['SubCategory'];
	
		  $subcat_arr[] = array("SubCategory" => $subCategory);
	   }
	}
	// encoding array to json format
	echo json_encode($subcat_arr);