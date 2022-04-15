<?php
	$conn = mysqli_connect("localhost","root","","sixerr_db");
	$column  = $_POST['column'];
	$value = $_POST['value'];
	$table = $_POST['table'];
	$submit = $_POST['submit'];
	
	if($conn)
	{
		if($submit == 'activate')
		{
			echo "activate <br>";
			echo "$table <br>";
			echo "$column<br>";
			echo "$value<br>";

			if($table == "user_profile"){
				$sql = "UPDATE $table SET Status = 'active' WHERE $column = '$value' ; ";
			}else if($table == "service_profile"){
				$sql = "UPDATE $table SET ServiceStatus = 'active' WHERE $column = '$value' ; ";
			}

			mysqli_query($conn,$sql);

			echo "<pre>Debug: $sql</pre>\m";
			$result = mysqli_query($conn, $sql);
			if ( false===$result ) {
			  printf("error: %s\n", mysqli_error($conn));
			}
			else {
			  echo 'done.';
			}
			header("Location: ../fyp1/Admin table page.php");
		}
		else if($submit == 'deactivate'){
			echo "deactivate <br>";
			echo "$table <br>";
			echo "$column<br>";
			echo "$value<br>";
			
			if($table == "user_profile"){
				$sql = "UPDATE $table SET Status = 'inactive' WHERE $column = '$value' ; ";
			}else if($table == "service_profile"){
				$sql = "UPDATE $table SET ServiceStatus = 'inactive' WHERE $column = '$value' ; ";
			}
			
			mysqli_query($conn,$sql);

			echo "<pre>Debug: $sql</pre>\m";
			$result = mysqli_query($conn, $sql);
			if ( false===$result ) {
			  printf("error: %s\n", mysqli_error($conn));
			}
			else {
			  echo 'done.';
			}
			
			header("Location: ../fyp1/Admin table page.php");
		}
		
	}
	else
	{
		die(mysqli_connect_error());
	}
?>