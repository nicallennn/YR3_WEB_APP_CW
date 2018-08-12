<?php
	session_start();

	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
		header('Location: account.php');
	}

	//define TITLE constant
	define("TITLE", "Greenwich Ride Finder");
	#nclude header
	include('includes/header.php');

?>

      <!-- container  -->
	<div class="container pt-3">

		<div class="bg-forms p-3 mt-3 d-inline-block rounded">
			<h1>Login</h1>
			<p class="text-muted">Please login using the form below.</p>

			<!-- error messages -->
			<?php
			//check for error message in get array
				if(isset($_GET['error']) && $_GET['error'] == "captchaIncorrect"){
					//if error message set, inform the user
					echo '<p class="small text-danger">Captcha code incorrect, please try again!</p>';
					//unset the get variable
					unset($_GET['error']);
				}elseif(isset($_GET['error']) && $_GET['error'] == "wrongUserName"){
						echo '<p class="small text-danger">Username or password incorrect!</p>';
						//unset the get variable
						unset($_GET['error']);
					}elseif (isset($_GET['error']) && $_GET['error'] == "userNotFound"){
							echo '<p class="small text-danger">User not found, please try again!</p>';
							//unset the get variable
							unset($_GET['error']);
						}elseif (isset($_GET['error']) && $_GET['error'] == "viewPost"){
								echo '<p class="small text-danger">You must be logged in to view user posts!</p>';
								//unset the get variable
								unset($_GET['error']);
							}

			?>



		</div>
<!-- ****************** LOGIN FORM ****************************** -->
		<!-- new row -->
		<div class="row">
			<div class="col-md-8">
					<form id="login-form" class="form-group rounded px-3 mt-3 d-block mx-auto  bg-forms" name="login-form" action="includes/loginScript.php"
					 			 onsubmit="return validateForm()" method="POST">

						<!-- get username-->
						<div class="form-group mt-3">
							<label for="username">Username</label>
							<!-- input for username, check for cookie, set username -->
							<input class="form-control" id="username" name="username" type="text" required

								<?php
										//check if username is stored in cookie
										if(!isset($_COOKIE["username"])) {
											//do not set value of input
										}else{
											//echo the username as the input value
											echo "value=" . $_COOKIE["username"];
										}

								?>>

						</div>
						<!-- get password-->
						<div class="form-group mt-3">
							<label for="password">Password</label>
							<input class="form-control" id="password" name="password" type="password" required>
						</div>
						<!-- captcha -->
						<div class="form-group mt-3">
							<label>Captcha Image</label>
							<!-- display captcha-->
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
						<p class="text-muted mt-2">Or <a id="custom-links" href="http://stuweb.cms.gre.ac.uk/~na2880g/web/cw/register.php">click here</a> to sign up!</p>
					</form>
			</div><!-- end column-->
	</div><!-- end form row -->



  </div><!-- #container-->

	<!-- js validation -->
	<script>
function validateForm() {
    var username = document.forms["login-form"]["username"].value;
		var password = document.forms["login-form"]["password"].value;
    if (username.length == 0) {
        alert("Username must not be empty!");
        return false;
	    }else if(password.length == 0){
					alert("Password must not be empty!")
					return false;
				}else if(username.length == 0 && password.length == 0){
					alert("Username and Password must be not be empty!")
					return false;
				}
}
</script>

<?php
	#include footer
	include('includes/footer.php');

?>
