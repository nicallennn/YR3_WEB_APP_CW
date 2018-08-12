<?php
  //start the session
  //session_start();
  $username = $_SESSION['loggedInUser'];
  $user_id = $_SESSION['user_id'];

  //connect to db
  require('connect.php');

  //check for posts
  //create qeury string to look for all posts associated with the user
  $postQuery = "SELECT * FROM post WHERE user_id = '$user_id'";

  //run the query
  $result = mysqli_query($conn, $postQuery);

  //display results
  if(mysqli_num_rows($result) > 0) {
    //if user has created any posts, display them
    echo "<table class='table'>
          <tr>
            <th>Post ID</th>
            <th>Post Title</th>
            <th>Start Point</th>
            <th>End Point</th>
            <th>Time</th>
            <th>Days</th>
            <th>Obtain or Provide</th>
            <th>Date Posted</th>
            <th>Images</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View</th>
          </tr>
          ";

    //while there are rows left in the associative array
    while($row = mysqli_fetch_assoc($result)){
      //echo out users posts
      echo "
          <tr>
            <td>" . $row['post_id'] . "</td>
            <td>" . $row['post_title'] . "</td>
            <td>" . $row['start_point'] . "</td>
            <td>" . $row['end_point'] . "</td>
            <td>" . $row['times'] . "</td>
            <td>" . $row['days'] . "</td>
            <td>" . $row['obtain_provide'] . "</td>
            <td>" . $row['post_date'] . "</td>
            <!-- buttons for edit and delete, pass post_id in url-->
            <td><a class='btn btn-image' href='addImage.php?post_id=". $row['post_id'] ."'>Add</a></td>
            <td><a class='btn btn-edit' href='editPost.php?post_id=". $row['post_id'] ."'>Edit</a></td>
            <td><a class='btn btn-delete' href='deletePost.php?post_id=". $row['post_id'] ."'>Delete</a></td>
            <td><a class='btn btn-custom' href='viewPost.php?post_id=". $row['post_id'] ."'>View</a></td>
          </tr>";

    }
    //if there are no posts, display message
    } else {
      echo "<p class='text-muted'>You have not yet created any posts!</p>";

    }

    echo "</table>";

?>
