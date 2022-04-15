

<html>	
<?php
	include "Server_Access.php";
?>
	<head lang="en">
		<meta charset="utf-8">
		<title>Admin table</title>
		<link rel="stylesheet" href="css/Home page.css" />
	</head>
	
	<body>
	<section class="header">
			<?php include "header.php"; ?>
	</section>


	
	</br></br>
	<div class='Admintable' style="margin-left:25em;">
		<h1>Pending Approval</h1>
		<table style="width:fit-content;border-spacing: 15px;" class="table">
			<tr>
				<th>Username</th>
				<th>Status</th> 
				<th>User type(1 = consultant, 0 = normal user)</th>				
				
			</tr>
			<?php CreateTablePending("user_profile","Username","Status","IsConsultant","IsConsultant","Status") ?>
		</table>

		<h1> </h1>
		<table style="width:fit-content;border-spacing: 15px;" class="table">
			<tr>
				<th>Service Title</th>
				<th>Service Status</th> 
				<th>Consultant</th>
				
				
			</tr>
			<?php CreateTablePending("service_profile","Title","ServiceStatus","Username","ServiceStatus","ServiceStatus") ?>
		</table>

		<h1>Accounts</h1>
		<table style="width:fit-content;border-spacing: 15px;" class="table">
			<tr>
				<th>Username</th>
				<th>Status</th> 
				<th>User type(1 = consultant, 0 = normal user)</th>				
				<th>Status Update</th> 
				
			</tr>
			<?php CreateTable("user_profile","Username","Status","IsConsultant","IsConsultant","Status") ?>
		</table>

		<h1>Services</h1>
		<table style="width:fit-content;border-spacing: 15px;" class="table">
			<tr>
				<th>Service Title</th>
				<th>Service Status</th> 
				<th>Consultant</th>
				<th>Status Update</th>
				
				
			</tr>
			<?php CreateTable("service_profile","Title","ServiceStatus","Username","ServiceStatus","ServiceStatus") ?>
		</table>
		
		<?php 
			function CreateTable($table,$col1,$col2,$col3,$order,$status){
				$conn = mysqli_connect("localhost","root","","sixerr_db");
				
				$sql = "SELECT * FROM $table ORDER BY $order";
				$res = mysqli_query($conn,$sql);
				$datas = array();
				
				if($conn)
				{
					if(mysqli_num_rows($res)>0)
					{
						while ($row = mysqli_fetch_assoc($res))
						{
							$datas[] = $row;
						}
					}
					
					foreach($datas as $data)
					{
						$statuscheck = $data[$status];
						echo "<form id='user_request' method='post' action='status update.php'>";
						echo "<tr>";
						
						echo	"<td style='text-align:center'>".$data[$col1]."</td>";
						echo	"<td style='text-align:center'>".$data[$col2]."</td>";
						echo	"<td style='text-align:center'>".$data[$col3]."</td>";		
						if($statuscheck != 'active'){
							echo	"<td style='text-align:center'><input type='submit'id='activate' name ='submit' value='activate' > </td>";
						
						}else{
							echo    "<td style='text-align:center'><input type='submit' id='deactivate' name ='submit' value='deactivate'></td>";	
						}
						
									
						echo	"<input type='hidden' name='value' value='".$data[$col1]."' />";
						echo	"<input type='hidden' name='column' value='".$col1."' />";
						echo	"<input type='hidden' name='table' value='".$table."' />";
						
						echo "</tr>";
						echo "</form>";
					}
				}
				else
				{
					die(mysqli_connect_error());
				}
			}

			
			function CreateTablePending($table,$col1,$col2,$col3,$order,$status){
				$conn = mysqli_connect("localhost","root","","sixerr_db");
				
				$sql = "SELECT * FROM $table WHERE $status = 'inactive' ORDER BY $order";
				$res = mysqli_query($conn,$sql);
				$datas = array();
				
				if($conn)
				{
					if(mysqli_num_rows($res)>0)
					{
						while ($row = mysqli_fetch_assoc($res))
						{
							$datas[] = $row;
						}
					}
					
					foreach($datas as $data)
					{
						$statuscheck = $data[$status];
						echo "<form id='user_request' method='post' action='status update.php'>";
						echo "<tr>";
						
						echo	"<td style='text-align:center'>".$data[$col1]."</td>";
						echo	"<td style='text-align:center'>".$data[$col2]."</td>";
						echo	"<td style='text-align:center'>".$data[$col3]."</td>";		

						
									
						echo	"<input type='hidden' name='value' value='".$data[$col1]."' />";
						echo	"<input type='hidden' name='column' value='".$col1."' />";
						echo	"<input type='hidden' name='table' value='".$table."' />";
						
						echo "</tr>";
						echo "</form>";
					}
				}
				else
				{
					die(mysqli_connect_error());
				}
			}
		?>

		</div>
	</body>

	
	</br></br></br></br></br></br></br></br>
</html>