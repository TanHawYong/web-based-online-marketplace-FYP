<?php
	
	session_start();
	
	$conn = mysqli_connect("localhost","root","","sixerr_db");
	$username = $_POST['username'];
	$userPass = $_POST['password'];
	if($conn)
	{
		
		if(empty($username)||empty($userPass))
		{
			echo "<script>
				alert('Please fill up the form');
				window.location.href='http://localhost/fyp1/RegistrationLogin page.php';
				</script>"; 
			//echo "check if empty";
		}
		else{
			//echo "check it's fill";
			$sql = "SELECT * FROM user_profile WHERE Username = ? or Email = ?;";
			$stmt = mysqli_stmt_init($conn);
			
			if(!mysqli_stmt_prepare($stmt,$sql))
			{
				//echo "check it's fail";
				header("Location: ../fyp1/Home page.php?login=fail");
				exit();
			}
			else
			{
				//echo "check it's working";
				$sql = "SELECT * FROM user_profile WHERE Username = '$username' or Email = '$username';";
				$result = mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)>0)
				{
					echo "there is username";
					$pass = "SELECT * FROM user_profile WHERE Password = '$userPass';";
					$result = mysqli_query($conn,$pass);
					$row = mysqli_fetch_assoc($result);
					
					
					if($userPass == $row["Password"])
					{
						//echo "correct password";
						$_SESSION['Username']= $row["Username"];
						header("Location: ../fyp1/Home page.php?login=success");
						exit();
					}
					else
					{
						//echo "wrong password";	
						echo '<script type="text/javascript">';  
						echo 'alert("The password is incorrect");'; 
						echo 'window.location.href = "RegistrationLogin page.php";';
						echo '</script>';
					}
				}
				else
				{
					//echo "the username doesn't exits";
					echo '<script type="text/javascript">';  
					echo "alert('Username does not exist');"; 
					echo 'window.location.href = "RegistrationLogin page.php";';
					echo '</script>';
				}
			}
		}
	}
	else
	{
		die(mysqli_connect_error());
	}
?>