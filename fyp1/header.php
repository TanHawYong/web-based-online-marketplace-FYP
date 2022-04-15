




<img src="images/sixerrlogo.png" alt="sixerr logo" width="200" height="100">

<header>

<STYLE>

A {
	text-decoration: none;
	color:white;
}

nav ul{

	padding: 0;
	list-style: none;
	white-space: nowrap;
}

nav .navigationbar>li{
	display:inline-block;
}



nav .Categories>a{
	display:block;
}


nav li:hover>a{
	cursor: pointer;
}
nav .Categories{
	
	position : absolute;
	display : none;
	padding-bottom:1em;
	vertical-align : top;
	background: #2c3e50;
  	border-radius: 0.5em;
	
}

nav .SubCategories{
	
	position : block;
	display : none;
	margin-left:1em;
	vertical-align : top;
	background: #2c3e50;
  	border-radius: 0.5em;
	font-size: 0.85em;
	
}


.item
{
    position     : relative;
    display      : inline-block;
    vertical-align : top;
    width        : 5em;   
}
nav .navigationbar>li:hover .Categories{
	display: block;
	animation: fade .5s;
}

nav .Categories>li:hover>.SubCategories{
	display: block;
	animation: fade .5s;
}



@keyframes fade {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}
</STYLE>

<script type="text/javascript">
	function cleared() {
			document.getElementById('search').value = '';
	}
</script> 




				<nav>
					<ul class="navigationbar">
						
						<li class='navmenu'><img alt="homeicon" src="images/home.PNG"><a href="Home page.php">Home</a></li>
						
						<?php
							$_SESSION['Consultant'] =  'false';	
							echo "<li class='item'><img alt='genreicon' src='images/genre.PNG' ><a href=''>Genre</a>";
								echo "<ul  class='Categories'>";
									$sqlcat = "SELECT * FROM service_category WHERE id != 4";
									$rescat = mysqli_query($conn,$sqlcat);

									if($conn){
										if(mysqli_num_rows($rescat)>0){
											while ($row = mysqli_fetch_assoc($rescat)){
												$datascat[] = $row;
											}
										}
					
										foreach($datascat as $datacat){
												$cat = $datacat['Category'];
												$catid = $datacat['id'];
												
												echo "<br><br><li class='item1'><a href=Genre_page.php?genre=",urlencode($catid),"&subcat=false&label=",urlencode($cat),">$cat</a>";

													$catid= $datacat['id'];

													echo "<ul  class='SubCategories'>";
														$sqlsubcat = "SELECT * FROM service_sub_category WHERE Category=$catid";
														$ressubcat = mysqli_query($conn,$sqlsubcat);

														if(mysqli_num_rows($ressubcat)>0){
															while ($row = mysqli_fetch_assoc($ressubcat)){
																$datassubcat[] = $row;
															}
														}

														foreach($datassubcat as $datasubcat){
															$subcat =$datasubcat['SubCategory'];
															$subcatid =$datasubcat['id'];
															//echo "<li><a href=''>$subcat</a></i>";
															echo "<li class='item2'><a href=Genre_page.php?genre=",urlencode($subcatid),"&subcat=true&label=",urlencode($subcat),">$subcat</a><li>";

														}
														unset($datassubcat);
													echo "</ul>";
												
												echo"</li>";
										
										}
										
									}
									else{
										die(mysqli_connect_error());
									}
								echo "</ul>";
							echo "</li>";
						?>
						<?php
						//check if the session is empty or not
						
						if(!isset($_SESSION['Username'])){		
							$_SESSION['Consultant'] =  'false';					
							echo "<li class='navmenu'><img alt='signinicon' src='images/signin.PNG'><a href='RegistrationLogin page.php'>Sign in</a></li>";
						}
						else if($_SESSION['Username']=='Admin'){
							$uname = $_SESSION['Username'];
							$_SESSION['purchasability'] = 'false';
							echo "<li class='navmenu'><img alt='admintableicon' src='images/admintable.PNG'><a href='Admin table page.php'>Admin Page</a></li>";
							echo "<li class='navmenu'><img alt='logouticon' src='images/logout.PNG'><a href='LogOut.php'>Log Out</a></li>";
						}
						else
						{
							$uname = $_SESSION['Username'];
							$sql = "SELECT * FROM user_profile WHERE Username = '$uname'";
							$result = mysqli_query($conn,$sql);
							$row = mysqli_fetch_assoc($result);
							if ($row["IsConsultant"] == 1)
							{
								$_SESSION['purchasability'] = 'false';
								$_SESSION['Consultant'] =  'true';
								echo "<li class='navmenu'><img alt='yourserviceicon' src='images/your services.PNG'><a href='Your services page.php'>Your Services</a></li>";
								echo "<li class='navmenu'><img alt='appointmenticon' src='images/appointment.PNG' height='50' wifth='50'><a href='Appointments page (Consultant).php'>Appointments</a></li>";
								

							}else{
								$_SESSION['purchasability'] = 'true';
								echo "<li class='navmenu'><img alt='appointmenticon' src='images/appointment.PNG' height='50' wifth='50'><a href='Appointments page (Client).php'>Appointments</a></li>";
							}
							
							echo "<li><img alt='logouticon' src='images/logout.PNG'><a href='LogOut.php'>Log Out</a></li>";


							
						}
						?>
							<li>
								<form id = "ServicesRegister" class = "tabclass" method="post" action="Home page.php" enctype="multipart/form-data">
									<input type="text" id="search" name="search" value="type something..." onclick="cleared()">
									<input type="submit" style='display:none;background:none;' name="submit">
								</form>
							</li>
						<?php
							echo "<li><a href='' style='margin:3em;' >Welcome back! $uname</a></li>";
						?>
					</ul> 

					
				</nav>

				  




			</header>