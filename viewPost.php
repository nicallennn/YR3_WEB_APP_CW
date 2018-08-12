<?php

  //start the session
  session_start();

  //check the user is logged in
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    //echo "logged in";
  } else {
    //redirect to login page
    header('Location: index.php?error=viewPost');
    die();
  }


  //get the post id from get array
  $post_id = $_GET['post_id'];
  //find out if user viewed post from main or simple search or accounts page
  if(isset($_GET['from'])){
      $from = $_GET['from'];
  }else{
    $from = "";
  }

  if($from == "simple"){
    //set session variables to return to simple search results
    $search_start = $_SESSION['start'];
    $search_end = $_SESSION['end'];
    $search_postImages = $_SESSION['postImages'];
    $search_startTimes = $_SESSION['startTimes'];
    $search_endTimes = $_SESSION['endTimes'];
    $search_days = $_SESSION['days'];
    $search_obtain_provide = $_SESSION['obtain_provide'];

  }else if($from == "main"){
      //set session variables to return to main search results
      $search_start = $_SESSION['start'];
      $search_end = $_SESSION['end'];
      $search_start_lat = $_SESSION['start_lat'];
      $search_start_lng = $_SESSION['start_lng'];
      $search_end_lat = $_SESSION['end_lat'];
      $search_end_lng = $_SESSION['end_lng'];
      $search_sortBy = $_SESSION['sortBy'];
      $search_startDistance = $_SESSION['startDistance'];
      $search_endDistance = $_SESSION['endDistance'];
      $search_postImages = $_SESSION['postImages'];
      $search_startTimes = $_SESSION['startTimes'];
      $search_endTimes = $_SESSION['endTimes'];
      $search_days = $_SESSION['days'];
      $search_obtain_provide = $_SESSION['obtain_provide'];
  }


  //connect to database
  require('includes/connect.php');

  //define TITLE constant
	define("TITLE", "GRF - View Post");
  //include header
  include('includes/header.php');

  //create quer string to get post details
  $getPostQuery = "SELECT * FROM post WHERE post_id = '$post_id'";

  //run the query
  $result = mysqli_query($conn, $getPostQuery);

  //if there are results
  if(mysqli_num_rows($result) > 0) {
        //sort the results to display
        while($row = mysqli_fetch_assoc($result)){
            $post_id = $row['post_id'];
            $postUserId = $row['user_id'];
            $title = $row['post_title'];
            $start = $row['start_point'];
            $end = $row['end_point'];
            $start_lat = $row['start_lat'];
            $start_lng = $row['start_lng'];
            $end_lat = $row['end_lat'];
            $end_lng = $row['end_lng'];
            $times = $row['times'];
            $days = $row['days'];
            $obtain_provide = $row['obtain_provide'];
            $post_date = $row['post_date'];
            $comments = $row['comments'];
        }

      //get user email query
      $emailQuery = "SELECT email FROM users WHERE user_id = '$postUserId'";
      //run the query
      $result = mysqli_query($conn, $emailQuery);
      $row = mysqli_fetch_assoc($result);
      $email = $row['email'];

    }else{
      //close the connection to the db
      mysqli_close($conn);

  }
  //close the connection to the db
  mysqli_close($conn);
  ?>
  <!--
        ==================
        VIEWPOST.PHP START
        ==================
     -->

  <!-- container  -->
  <div class="container pt-3">
    <!-- display post title and publish date-->
    <div class="bg-forms p-3 pb-0 mb-0 mt-3 d-inline-block rounded">
      <h1 class="m-0 p-0">View Post : <?php echo $title; ?></h1>
      <p class="text-muted p-0 m-0 mt-1">Publish date: <?php echo $post_date?></p>
    </div>

    <!-- post details title -->
    <div class="m-0 p-2 mt-4 custom-title-create rounded-top">
      <h4 class="m-0 p-2">Post Details</h4>
    </div>
    <!-- new row -->
    <div class="row mx-0 bg-forms p-3 mt-0 mb-0 rounded-bottom ">

      <!-- new column-->
      <div class="col-xs-12 col-md-6 p-0 m-0 ">
        <!-- display first set of details -->
        <?php
        echo "<p class=''>Start Point: $start </p>
              <p class='mt-3'>End Point: $end </p>
              <p class='mt-3'>Time: $times </p>
              <p class='mt-3 mb-0'>Days: $days </p>
              <p class='mt-3'>Obtain or provide lift: $obtain_provide </p>
              <p class='mt-3'>Comments: $comments </p>
              <p class='mt-3'>Email: $email </p>";

        ?>
        <?php
        //create hidden form to revert back to simple search
        if($from == "simple"){
            echo "
                <form class='m-0 p-0' method='POST' action='simpleSearchResults.php'>

                  <input type='hidden' name='start' id='start' value='$search_start'>
                  <input type='hidden' name='end' id='end' value='$search_end'>
                  <input type='hidden' name='postImages' id='postImages' value='$search_postImages'>
                  <input type='hidden' name='start-time' id='start-time' value='$search_startTimes'>
                  <input type='hidden' name='end-time' id='end-time' value='$search_endTimes'>
                  <input type='hidden' name='days' id='days' value='$search_days'>
                  <input type='hidden' name='obtain_provide' id = 'obtain_provide' value='$search_obtain_provide'>

                  <input class='btn btn-custom mb-2' type='submit' value='Return to search results'>
                </form>
                 ";
        //create hidden form to revert back to simple search
        }else if($from == "main"){
          echo "
               <form class='m-0 p-0' method='POST' action='searchResults.php'>

               <input type='hidden' name='start' id='start' value='$search_start'>
               <input type='hidden' name='end' id='end' value='$search_end'>
               <input type='hidden' name='start-lat' id='start-lat' value='$search_start_lat'>
               <input type='hidden' name='start-lng' id='start-lng' value='$search_start_lng'>
               <input type='hidden' name='end-lat' id='end-lat' value='$search_end_lat'>
               <input type='hidden' name='end-lng' id='end-lng' value='$search_end_lng'>
               <input type='hidden' name='sortBy' id='sortBy' value='$search_sortBy'>
               <input type='hidden' name='start-distance' id='start-distance' value='$search_startDistance'>
               <input type='hidden' name='end-distance' id='end-distance' value='$search_endDistance'>
               <input type='hidden' name='postImages' id='postImages' value='$search_postImages'>
               <input type='hidden' name='start-time' id='start-time' value='$search_startTimes'>
               <input type='hidden' name='end-time' id='end-time' value='$search_endTimes'>
               <input type='hidden' name='days' id='days' value='$search_days'>
               <input type='hidden' name='obtain_provide' id = 'obtain_provide' value='$search_obtain_provide'>

               <input class='btn btn-custom mb-2' type='submit' value='Return to search results'>

               </form>

               ";

        }else{
          //else add button to return to account
          echo "
               <form class='m-0 p-0' method='POST' action='account.php'>

               <input class='btn btn-custom mb-2' type='submit' value='Return to account'>

               </form>

               ";
        }

        ?>


      </div><!-- end column-->

      <!-- new column-->
      <div class="col-xs-12 col-md-6 p-0 m-0  ">
        <!-- display map -->

          <!-- map -->
          <div id="map" class=" mt-0 rounded bg-forms" style="width:100%;height:350px;">
              <noscript>
                <p class="small text-danger mx-3 mt-3">Enable Javascript to view map</p>
              </noscript>

          </div>


        <!-- *********** GOOGLE MAP ******************
        CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - GOOGLE MAP INTEGRATION
        Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/JavaScript/GoogleMap.html
        -->
        <!-- script to initialise map and define functions -->
        <script>
          function myMap() {
          var mapCanvas = document.getElementById("map");
          var myCenter=new google.maps.LatLng(51.4826,0.0077);
          var mapOptions = {center: myCenter, zoom: 12};
          var map = new google.maps.Map(mapCanvas, mapOptions);
          var start_marker = new google.maps.LatLng(<?php echo $start_lat;?>, <?php echo $start_lng;?>);
          var end_marker = new google.maps.LatLng(<?php echo $end_lat;?>, <?php echo $end_lng;?>);

          //place the initial markers
          placeMarker(map, start_marker);
          placeMarker(map, end_marker);

          google.maps.event.addDomListener(window, "resize", function() {
           var center = map.getCenter();
           google.maps.event.trigger(map, "resize");
           map.setCenter(center);
           });
          }

          //placeMarker function - places a marker and sets the start/end location
          function placeMarker(map, location) { // this function is called when the map is clicked
            var marker = new google.maps.Marker({
              position: location,
              map: map,

            });



        }//end placemarker function
          </script>

          <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuYMbDntArftsjQfjm1cwciEvVhCHMQYo&callback=myMap"></script>

          <!--
          To use this code on your website, get a free API key from Google.
          Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
          -->




      </div><!-- end column-->

    </div><!-- end row-->


    <!-- show images -->
    <div class="m-0 p-2 mt-4 custom-title-create rounded-top">
      <h4 class="m-0 p-2">Images</h4>
    </div>
    <!-- new row -->
    <div class="row mx-0 bg-forms p-3 mt-0 mb-0 rounded-bottom ">

      <!-- new column-->
      <div class="col-xs-12 p-0 m-0 ">

          <?php
            //connect to the database
            require('includes/connect.php');

            //create query sting to get images from db
            $getImageQuery = "SELECT image_id, name, image_alt FROM
                              images WHERE post_id = '$post_id'";
            //run the query
            $result = mysqli_query($conn, $getImageQuery);
            if(!$result){
              //close connection to the database
              mysqli_close($conn);
            }else{
                for ( $i = 0 ; $i < mysqli_num_rows($result) ; $i++ ) {
                $row = mysqli_fetch_assoc($result);
                echo '<img src="includes/getImage.php?image_id=' . $row['image_id'] . '" alt="' . $row['image_alt'] . '" title="' . $row['name']  .'"/>  ' . "\n";

                }
            }
            //close connection to the database
            mysqli_close($conn);
          ?>
      </div> <!-- close column-->
    </div> <!-- end row -->

  </div> <!-- end container -->

<?php

  include('includes/footer.php');

?>
