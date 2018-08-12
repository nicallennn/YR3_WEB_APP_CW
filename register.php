<?php
	session_start();
	//define TITLE constant
	define("TITLE", "Greenwich Ride Finder");
	#nclude header
	include('includes/header.php');

?>

	<!--

        ==================
        REGISTER.PHP START
        ==================

     -->

      <!-- container  -->
	<div class="container pt-3">
		<div class="bg-forms p-3 mt-3 d-inline-block rounded">
			<h1>Sign up</h1>
			<p class="text-muted">Sign up using the form below.</p>

			<!-- error messages -->
			<?php
			//check for error message in get array
				if(isset($_GET['error']) && $_GET['error'] == "captchaIncorrect"){
					//if error message set, inform the user
					echo '<p class="small text-danger">Captcha code incorrect, please try again!</p>';
					//unset the get variable
					unset($_GET['error']);
				//username taken error
				}elseif(isset($_GET['error']) && $_GET['error'] == "usernameTaken"){
						echo '<p class="small text-danger">Username is already in use, please try another!</p>';
						//unset the get variable
						unset($_GET['error']);
						}

			?>
		</div>
<!-- ****************** REGISTRATION FORM ****************************** -->

		<!-- new row -->
		<div class="row">
			<div class="col-md-8">
				<form class="bg-forms form-group rounded px-3 mt-3 d-block mx-auto" name="register-form" action="includes/registerScript.php"
				 			onsubmit="return validateForm()" method="POST">

					<!-- get username-->
					<div class="form-group mt-3">
						<label for="username">Username</label>
						<input class="form-control" id="username" name="username" type="text" required>
					</div>
					<!-- get email-->
					<div class="form-group mt-3">
						<label for="email">Email</label>
						<input class="form-control" id="email" name="email" type="email" required>
					</div>
					<!-- get password-->
					<div class="form-group mt-3">
						<label for="password">Password</label>
						<input class="form-control" id="password" name="password" type="password" required>
					</div>
					<!-- captcha -->
					<div class="form-group mt-3">
						<label>Captcha Image</label>
						<img alt="captcha image" class="d-block rounded captcha-border" src="includes/captcha.php">
					</div>
					<!-- get captcha-->
					<div class="form-group mt-3">
						<label for="captcha">Enter Captcha Code</label>
						<input class="form-control" id="captcha" name="captcha" type="text" required>
					</div>

					<!-- submit button-->
					<input class="btn btn-custom mb-2" type="submit" value="Submit">
					<!-- reset button-->
					<input class="btn btn-delete mb-2 mx-1" type="reset">
				</form>
			</div><!-- end column-->
		</div><!-- end form row -->


  </div><!-- #container-->
	<!-- js validation -->
	<script>
function validateForm() {
    var username = document.forms["register-form"]["username"].value;
		var password = document.forms["register-form"]["password"].value;
    if (username.length < 5 && password.length < 5) {
				alert("Username and Password must be atleast 5 characters long!")
				return false;
	    }else if(password.length < 5){
					alert("Password must be atleast 5 characters long!")
					return false;
				}else if(username.length < 5){
					alert("Username must be atleast 5 characters long!");
	        return false;
				}
}
</script>

<?php
	#include footer
	include('includes/footer.php');

?>
