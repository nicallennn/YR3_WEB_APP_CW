<?php
  session_start();
  //connect to the database
  require('connect.php');
  //get the image id from the get array
  $post_id = $_GET['post_id'];
  $image_id = $_GET['image_id'];
  $_SESSION['post_id'] = $post_id;

  //create a query string
  $deleteImageQuery = "DELETE FROM images WHERE image_id = '$image_id'";

  //run the query
  $result = mysqli_query($conn, $deleteImageQuery);

  //check if query was successful
  if(!$result){
    //echo error message
    echo "image not deleted!";
  }else{
    //redirect back to edit post page, pass original post id back to page
    header("Location: ../editPost.php?post_id=" . $post_id );
  }


?>
