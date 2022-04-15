<html>
	<head lang="en">
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/Review page.css" />
		<?php include "Server_Access.php"; ?>

		<section class="header">
			<?php include "header.php"; ?>
		</section>
</div><br>	 

	
	<body>
		<br><br><br><br>
		<div class="reviewbox">
			<?php

				$title = $_POST['Title'];

				echo "<form action='Review_insert.php' method = 'post'>";
				echo "<label for='review'>Please enter your review </label><br>";			
				echo "<input type='text' id='review' name='review' style='width:50em;height:15em;'>";

				echo "<br><br><label for='rating'>Please enter your rating (out of 100) </label>";			
				echo "<input type='number' id='rating' max=100 min=1 name='rating' size='90'>";
                
                echo "<input type='hidden' name='Title' value='$title' />"	;
                echo "<input type='hidden' name='username' value='$uname' />"	;

				echo "<br><br><input type='submit' id='submit' value='Submit' >"		;
				
				echo "</form>";
				
			?>
		</div>
<br><br>

 
	</body>
</html>