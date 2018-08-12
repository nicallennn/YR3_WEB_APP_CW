<?php
/*******************************************************************
CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - UPLOADING FILES TO MYSQL
Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/PHP/imageUpload.html
********************************************************************/
require('connect.php');
$query = 'SELECT type,image_blob FROM images WHERE image_id="' . $_GET['image_id'] . '"';
$result = mysqli_query($conn, $query);

  $row = mysqli_fetch_assoc($result);
  header('Content-Type: ' . $row['type']);
  echo $row['image_blob'];

  mysqli_close($conn);
?>
