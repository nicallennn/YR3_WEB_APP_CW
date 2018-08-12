<?php
  //start the session
  session_start();

  //check if the post is set, if not redirect to search page
  if($_SERVER["REQUEST_METHOD"] != "POST"){
    header('Location: search.php');
    die();
  }

  //arrays to sort posts by distance to start and end points
  $startArray = array();
  $endArray = array();
  $sortResultsArray = array();
  //sort by image arrays
  $sortByImageArray = array();
  //final posts array
  $finalPostsArray = array();

  //connect to database
  require("includes/connect.php");


  //if post array is set, get verification code from post array
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $start = mysqli_real_escape_string($conn, $_POST['start']);
    $end = mysqli_real_escape_string($conn, $_POST['end']);
    $start_lat = mysqli_real_escape_string($conn, $_POST['start-lat']);
    $start_lng = mysqli_real_escape_string($conn, $_POST['start-lng']);
    $end_lat = mysqli_real_escape_string($conn, $_POST['end-lat']);
    $end_lng = mysqli_real_escape_string($conn, $_POST['end-lng']);
    $sortBy = mysqli_real_escape_string($conn, $_POST['sortBy']);
    $startDistance = mysqli_real_escape_string($conn, $_POST['start-distance']);
    $endDistance = mysqli_real_escape_string($conn, $_POST['end-distance']);
    $postWithoutImages = mysqli_real_escape_string($conn, $_POST['postImages']);
    $startTimes = mysqli_real_escape_string($conn, $_POST['start-time']);
    $endTimes = mysqli_real_escape_string($conn, $_POST['end-time']);
    $days = mysqli_real_escape_string($conn, $_POST['days']);
    $obtain_provide = mysqli_real_escape_string($conn, $_POST['obtain_provide']);

    //set session variables so user can return to search results
    $_SESSION['start'] = $start;
    $_SESSION['end'] = $end;
    $_SESSION['start_lat'] = $start_lat;
    $_SESSION['start_lng'] = $start_lng;
    $_SESSION['end_lat'] = $end_lat;
    $_SESSION['end_lng'] = $end_lng;
    $_SESSION['sortBy'] = $sortBy;
    $_SESSION['startDistance'] = $startDistance;
    $_SESSION['endDistance'] = $endDistance;
    $_SESSION['postImages'] = $postWithoutImages;
    $_SESSION['startTimes'] = $startTimes;
    $_SESSION['endTimes'] = $endTimes;
    $_SESSION['days'] = $days;
    $_SESSION['obtain_provide'] = $obtain_provide;

  }



  //if user is logged in set searchCookie array to display last search
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    setcookie("searchCookie[start]", $start);
    setcookie("searchCookie[end]", $end);
    setcookie("searchCookie[start_lat]", $start_lat);
    setcookie("searchCookie[start_lng]", $start_lng);
    setcookie("searchCookie[end_lat]", $end_lat);
    setcookie("searchCookie[end_lng]", $end_lng);
    setcookie("searchCookie[sortBy]", $sortBy);
    setcookie("searchCookie[startDistance]", $startDistance);
    setcookie("searchCookie[endDistance]", $endDistance);
    setcookie("searchCookie[postWithoutImages]", $postWithoutImages);
    setcookie("searchCookie[startTimes]", $startTimes);
    setcookie("searchCookie[endTimes]", $endTimes);
    setcookie("searchCookie[days]", $days);
    setcookie("searchCookie[obtain_provide]", $obtain_provide);

}

  /*******************************************************************
  CODE ADAPTED FROM GOOGLE MAPS API - FINDING LOCATIONS WITH SQL
  Found at: https://developers.google.com/maps/solutions/store-locator/clothing-store-locator
  ********************************************************************/


  //query to search for start point
   $searchStartQuery = "SELECT *, ( 3959 * acos( cos( radians('$start_lat') ) * cos( radians( start_lat ) ) * cos( radians( '$start_lng' ) - radians(start_lng) )
   + sin( radians('$start_lat') ) * sin( radians( start_lat ) ) ) ) AS distance FROM post
   HAVING distance < '$startDistance' ORDER BY distance LIMIT 0 , 20;";

   //run the query
   $result = mysqli_query($conn, $searchStartQuery);

   if(mysqli_num_rows($result) > 0) {
     //echo "yeh";
      while($row = mysqli_fetch_assoc($result)){
/*  echo $row['post_id'] . "<br>" .
             $row['post_title'] . "<br>" .
             $row['start_point'] . "<br>" .
             $row['end_point'] . "<br>" .
             $row['times'] . "<br>" .
             $row['days'] . "<br><br>";
*/
        // add to the startArray
        array_push($startArray, $row['post_id']);
      }

      //echo "Count: " . count($startArray) . "<br>";

   }else{
     //echo "nah";
     //set error message ***************************
   }

   //query to search for end point
    $searchEndQuery = "SELECT *, ( 3959 * acos( cos( radians('$end_lat') ) * cos( radians( end_lat ) ) * cos( radians( '$end_lng' ) - radians(end_lng) )
    + sin( radians('$end_lat') ) * sin( radians( end_lat ) ) ) ) AS distance FROM post
    HAVING distance < '$endDistance' ORDER BY distance LIMIT 0 , 20;";

    //run the query
    $result = mysqli_query($conn, $searchEndQuery);

    if(mysqli_num_rows($result) > 0) {
      //echo "yeh";
       while($row = mysqli_fetch_assoc($result)){
        //add to endArray
        array_push($endArray, $row['post_id']);
       }
    }

    //if sort by start point
    if($sortBy == "start"){
      //sort the results
      for($i = 0; $i < count($startArray); $i++){
          for($j = 0; $j < count($endArray); $j++){
              if($startArray[$i] == $endArray[$j]){
                array_push($sortResultsArray, $startArray[$i]);
              }
          }

      }//end sorting
    //else if sort by end point
    }else if($sortBy == "end"){
      //sort the results
      for($i = 0; $i < count($endArray); $i++){
          for($j = 0; $j < count($startArray); $j++){
              if($endArray[$i] == $startArray[$j]){
                array_push($sortResultsArray, $endArray[$i]);
              }
          }

      }
    } //end start/end sorting

    //sort by image
    if($postWithoutImages == "No"){
          for($i = 0; $i < count($sortResultsArray); $i++){
          //check image query
          $imageQuery = "SELECT * FROM images WHERE post_id = '$sortResultsArray[$i]'";
          //run query
          $result = mysqli_query($conn, $imageQuery);
            //check for results
            if(mysqli_num_rows($result) > 0){
              //if post has images images, add to sort image array
              array_push($sortByImageArray, $sortResultsArray[$i]);
            }
        }

        //sort posts without images by by time and day
        for($i = 0; $i < count($sortByImageArray); $i++){
          $query = "SELECT times, days, obtain_provide FROM post WHERE post_id = '$sortByImageArray[$i]'";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          $compareTime = $row['times'];
          $compareDays = $row['days'];
          $obtainOrProvide = $row['obtain_provide'];


          //if post time and day is in the range of the users filters
          if(($compareTime >= $startTimes && $compareTime <= $endTimes) && ($compareDays == $days) && ($obtainOrProvide == $obtain_provide)){
              //add psot to the timeSortedArray
              array_push($finalPostsArray, $sortByImageArray[$i]);
          }
        }

    }else{
    //sort posts with images by time and days
    for($i = 0; $i < count($sortResultsArray); $i++){
      $query = "SELECT times, days, obtain_provide FROM post WHERE post_id = '$sortResultsArray[$i]'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);
      $compareTime = $row['times'];
      $compareDays = $row['days'];
      $obtainOrProvide = $row['obtain_provide'];


      //if post time and day is in the range of the users filters
      if(($compareTime >= $startTimes && $compareTime <= $endTimes) && ($compareDays == $days) && ($obtainOrProvide == $obtain_provide)){
          //add psot to the timeSortedArray
          array_push($finalPostsArray, $sortResultsArray[$i]);
      }
    }

}


//define TITLE constant
define("TITLE", "Greenwich Ride Finder");
#nclude header
include('includes/header.php');

?>

        <!--

              ==================
              SEARCHRESULTS.PHP START
              ==================

           -->

          <!-- container  -->
        <div class="container pt-3">

          <!-- display welcome message-->
          <div class="bg-forms p-3 mt-3 d-inline-block rounded">
            <h1>Search Results</h1>
        		<p class="text-muted">Please see the results of your search below.</p>
          </div>

          <!-- new row -->
          <div class="mx-0 row mt-5">

              <!-- loop through array and print paginated results -->
              <?php

                  if(count($finalPostsArray) > 14){
                      //only print first 14 results
                      for($i = 0; $i < 14; $i++){
                        $query = "SELECT post_id, post_title, start_point, end_point, times, days, obtain_provide
                        FROM post WHERE post_id = '$finalPostsArray[$i]'";

                        //run query
                        $result = mysqli_query($conn, $query);
                          while($row = mysqli_fetch_assoc($result)){
                              $post_id = $row['post_id'];
                              $post_title = $row['post_title'];
                              $start = $row['start_point'];
                              $end = $row['end_point'];
                              $times = $row['times'];
                              $days = $row['days'];
                              $obtain_provide = $row['obtain_provide'];

                              //print post to screen
                              echo "
                                  <div class='col-xs-12 col-md-6 mx-0 bg-forms p-3 mt-0 mb-0'>
                                      <p class=''>Post Title: $post_title </p>
                                      <p class='mt-3'>Start Point: $start </p>
                                      <p class='mt-3'>End Point: $end </p>
                                      <p class='mt-3'>Time: $times </p>
                                      <p class='mt-3'>Day/s: $days </p>
                                      <p class='mt-3'>Obtain or provide lift: $obtain_provide </p>
                                      <a class='btn btn-custom' href='viewPost.php?post_id=". $post_id ."&from=main'>View</a>
                                  </div>


                              ";
                        }//end print loop
                      }//end post count loop

                  }else{
                    for($i = 0; $i < count($finalPostsArray); $i++){
                      $query = "SELECT post_id, post_title, start_point, end_point, times, days, obtain_provide
                      FROM post WHERE post_id = '$finalPostsArray[$i]'";

                      //run query
                      $result = mysqli_query($conn, $query);
                        while($row = mysqli_fetch_assoc($result)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $start = $row['start_point'];
                            $end = $row['end_point'];
                            $times = $row['times'];
                            $days = $row['days'];
                            $obtain_provide = $row['obtain_provide'];

                            //print post to screen
                            echo "
                                <div class='col-xs-12 col-md-6 mx-0 bg-forms p-3 mt-0 mb-0'>
                                    <p class=''>Post Title: $post_title </p>
                                    <p class='mt-3'>Start Point: $start </p>
                                    <p class='mt-3'>End Point: $end </p>
                                    <p class='mt-3'>Time: $times </p>
                                    <p class='mt-3'>Day/s: $days </p>
                                    <p class='mt-3'>Obtain or provide lift: $obtain_provide </p>
                                    <a class='btn btn-custom' href='viewPost.php?post_id=". $post_id ."&from=main'>View</a>
                                </div>


                            ";
                      }
                    }

                }//end else

              ?>



          </div><!-- end row -->
        </div><!-- end container -->


<?php
  #include footer
  include('includes/footer.php');
?>
