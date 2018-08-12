<?php
	session_start();
	//define TITLE constant
	define("TITLE", "Greenwich Ride Finder");
	#nclude header
	include('includes/header.php');

?>

	<!--

        ==================
        VERIFY.PHP START
        ==================

     -->

      <!-- container  -->
	<div class="container pt-3">

	<div class="bg-forms p-3 mt-3 d-inline-block rounded">
		<h1>Verify</h1>
		<p class="text-muted">Please enter the 5 character verification code sent to your email.</p>
	</div>
<!-- ****************** VERIFICATION FORM ****************************** -->
		<form class="form-group bg-forms rounded px-3 mt-4 mb-5 d-block mx-auto" name="register-form"
          action="includes/verifyScript.php" method="POST">


			<!-- get verification code-->
			<div class="form-group mt-3">
				<label for="verifyCode">Verification Code</label>
				<input class="form-control" name="verifyCode" type="text" required>
			</div>

			<?php
			//check for error message in get array
				if(isset($_GET['verified']) && $_GET['verified'] = "error"){
					//if error message set, inform the user
					echo '<p class="small text-danger">Verification code incorrect, please try again!</p>';
					//unset the get variable
					unset($_GET['verified']);
				}

			?>

      <!-- submit button -->
			<input class="btn btn-custom mb-2" type="submit" value="Submit">
		</form>
		<br><br><br><br><br>


  </div><!-- #container-->


<?php
	#include footer
	include('includes/footer.php');

?>
