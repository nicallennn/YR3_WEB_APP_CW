<?php
  session_start();
  $post_id = $_GET['post_id'];
  require('includes/connect.php');
  /*******************************************************************
  CODE ADAPTED FROM W3SCHOOLS - SQL DELETE EXAMPLE
  Found at: https://www.w3schools.com/sql/sql_delete.asp
  ********************************************************************/
  //create query string to delete a post
  $deleteQuery = "DELETE FROM post WHERE post_id='$post_id'";

  //run the query
  $result = mysqli_query($conn, $deleteQuery);

  if($result){
    header('Location: account.php');
    die();
  }else{
    echo "Fail <br>";
    echo "Error: " . $result . "<br>" . mysqli_error($conn);
  }

?>
