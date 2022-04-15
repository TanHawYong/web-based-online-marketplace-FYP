
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
	tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
	tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

function picDisplay (){
	const inpFile = document.getElementById("inpFile");
	const previewContainer = document.getElementById("imagePreview");
	const previewImage = previewContainer.querySelector(".image-preview_image");
	const previewDefaultText = previewContainer.querySelector(".image-preview_default-text");

	inpFile.addEventListener("change", function() {
		const file = this.files[0]
		
		if(file) {
			const reader = new FileReader();	
			
			previewDefaultText.style.display = "none";
			previewImage.style.display = "block";
			
			reader.addEventListener("load",function(){
				previewImage.setAttribute("src", this.result);
			});
			
			reader.readAsDataURL(file);
		}
		console.log(file);
	});
}

function loginFail(){
	window.alert("Attempt Fail!\nplease try again");
}

function agree()
{
	document.getElementById("submit").disabled = true;
}

