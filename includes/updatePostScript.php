<?php
 session_start();
  //check user is logged in
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    //echo "logged in";
  } else {
    header('Location: ../index.php');
    die();

  }

  require('connect.php');
/*******************************************************************
CODE ADAPTED FROM W3SCHOOLS - PHP SUPERGLOBALS
Found at: https://www.w3schools.com/php/php_superglobals.asp
********************************************************************/

    //if post array is set, get updated user post details from post array
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $post_id        = mysqli_real_escape_string($conn, $_POST["post_id"]);                 //store post username
      $title          = mysqli_real_escape_string($conn, $_POST["title"]);                       //store post email
      $start          = mysqli_real_escape_string($conn, $_POST["start"]);                 //store post username
      $end            = mysqli_real_escape_string($conn, $_POST["end"]);
      $start_lat      = mysqli_real_escape_string($conn, $_POST['start-lat']);
      $start_lng      = mysqli_real_escape_string($conn, $_POST['start-lng']);
      $end_lat        = mysqli_real_escape_string($conn, $_POST['end-lat']);
      $end_lng        = mysqli_real_escape_string($conn, $_POST['end-lng']);                     //store post email
      $times          = mysqli_real_escape_string($conn, $_POST["times"]);                 //store post username
      $days           = mysqli_real_escape_string($conn, $_POST["days"]);                       //store post email
      $obtain_provide = mysqli_real_escape_string($conn, $_POST["obtain_provide"]);                 //store post username
      $comments       = mysqli_real_escape_string($conn, $_POST["comments"]);                       //store post email
    }

    //create update query
    $updateQuery = "UPDATE post SET post_title = '$title', start_point = '$start', end_point = '$end',
                    start_lat = '$start_lat', start_lng = '$start_lng', end_lat = '$end_lat', end_lng = '$end_lng',
                    times = '$times', days = '$days', obtain_provide = '$obtain_provide',
                    comments = '$comments' WHERE post_id = '$post_id'";

    $result = mysqli_query($conn, $updateQuery);

    if($result){
      //close db connection
      mysqli_close($conn);
      header('location: ../account.php');
    }else{
      echo "failed! <br>";
      echo "Error: " . $result. "<br>" . mysqli_error($conn);
      //close db connection
      mysqli_close($conn);
    }
