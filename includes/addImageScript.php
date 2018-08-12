<?php
  session_start();
  //check user is logged in
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    //echo "logged in";
  } else {
    header('Location: ../index.php');
    die();
  }

  /*******************************************************************
  CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - UPLOADING FILES TO MYSQL
  Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/PHP/imageUpload.html
  ********************************************************************/

if (!($_FILES['userFile']['type']) ) {
   die();
}

require('connect.php');
// Validate uploaded image file
if ( !preg_match( '/gif|png|x-png|jpeg/', $_FILES['userFile']['type']) ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=imageNotCompatible');
  die();

} else if ( strlen($_POST['altText']) < 5 ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=altText');
  die();
} else if ( $_FILES['userFile']['size'] > 16384 ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=imageTooLarge');
  die();
// Connect to database
} else if ( !($link = require('connect.php')) ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=noDbConnection');
  die();
// Copy image file into a variable
} else if ( !($handle = fopen ($_FILES['userFile']['tmp_name'], "r")) ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=canNotOpenTempFile');
  die();
} else if ( !($image = fread ($handle, filesize($_FILES['userFile']['tmp_name']))) ) {
  //redirect to add image page, pass error in get
  header('Location: ../addImage.php?error=canNotReadTempFile');
  die();
} else {
   fclose ($handle);
   // Commit image to the database
   $image = mysqli_real_escape_string($conn, $image);
   //get the post_id from the post arrays
   $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
   //get the file type
   $type = mysqli_real_escape_string($conn, $_FILES['userFile']['type']);
   //get the file name
   $name = mysqli_real_escape_string($conn, $_FILES['userFile']['name']);
   //get the image alt text from the psot array
   $image_alt = mysqli_real_escape_string($conn, $_POST['altText']);
   //get the image title form the post aray
   $image_title = mysqli_real_escape_string($conn, $_POST['imageTitle']);

   //create query string to insert image into database
   $insertImageQuery = "INSERT INTO images (post_id, type, name, image_blob, image_title, image_alt)
            VALUES ('$post_id', '$type', '$name', '$image', '$image_title', '$image_alt')";

  //run the query and check for errors
   if ( !(mysqli_query($conn, $insertImageQuery)) ) {
      //close the database connection
      mysqli_close($conn);
      //redirect back to user account page
      header('Location: ../account.php?uploaded=false');
      die();
   } else {
      //close the database connection
      mysqli_close($conn);
      //redirect back to user account page
      header("Location: ../addImage.php?&uploaded=true");
      die();
   }
}
?>
</body>
