<html>
	<head lang="en">
	   <meta charset="utf-8">
	   <title>DiscussionBoard</title>
	   <link rel="stylesheet" href="css/DiscussionBoard page.css" />
	   <?php include "Server_Access.php"; ?>
	</head>
	<section class="header">
		<?php include "header.php"; ?>
	</section>

	<?php
		$boardtitle =$_SESSION['boardtitle'];
		$uname =$_SESSION['Username'];
	?>
	<br><br>
	
	<div class='Title'>
		<?php
			echo "<h2>Title : $boardtitle</h2><br><br>";
		?>		
	</div>
	<body>				
	<div class ='comments'>
		<?php
			
			$sql = "SELECT * FROM comments WHERE BoardTitle = '$boardtitle';";
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
					
					$users= $data['Username'];
					$timecomment = $data['TimeComment'];
					$comment = $data['comments'];
					
					$Date = date("y/m/d h:m A", strtotime($timecomment));
					echo "<div class='userdetail'>User: $users  <br>"; 
					echo "Date: $Date : </div><br>";
					echo " <div class='usercomments'> $comment <br><br></div>" ;
					
				
				}
				
			}
			else
			{
				die(mysqli_connect_error());
			}
		?>
	</div>


	<div class="commentbox">
		<?php
			   echo "<br><form action='Comment_insert.php' method='post'>
			   		<input type='text' id='comment' name='comment' size='50'>
					<input type='hidden' name='boardtitle' value='$boardtitle' />					
					<input type='hidden' name='username' value='$uname' />
					<button type='submit' > Enter  </button>
					</form>";
		?>
	</div>
	</body>

</html>