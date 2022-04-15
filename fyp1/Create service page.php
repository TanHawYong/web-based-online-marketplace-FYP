<html>
	<head lang="en">
	    <meta charset="utf-8">
	    <title>Create Service</title>
	    <link rel="stylesheet" href="css/Create service page.css" />
		<script src="wap_login.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8">
	    <?php include "Server_Access.php"; ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<script>

		function newCategoryBox() {
        var select = document.getElementById("sel_Category");
        var divv = document.getElementById("container");
        var value = select.value;
        	if (value == 4) {	
				divv.style.display='block';
            	toAppend = "<label for='NewCategory'>NewCategory: </label> <input type='text' id='NewCategory' name='NewCategory' ><br><br> <label for='NewSubCategory'>New SubCategory: </label> <input type='text' id='NewSubCategory' name='NewSubCategory' ><br><br>";
				divv.innerHTML=toAppend;
				return;
            }else{
				divv.style.display='none';
			}

     	}

		function newSubCategoryBox() {
        var select = document.getElementById("sel_SubCategory");
        var divv = document.getElementById("container");
        var value = select.value;
        	if (value == 8) {	
				divv.style.display='block';
            	toAppend = "<label for='NewSubCategory'>New SubCategory: </label> <input type='text' id='NewSubCategory' name='NewSubCategory' ><br><br>"; 
				divv.innerHTML=toAppend; 
				return;
            }else{
				divv.style.display='none';
			}

     	}

		</script>
		
		<script type="text/javascript">
        $(document).ready(function(){

            $("#sel_Category").change(function(){
                var catid = $(this).val();

                $.ajax({
                    url: 'subcat.php', type: 'post',data: {Category:catid}, dataType: 'json',
                    success:function(response){
                         var len = response.length;
                        $("#sel_SubCategory").empty();
                        for( var i = 0; i<len; i++){

                            var id = response[i]['id'];
                            var cat = response[i]['SubCategory'];

                            $("#sel_SubCategory").append("<option value='"+id+"'>"+cat+"</option>");
                        }
                        
                    }
                });
            });

        });
    </script>

	</head>
	
	<body>
	<section class="header">		 
			<?php include "header.php"; ?>
	</section>

	
		

		<div class="ServiceRegisterForm">
			<form id = "ServicesRegister" class = "tabcontent" method="post" action="ServiceRegister.php" enctype="multipart/form-data">
				<br>
				<label for="Title">Service Title:</label>
				<input type="text" id="Title" name="Title"><br><br>

				<label for="sel_Category">Category: </label>
				<select id="sel_Category" name="sel_Category" onchange="newCategoryBox();" required>
				
					<option value="">- Select Category-</option>
					<?php 
					
					$sql = "SELECT * FROM service_category";
					$data = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($data) ){
						$Category_id = $row['id'];
						$Category = $row['Category'];
					
						// Option
						echo "<option value='".$Category_id."' >".$Category."</option>";
					}
					?>
				</select>
				
				<label for="sel_SubCategory">SubCategory: </label>
				<select id="sel_SubCategory" name="sel_SubCategory" onchange="newSubCategoryBox();" required>
					<option value="">- Select SubCategory-</option>
				</select>

				<label for="sel_StatusCategory">Status: </label>
				<select id="sel_StatusCategory" name="sel_StatusCategory" required>
					<option value="">- Select -</option>
					<option value="still in industry">still in industry</option>}  
					<option value="retired">retired</option>
					<option value="not listed">prefer not to say</option>
				</select>    
				<br><br>
				<div id="container"></div>
				<br>

				<label for="Detail">Service Description:</label>
				<input type="text" id="Detail" name="Detail"><br><br><br>
			
				<label for="Image">Image upload : </label>
				<input type="file" name = "inpFile" id="inpFile" accept = "image/*">

				
				<div class="image-preview" id="imagePreview">
					<img src="" alt="Image Preview" class="image-preview_image">
					<span class ="image-preview_default-text"></span>
				</div>
				<script >picDisplay();</script></br><br>
			
				<label for="Duration">Duration (minutes): </label>
				<input type="number" id="Duration" name="Duration" ><br><br>
				
				<label for="Price">Price: </label>
				<input type="number" id="Price" name="Price" ><br><br>

				<label for="StartWorkHour">StartWorkHour: </label>
				<input type="time" id="StartWorkHour" name="StartWorkHour" ><br><br>

				<label for="EndWorkHour">EndWorkHour: </label>
				<input type="time" id="EndWorkHour" name="EndWorkHour" ><br><br>

				<label for="WorkingDays">Off days ("0,1" for Sun and Mon, etc ): </label>
				<input type="text" id="WorkingDays" name="WorkingDays" required><br><br>




				<br><br>
				
				

				<input type="checkbox" id="TaC" name="TaC" value= 'true' onclick ='unable();'>
				<label for="TaC">I agree to the Terms and Conditions</label> <br><br>
				<?php
					$uname = $_SESSION['Username'];
					$sql = "SELECT* FROM user_profile WHERE Username = '$uname' or Email = '$uname';";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
				
					echo	"<input type='hidden' name='Username' value='".$row['Username']."' />";
					echo	"<input type='hidden' name='Email' value='".$row['Email']."' />";
				?>
			
				<input type="submit" id="submit" value="Submit" disabled>
				<input type="reset" value="Reset">
				<script>
					function unable()
					{
						document.getElementById("submit").disabled = !document.getElementById("submit").disabled;
					}
				</script>



			</form>
		</div>
	</body>

</html>