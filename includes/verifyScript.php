<?php
  //start the session
    session_start();
    //connect to database
    require("connect.php");

    $user = $_SESSION['user'];

    //if post array is set, get verification code from post array
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_SESSION['user'];                  //store session username
      $verifyCode = mysqli_real_escape_string($conn, $_POST["verifyCode"]);                 //store post verification code
    }

    //create query string to check verification code
    $verifyQuery = "SELECT * FROM users WHERE username = '$username' AND
                    authenticate_code = '$verifyCode'";
    //run the verification query
    $verify = mysqli_query($conn, $verifyQuery);
    //check for results
    if(mysqli_num_rows($verify) > 0){
      //test echo message
      //echo "match found";
      $_SESSION['success'] = 'true';
      //authenticte user query
      /*******************************************************************
      CODE ADAPTED FROM W3SCHOOLS - SQL UPDATE STATEMENT
      Found at: https://www.w3schools.com/sql/sql_update.asp
      ********************************************************************/
      //create query string to update 'authenticated' field for user in users table
      $updateAuthenticated = "UPDATE users SET authenticated = '1'
                      WHERE username = '$username' ";
      //run query to authenticate user
      $verifyQuery = mysqli_query($conn, $updateAuthenticated);

      //store logged in user data in session
      $_SESSION['loggedInUser'] = $user;
      $_SESSION['loggedInEmail'] = $_SESSION['email'];
      $_SESSION['loggedIn'] = "1";

      //log user in
      header('Location: ../account.php');
      die();

    }else{
      //echo "no match";
      $_SESSION['success'] = 'false';
      $error = "Verification code incorrect!";
      header('Location: ../verify.php?verified="error"');
      die();
    }
    

?>
