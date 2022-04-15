<html>
	<head lang="en">
	    <meta charset="utf-8">
	    <title>RegistrationLogin</title>
	    <link rel="stylesheet" href="css/RegistrationLogin.css"/>
		<script src="wap_login.js"></script>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8">
	</head>
		<body>
			
			<div id= logo>
				<img src="images/sixerrlogo.png" alt="sixerr logo" width="250" height="250">
			</div>

			<br><br><br>
			<div class='formcontainer'>


				<div class="line"></div>

				<div class='register'>

					<h3 class='sign'>Register</h3>
					<form id = "Register"  method="post" action="Register.php" enctype="multipart/form-data">
						<p>
						<label for="Username">Username:</label>
						<input type="text" id="username" name="username" required><br><br>
						</p>
						<p>
						<label for="Password">Password:</label>
						<input type="password" id="password" name="password" required><br><br>
						</p>
						<p>
						<label for="Email">Email:</label>
						<input type="text" id="email" name="email" required><br><br>
						</p>
						<p>
						<label for="Company">Company:<br> (if applicable)</label>
						<input type="text" id="company" name="company"><br><br>
						</p>
						<p>
						<label for="JobPos">JobPos:<br> (if applicable)</label>
						<input type="text" id="jobPos" name="jobPos"><br>
						</p>
						<p>
						<input type="checkbox" id="Consultant" name="Consultant" value="true">
						<label for="Consultant">Registering for a consultant? </label> <br><br>
						</p>
						
						<input type="submit" id="submit" value="submit">
						<input type="reset" value="Reset">
						
					</form>
				</div>

				<div class='forms'>
				<h3 class='sign'>Login</h3>
					<form id = "Login"  method ="post"  action="Login.php">
						<p>
						<label for="username">Username: </label>
						<input type="text" id="username" name="username" required><br><br>
						</p>
						<p>
						<label for="password">Password: </label>
						<input type="password" id="password" name="password" required><br><br>
						</p>
						<p>
						<input type="submit" value="Submit">
						</p>
			
		
		
		
		
		
		
		
		
		
		
		
		</form>
				</div>43
			</div>
		</body>

</html>