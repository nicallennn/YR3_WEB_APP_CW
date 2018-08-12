<?php
	//start the session


	//require("includes/connect.php");

 ?>

<!DOCTYPE html>
<html>
<head>
	<!-- set page title-->
	<title><?php echo TITLE; ?></title>

			<!-- set initial scale -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <!-- custom styles -->
      <link rel="stylesheet" href="css/styles.css">



</head>
<body>

	<nav class="navbar navbar-expand-sm bg-custom">
			<div class="container">
				<a class="navbar-brand py-3 logo-color" href="index.php"><img src="img/logo.png" alt="GRF"></a>
						<ul class="navbar-nav">
              <?php
              //check if user is logged in, if not logged in, display sign up option
              if(!isset($_SESSION['loggedIn'])){
                echo '
    							<li class="nav-item ml-3">
    									<a class="nav-link glow-nav" href="register.php">Sign Up</a>
    							</li>
                ';
              }
                ?>

								<li class="nav-item ml-3">
										<a class="nav-link glow-nav" href="search.php">Search</a>
								</li>
								<li class="nav-item ml-3">
										<a class="nav-link glow-nav" href="account.php">Account</a>
								</li>
								<?php
								//check if user is logged in, if logged in display logout option in navbar
								if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
									echo '
									<li class="nav-item ml-3">
											<a class="nav-link logout-button glow-nav" href="includes/logout.php">Logout</a>
									</li>
												';
								}
								 ?>

						</ul>
				</div>
	</nav>
