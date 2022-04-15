<?php

	
	$conn = mysqli_connect("localhost","root","");
	if($conn)
	{
		
		$sql= "CREATE DATABASE sixerr_db";
		
		if(mysqli_query($conn,$sql))
			echo "Database have Create";
		else
			echo "fail to create a Database";
	}
	else
	{
		die(mysqli_connect_error());
	}
	
	
	
	$conn = mysqli_connect("localhost","root","","sixerr_db");
	
	if($conn)
	{
		
		//Create table
		
		//user_profile table
		$sql="CREATE TABLE user_profile (Username VARCHAR(50), Password VARCHAR(50),Email VARCHAR(50),IsConsultant BOOLEAN, 
										Status VARCHAR(10), Company VARCHAR(50), JobPos VARCHAR(50))";
		mysqli_query($conn,$sql);
		
		//order_detail table
		$sql="CREATE TABLE order_detail (Title VARCHAR(50),Username VARCHAR(50), Medium VARCHAR(50), AppointmentTimeStart DATETIME(6),
						   				 AppointmentTimeEnd DATETIME(6), OrderStatus VARCHAR(10), SpecialReq VARCHAR(255), 
										 ClientComplete BOOLEAN, ConsultantComplete BOOLEAN)";
		mysqli_query($conn,$sql);
		
		//service_profile Table
		$sql="CREATE TABLE service_profile (Title VARCHAR(50),Detail VARCHAR(255),Username VARCHAR(50),Img_directory VARCHAR(255),Duration TIME,
											Price INT(4),ServiceStatus VARCHAR(10), Rating INT(4), StartWorkHour TIME, EndWorkHour TIME ,
											WorkingDays VARCHAR(10), Category VARCHAR(50), SubCategory1 VARCHAR(50), SubCategory2 VARCHAR(50))";
		mysqli_query($conn,$sql);
		
		//review Table
		$sql="CREATE TABLE review (Title VARCHAR(50),UserName VARCHAR(50),Review VARCHAR(50), RatingGiven INT(4), TimeReview DATETIME(6))";
		mysqli_query($conn,$sql);
		
		//service_category Table
		$sql="CREATE TABLE service_category (Category VARCHAR(50))";
		mysqli_query($conn,$sql);

		//service_sub_category Table
		$sql="CREATE TABLE service_sub_category (Category VARCHAR(50), subCategory VARCHAR(50))";
		mysqli_query($conn,$sql);	
		
		//discussion_board Table
		$sql="CREATE TABLE discussion_board (Title VARCHAR(50),BoardTitle VARCHAR(50))";
		mysqli_query($conn,$sql);
		
		//comments Table
		$sql="CREATE TABLE comments (Username VARCHAR(50),TimeComment DATETIME(6))";
		mysqli_query($conn,$sql);
	
		
		
		$sql = "INSERT INTO user_profile(Username, Password, Email, IsConsultant, Status, Company, JobPos) 
				VALUES ('Admin','Admin123','Admin@email.com',1,'active','admin','admin');";

		mysqli_query($conn,$sql);
		//$sql= "DROP TABLE my_guests";
		//mysqli_query($conn,$sql);
	}
	else
	{
		die(mysqli_connect_error());
	}
?>