<?php
  //start the session
  session_start();
  //get the captcha CODE and strip the whitespace
  $captchaString = str_replace(' ', '', $_SESSION['captcha']);


    //connect to database
    require("connect.php");

/*******************************************************************
CODE ADAPTED FROM W3SCHOOLS - PHP SUPERGLOBALS
Found at: https://www.w3schools.com/php/php_superglobals.asp
********************************************************************/

    //if post array is set, get user values from post array
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = mysqli_real_escape_string($conn, $_POST["username"]);                 //store post username
      $password = mysqli_real_escape_string($conn, hash('sha256' , $_POST["password"])); //hash password
      $captcha = $_POST['captcha'];
    }

    //check captcha string
    if($captcha != $captchaString){
      //alert user and redirect back to login page page
      header('Location: ../index.php?error=captchaIncorrect');
      die();
      //redirect to login page
    }


    //create query string to check for user
    $query = "SELECT user_id, username, email, password, authenticated FROM users
              WHERE username = '$username'";
    //run query
    $result = mysqli_query($conn, $query);


    //check for result
    if(mysqli_num_rows($result) > 0){
      //if user exists, get user details
      while($row = mysqli_fetch_Assoc($result)){
        $user_id = $row['user_id'];
        $user = $row['username'];
        $email = $row['email'];
        $dbPassword = $row['password'];
        $verifiedCheck = $row['authenticated'];
        }

        //check if authenticated and if password is correct
        if(($verifiedCheck == 0) && ($dbPassword == $password)){
          //if not authenticated but password correct, store username in session variable for verification
          $_SESSION['user'] = $user;
          $_SESSION['email'] = $email;
          $_SESSION['user_id'] = $user_id;

          //close db connection
          mysqli_close($conn);
          //redirect to verification page
          header('Location: ../verify.php');
          die();
          }
            //if verified, check password
            else if($verifiedCheck == 1 && $dbPassword == $password){
              //echo "correct login details";
              //store user data in session
              $_SESSION['loggedInUser'] = $user;
              $_SESSION['loggedInEmail'] = $email;
              $_SESSION['user_id'] = $user_id;
              $_SESSION['loggedIn'] = "1";


              /*******************************************************************
              CODE ADAPTED FROM W3SCHOOLS - PHP SETCOOKIE FUNCTION
              Found at: https://www.w3schools.com/php/func_http_setcookie.asp
              ********************************************************************/
              //set the username in the cookie
              $cookieName = "username";
              setcookie($cookieName, $user, time() + (86400 * 30), "/");

              //close db connection
              mysqli_close($conn);
              //redirect to account page
              header('Location: ../account.php');
              die();
              }else{
                //alert user and redirect back to login page page
                header('Location: ../index.php?error=wrongUserName');
                die();
                }

    //no record in database
    }else{
      //alert user and redirect back to login page page
      header('Location: ../index.php?error=userNotFound');
      die();
    }
    //close db connection
    mysqli_close($conn);

?>
