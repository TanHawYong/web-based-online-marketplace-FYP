<?php
 	include "Server_Access.php";
	 $_SESSION["consultantname"]= $_POST["consultantname"];
	 $_SESSION["title"]= $_POST["ServiceTitle"];
	 $_SESSION["duration"]= $_POST["duration"];
	 $_SESSION["restday"]= $_POST["restday"];
	 $_SESSION["starthour"]= $_POST["starthour"];
	 $_SESSION["endhour"]= $_POST["endhour"];

	 header("Location: ../fyp1/Service detail page.php");
?>