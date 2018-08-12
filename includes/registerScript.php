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
      $email = mysqli_real_escape_string($conn, $_POST["email"]);                       //store post email
      $password = mysqli_real_escape_string($conn, hash('sha256' , $_POST["password"])); //hash password
      $authenticate_code = rand(11111,99999);          //get random 5 character number
      $reg_date = date('Y/m/d');                       //set registration date
      $authenticated = 0;                              //set !authenticated
      $captcha = mysqli_real_escape_string($conn, $_POST['captcha']);
    }

    //check captcha string
    if($captcha != $captchaString){
      //redirect back to registration page
      header('Location: ../register.php?error=captchaIncorrect');
      die();
    }

    //check if username is in use
    $usernameCheck = "SELECT * FROM users WHERE username = '$username'";
    //run checking query
    $checkUsername = mysqli_query($conn, $usernameCheck);
    //if username is taken
    if(mysqli_num_rows($checkUsername) > 0){
      //echo message to user
      header('Location: ../register.php?error=usernameTaken');
      die();
    }else{
    /*******************************************************************
    CODE ADAPTED FROM W3SCHOOLS - PHP INSERT DATA INTO MYSQL
    Found at: https://www.w3schools.com/php/php_mysql_insert.asp
    ********************************************************************/
    //create sql insert query to register user
    $reg_query = "INSERT into users (username, email, password, authenticate_code,
              reg_date, authenticated)
              VALUES ('$username', '$email', '$password','$authenticate_code',
                      '$reg_date', '$authenticated') ";

    //run registration query
    if(mysqli_query($conn, $reg_query)){

      //close database connection


      //email new user with authentication code
      //syntax: mail(to,subject,message,headers,parameters);
      /*******************************************************************
      CODE ADAPTED FROM W3SCHOOLS - PHP MAIL() FUNCTION
      Found at:https://www.w3schools.com/php/func_mail_mail.asp
      ********************************************************************/
      $to = $email;
      $subject ="Please verify your account";
      $message = "Welcome to Greenwich Ride Finder!" .
                 "\r\n" . "\r\n" .
                 "Your account verification code is: " . $authenticate_code .
                 "\r\n" . "\r\n" .
                 "You need to verify your account to gain full access to the website." .
                 "\r\n" . "\r\n" .
                 "Kind Regards" .
                 "\r\n" .
                 "GRW";
      $headers = "From: na2880g@greenwich.ac.uk";

      //send email
      $result = mail($to,$subject,$message,$headers);
          if(!$result){
            //if not sent echo error message
            echo "error";
          }

      //set session variables
      //get user id from table
      $query = "SELECT user_id FROM users WHERE username = '$username'";
      //run the query
      $result = mysqli_query($conn, $query);
      //sort the results
      while($row = mysqli_fetch_assoc($result)){
        $user_id = $row['user_id'];
      }


      $_SESSION['user_id'] = $user_id;
      //set username in session array
      $_SESSION['user'] = $username;
      $_SESSION['email'] = $email;

      mysqli_close($conn);
      //redirect to verification page
      header('Location: ../verify.php');
      die();
    } else {
      //display error message
      echo "Error: " . $reg_query . "<br>" . mysqli_error($conn);
      //close database connection
      mysqli_close($conn);
    }
  }

?>
