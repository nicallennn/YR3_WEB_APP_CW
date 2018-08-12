<?php
//start the session
  session_start();
  //connect to database
  require("connect.php");

  //if post array is set, get verification code from post array
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $start = mysqli_real_escape_string($conn, $_POST['start']);
    $end = mysqli_real_escape_string($conn, $_POST['end']);
    $start_lat = mysqli_real_escape_string($conn, $_POST['start-lat']);
    $start_lng = mysqli_real_escape_string($conn, $_POST['start-lng']);
    $end_lat = mysqli_real_escape_string($conn, $_POST['end-lat']);
    $end_lng = mysqli_real_escape_string($conn, $_POST['end-lng']);
    $times = mysqli_real_escape_string($conn, $_POST['time']);
    $days = mysqli_real_escape_string($conn, $_POST['days']);
    $obtain = mysqli_real_escape_string($conn, $_POST['obtain_provide']);
    $post_date = date('Y/m/d');
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
  }

  //create query string to insert new post
  $newPostQuery = "INSERT into post (user_id, post_title, start_point, end_point,
                    start_lat, start_lng, end_lat, end_lng,
                    times, days, obtain_provide, post_date, comments) values
                    ('$user_id', '$title', '$start', '$end', '$start_lat', '$start_lng',
                     '$end_lat', '$end_lng','$times', '$days', '$obtain', '$post_date', '$comments')";

  //run registration query
  if(mysqli_query($conn, $newPostQuery)){
    //close database connection
    mysqli_close($conn);
    header('Location: ../account.php');
    die();
  } else {
    echo "Insert Failed <br>"; //display error message
    echo "Error: " . $newPostQuery . "<br>" . mysqli_error($conn);
    //close database connection
    mysqli_close($conn);
  }


?>
