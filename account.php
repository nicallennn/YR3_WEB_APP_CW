<?php
  //start the session
  session_start();
  //unset post_id session variable, this is to ensure images are added to the correct post if
  //user moves between add image and account page!!!!
  unset($_SESSION['post_id']);
  /*******************************************************************
  CODE ADAPTED FROM STACK OVERFLOW - HOW TO CHECK IF A USER IS LOGGED-IN IN PHP?
  Found at: https://stackoverflow.com/questions/1545357/how-to-check-if-a-user-is-logged-in-in-php
  ********************************************************************/
  //check if user is logged in
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    //echo "logged in";
  } else {
    //if user is not logged in, redirect to login page
    header('Location: index.php');
    die();
  }

	//define TITLE constant
	define("TITLE", "GRF - Account");
	#nclude header
	include('includes/header.php');

?>

	<!--

        ==================
        ACCOUNT.PHP START
        ==================

     -->

    <!-- container  -->
	<div class="container pt-3">
    <!-- display welcome message-->
    <div class="bg-forms p-3 mt-3  d-inline-block rounded">
      <h1>Hello <?php echo $_SESSION['loggedInUser'] ?>!</h1>
  		<p class="text-muted">Create, edit and view your posts!</p>
    </div>

    <!-- if the last search cookie is set, get values -->
    <?php
    if(isset($_COOKIE["searchCookie"])){
      $last_start = $_COOKIE["searchCookie"]["start"];
      $last_end = $_COOKIE["searchCookie"]["end"];
      $last_start_lat = $_COOKIE["searchCookie"]["start_lat"];
      $last_start_lng = $_COOKIE["searchCookie"]["start_lng"];
      $last_end_lat = $_COOKIE["searchCookie"]["end_lat"];
      $last_end_lng = $_COOKIE["searchCookie"]["end_lng"];
      $last_start_distance = $_COOKIE["searchCookie"]["startDistance"];
      $last_end_distance = $_COOKIE["searchCookie"]["endDistance"];
      $last_sortBy = $_COOKIE["searchCookie"]["sortBy"];
      $last_post_images = $_COOKIE["searchCookie"]["postWithoutImages"];
      $last_start_times = $_COOKIE["searchCookie"]["startTimes"];
      $last_end_times = $_COOKIE["searchCookie"]["endTimes"];
      $last_days = $_COOKIE["searchCookie"]["days"];
      $last_obtain = $_COOKIE["searchCookie"]["obtain_provide"];

        //print_r($_COOKIE["searchCookie"]);

    }
    if(isset($_COOKIE["searchCookie"])){
    echo "

    <div class='bg-forms p-3 mt-3 mb-0 mx-0 rounded'>
  		<p class='mb-0'>Last Search: </p>
      <p class='text-muted pt-0'> $last_start to $last_end </p>

               <form method='POST' action='searchResults.php'>

               <input type='hidden' name='start' id='last-start' value='$last_start'>
               <input type='hidden' name='end' id='last-end' value='$last_end'>
               <input type='hidden' name='start-lat' id='last-start-lat' value='$last_start_lat'>
               <input type='hidden' name='start-lng' id='last-start-lng' value='$last_start_lng'>
               <input type='hidden' name='end-lat' id='last-end-lat' value='$last_end_lat'>
               <input type='hidden' name='end-lng' id='last-end-lng' value='$last_end_lng'>
               <input type='hidden' name='sortBy' id='last-sortBy' value='$last_sortBy'>
               <input type='hidden' name='start-distance' id='last-start-distance' value='$last_start_distance'>
               <input type='hidden' name='end-distance' id='last-end-distance' value='$last_end_distance'>
               <input type='hidden' name='postImages' id='last-postImages' value='$last_post_images'>
               <input type='hidden' name='start-time' id='last-start-time' value='$last_start_times'>
               <input type='hidden' name='end-time' id='last-end-time' value='$last_end_times'>
               <input type='hidden' name='days' id='last-days' value='$last_days'>
               <input type='hidden' name='obtain_provide' id = 'last-obtain_provide' value='$last_obtain'>

               <input class='btn btn-custom mb-2 btn-sm' type='submit' value='View'>

               </form>
               </div>
               ";

             }
           ?>


    <!-- new row -->
    <div class="mx-0 mt-4 row ">
      <!-- new column set to 12 columns wide on all screen sizes-->
    	 <div class="col-xs-12 mt-2 ">
        <!-- display user posts-->
        <div class="m-0 pt-4 px-3 custom-title rounded-top">
            <h4 class="m-0">Your Posts</h4>
        </div>
        <div class="px-3 py-3 rounded-bottom  custom-border">
          <?php
          //display posts
          include('includes/getPostScript.php');
          ?>
        </div>
      </div> <!-- end column -->
    </div> <!-- end row -->

    <!--

    ****************CREATE NEW POST**************

    -->

    <!-- new row -->
    <div class="mx-0 row mt-5">
    	 <div class="col-md-12 px-0">

        <!-- create new post form-->
        <div class="m-0 p-2 py-2 custom-title-create rounded-top">
          <h4 class="m-0 p-2">Create Post</h4>
        </div>

        <form class="rounded-bottom px-3 bg-forms" action="includes/addPostScript.php" method="POST">

            <!-- create new row-->
            <div class="row">
              <!-- start first column-->
              <div class="col-md-6 col-xs-12">
                  <!--post title -->
                  <div class="form-group mt-3">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" id="title"  name="title" required>
                  </div>

                  <!-- *********** GOOGLE MAP ******************
                  CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - GOOGLE MAP INTEGRATION
                  Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/JavaScript/GoogleMap.html
                  -->
                      <div class="form-group mt-3">
                        <label for="start_end">Select Start and End Points</label>
                        <!-- map -->
                        <div id="map" class=" mt-0 rounded bg-forms" style="width:100%;height:300px;">
                          <!-- if js is disabled prmopt the user to enable or use simple creat post form-->
                          <noscript>
                            <p class="small text-danger mx-3 mt-3">*** Enable Javascript and refresh to select start and end points from map or
                                <a id="custom-links" href="simpleCreatePost.php">click here</a> to use the simple create post form
                             ***</p>
                          </noscript>
                        </div>


                        <!-- clear markers button -->
                        <button type="button" class="btn-delete btn-sm btn mt-2 float-right" onclick="clearOverlays()">Clear Markers</button>
                      </div>

                      <!-- script to initialise map and define functions -->
                      <script>
                        var markersArray = []; // global array to store the marker positions
                        var markerCount = 0;   // variable to store marker count

                        //function to clear the markers
                        function clearOverlays() {	// clearing the array
                        while(markersArray.length) { markersArray.pop().setMap(null); }
                        markersArray = [];
                        markerCount = 0
                        //reset geocode and lat,lng
                        document.getElementById("start").value = " ";
                        document.getElementById("end").value = " ";
                        document.getElementById("start-lat").value = " ";
                        document.getElementById("start-lng").value = " ";
                        document.getElementById("end-lat").value = " ";
                        document.getElementById("end-lng").value = " ";

                        }

                        function myMap() {
                        var mapCanvas = document.getElementById("map");
                        var myCenter=new google.maps.LatLng(51.4826,0.0077);
                        var mapOptions = {center: myCenter, zoom: 12};
                        var map = new google.maps.Map(mapCanvas, mapOptions);

                        google.maps.event.addListener(map, 'click', function(event) {
                          placeMarker(map, event.latLng);
                        });

                        google.maps.event.addDomListener(window, "resize", function() {
                         var center = map.getCenter();
                         google.maps.event.trigger(map, "resize");
                         map.setCenter(center);
                         });
                        }

                        //placeMarker function - places a marker and sets the start/end location
                        function placeMarker(map, location) { // this function is called when the map is clicked
                        //limit the number of markers to two
                        if(markerCount <= 1){
                          markerCount++;

                          var marker = new google.maps.Marker({
                            position: location,
                            map: map,
                          });


                          //push the marker into the markers array
                          markersArray.push(marker);


                          var geocoder  = new google.maps.Geocoder();   // create a geocoder object
                           var loc  = new google.maps.LatLng(location.lat(), location.lng());    // turn coordinates into an object
                           geocoder.geocode({'latLng': loc}, function (results, status) {
                          if(status == google.maps.GeocoderStatus.OK) {// if geocode success
                              var add=results[0].formatted_address;   // if address found, pass to processing function
                              if(markerCount == 1){
                                //if it is the first marker add location/latlng
                                document.getElementById("start").value = add;
                                document.getElementById("start-lat").value = location.lat();
                                document.getElementById("start-lng").value = location.lng();
                              }else if(markerCount == 2){
                                //elseif it is the second marker add location/latlng
                                document.getElementById("end").value = add;
                                document.getElementById("end-lat").value = location.lat();
                                document.getElementById("end-lng").value = location.lng();
                               }
                            }
                           });

                        //if there are alredy 2 markers on the screen
                        }else{
                          //inform the uesr they may only add two markers
                          alert("You may only add two markers at a time! Clear the markers using the button below the map.");

                        }

                      }//end placemarker function
                        </script>

                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuYMbDntArftsjQfjm1cwciEvVhCHMQYo&callback=myMap"></script>

                        <!--
                        To use this code on your website, get a free API key from Google.
                        Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
                        -->


                  <!-- start point -->
                  <div class="form-group mt-4">
                    <label for="start">Start Point</label>
                    <input type="text" class="form-control" id="start" name="start" readonly required>
                  </div>
                  <!-- end point -->
                  <div class="form-group mt-3">
                    <label for="end">End Point</label>
                    <input type="text" class="form-control" id="end" name="end" readonly required>
                  </div>

                </div><!-- end first col -->

                <!-- start second column-->
                <div class="col-md-6 col-xs-12">
                      <!-- time -->
                      <div class="form-group mt-3">
                        <label for="time">Time</label>
                        <input type="time" class="form-control" id="time" name="time" value="07:00" required>
                      </div>
                      <!-- days -->
                      <div class="form-group mt-3">
                        <label for="days">Days</label>
                        <select class="form-control" id="days" name="days">
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays" selected="selected">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                        </select>
                      </div>
                      <!-- obtain or provide -->
                      <div class="form-group mt-3">
                        <label for="obtain_provide">Are you looking to obtain or provide a lift?</label>
                        <!-- /*******************************************************************
                        CODE ADAPTED FROM W3SCHOOLS - HMTL FORM ELEMENTS
                        Found at: https://www.w3schools.com/html/html_form_elements.asp
                        ********************************************************************/ -->
                        <select class="form-control" id="obtain_provide"  name="obtain_provide">
                          <option value="Obtain">Obtain</option>
                          <option value="Provide">Provide</option>
                        </select>
                      </div>

                      <!-- textarea for comments -->
                      <div class="form-group mt-3">
                        <label for="comments">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="5" required></textarea>
                      </div>

                      <!-- hidden inputs for lat/lng for comments -->
                      <div class="form-group mt-3">
                        <input type="hidden" name="start-lat" id="start-lat" value = "">
                        <input type="hidden" name="start-lng" id="start-lng" value = "">
                        <input type="hidden" name="end-lat" id="end-lat" value = "">
                        <input type="hidden" name="end-lng" id="end-lng" value = "">
                      </div>

                        <!-- buttons -->
                        <div class="mt-4">
                        <!-- submit button-->
              					<input class="btn btn-custom mb-2" type="submit" value="Submit">
              					<!-- reset button-->
              					<button class="btn btn-delete mb-2 mx-1" onclick="clearOverlays()" type="reset">Reset</button>
                      </div>





                </div><!-- end second col-->
            </div><!-- end row -->
          </form>

        </div> <!-- end column -->
    </div> <!-- end row -->



  </div><!-- #container-->


<?php
	#include footer
	include('includes/footer.php');

?>
