<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");

	
	$uname=$_POST['username'];
	$password=$_POST['password'];
	$email=$_POST['email'];
	$company=$_POST['company'];
	$jobPos=$_POST['jobPos'];

	if (isset($_POST['Consultant']))
	{
		$consultant = 1;
	}
	else
	{
		$consultant=0;
	}	
	
	if($conn)
	{
		$resU = mysqli_query($conn,"SELECT COUNT(*) FROM user_profile WHERE Username = '$uname'");   
		$resE = mysqli_query($conn,"SELECT COUNT(*) FROM user_profile WHERE  Email= '$email'");
		$totalU = mysqli_fetch_array($resU);
		$totalE = mysqli_fetch_array($resE);
		
		if($totalU[0]>0 || $totalE[0]>0){

			$detail1 = "username : ";
			$detail2 = "email : ";

			if ($totalU[0]>0)
			{			
				$detail1 = $detail1.$uname. " is taken, please choose another name";
				echo "<script>
				alert('$detail1');
				window.location.href='http://localhost/fyp1/RegistrationLogin page.php';
				</script>"; 
			}
			
			if ($totalE[0]>0)
			{			
				$detail2 = $detail2.$email. " is taken, please choose another email";
				echo "<script>
				alert('$detail2');
				window.location.href='http://localhost/fyp1/RegistrationLogin page.php';
				</script>"; 
			}
			
			
			

		}
		else
		{			
			$sql = "INSERT INTO user_profile(Username, Password, Email, IsConsultant, Status, Company, JobPos) 
					VALUES ('$uname','$password','$email',$consultant,'active','$company','$jobPos');";

			mysqli_query($conn,$sql);
			$detailsuccess = "Register successful, Thank you for registering for Sixerr!";
			echo "<script>			
			alert('$detailsuccess');
			window.location.href='http://localhost/fyp1/RegistrationLogin page.php';
			</script>"; 

		}
	}
	else
	{
		die(mysqli_connect_error());
	}
?>