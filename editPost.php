<?php
  session_start();
  require('includes/connect.php');
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

  //get post_if from session variable
  $post_id = $_GET['post_id'];
  //create post query string
  $postQuery = "SELECT * FROM post where post_id = '$post_id'";
  //run the query
  $result = mysqli_query($conn, $postQuery);

  //sort the results to variables
  while($row = mysqli_fetch_assoc($result)){
    $post_title = $row['post_title'];
    $start = $row['start_point'];
    $end = $row['end_point'];
    $start_lat = $row['start_lat'];
    $start_lng = $row['start_lng'];
    $end_lat = $row['end_lat'];
    $end_lng = $row['end_lng'];
    $times = $row['times'];
    $days = $row['days'];
    $obtain_provide = $row['obtain_provide'];
    $comments = $row['comments'];
  }
  //close the db connection
  mysqli_close($conn);

	//define TITLE constant
	define("TITLE", "Greenwich Ride Finder");
	#nclude header
	include('includes/header.php');

?>

	<!--

        ==================
        EDITPOST.PHP START
        ==================

     -->

    <!-- container  -->
	<div class="container pt-3">

    <!-- new row -->
    <div class="mx-0 row mt-5">
    	 <div class="col-md-12 pl-0">

        <!-- create new post form-->
        <div class="m-0 p-2 py-2 custom-title-create rounded-top">
          <h4 class="m-0 p-2">Edit Post</h4></div>
          <form class="rounded-bottom px-3 bg-forms" action="includes/updatePostScript.php" method="POST">

            <!-- create new row-->
            <div class="row">
              <!-- start first column-->
              <div class="col-md-6 col-xs-12">
                <!--
                /*******************************************************************
                CODE ADAPTED FROM W3SCHOOLS - HTML5 INPUT TYPE HIDDEN
                Found at: https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_input_type_hidden
                ********************************************************************/ -->
                  <!-- hidden input to hold post_id-->
                  <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?> ">
                  <?php //echo $post_id; ?>

                  <!--post title -->
                  <div class="form-group mt-3">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" id="title" required name="title" value="<?php echo $post_title;  ?>">
                  </div>

                  <!-- *********** GOOGLE MAP ******************
                  CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - GOOGLE MAP INTEGRATION
                  Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/JavaScript/GoogleMap.html
                  -->
                      <div class="form-group mt-3">
                        <label for="start_end">Select Start and End Points</label>
                        <!-- map -->
                        <div id="map" class=" mt-0 rounded bg-forms" style="width:100%;height:300px;"></div>
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
                        var start_marker = new google.maps.LatLng(<?php echo $start_lat;?>, <?php echo $start_lng;?>);
                        var end_marker = new google.maps.LatLng(<?php echo $end_lat;?>, <?php echo $end_lng;?>);

                        //place the initial markers
                        placeMarker(map, start_marker);
                        placeMarker(map, end_marker);

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
                  <div class="form-group mt-3">
                    <label for="start">Start Point</label>
                    <input type="text" class="form-control" id="start" readonly required name="start" value="<?php echo $start;  ?>">
                  </div>
                  <!-- end point -->
                  <div class="form-group mt-3">
                    <label for="end">End Point</label>
                    <input type="text" class="form-control" id="end" readonly required name="end" value="<?php echo $end;  ?>">
                  </div>


                </div><!-- end first col-->

                <!-- start second column-->

                <div class="col-md-6 col-xs-12">
                  <!-- time -->
                  <div class="form-group mt-3">
                    <label for="times">Time</label>
                    <input type="time" class="form-control" id="times" required name="times" value="<?php echo $times;  ?>">
                  </div>

                  <!-- days -->
                  <div class="form-group mt-3">
                    <label for="days">Days</label>
                    <select class="form-control" id="days" name="days">

                      <?php
                        //select option based on users original input

                        if($days == "Monday"){
                          echo '
                          <option value="Monday" selected="selected">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Tuesday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday" selected="selected">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Wednesday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday" selected="selected">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Thursday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday" selected="selected">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Friday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday" selected="selected">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Saturday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday" selected="selected">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Sunday"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday" selected="selected">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Weekdays"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays" selected="selected">Weekdays</option>
                          <option value="Weekends">Weekends</option>

                          ';
                        }else if($days == "Weekends"){
                          echo '
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                          <option value="Weekdays">Weekdays</option>
                          <option value="Weekends" selected="selected">Weekends</option>

                          ';
                        }
                      ?>

                    </select>
                  </div>
                  <!-- obtain or provide -->
                  <div class="form-group mt-3">
                    <label for="obtain_provide">Are you looking to obtain or provide a lift?</label>
                    <!-- /*******************************************************************
                    CODE ADAPTED FROM W3SCHOOLS - HMTL FORM ELEMENTS
                    Found at: https://www.w3schools.com/html/html_form_elements.asp
                    ********************************************************************/ -->
                    <select class="form-control" id="obtain_provide" name="obtain_provide">
                      <!-- check if post was set to obtain or provide a life -->
                      <?php if($obtain_provide == "Obtain"){
                        //set select option as per the result
                        echo '<option value="Obtain" selected="selected">Obtain</option>';
                        echo '<option value="Provide">Provide</option>';
                      } else {
                        echo '<option value="Obtain">Obtain</option>';
                        echo '<option value="Provide" selected="selected">Provide</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <!-- textarea for comments -->
                  <div class="form-group mt-3">
                    <label for="comments">Comments</label>
                    <textarea id="comments" class="form-control" name="comments" rows="5"><?php echo $comments;  ?></textarea>
                  </div>

                  <!-- hidden inputs for lat/lng for comments -->
                  <div class="form-group mt-3">
                    <input type="hidden" name="start-lat" id="start-lat" value = "<?php echo $start_lat;  ?>">
                    <input type="hidden" name="start-lng" id="start-lng" value = "<?php echo $start_lng;  ?>">
                    <input type="hidden" name="end-lat" id="end-lat" value = "<?php echo $end_lat;  ?>">
                    <input type="hidden" name="end-lng" id="end-lng" value = "<?php echo $end_lng;  ?>">
                  </div>


                    <!-- buttons -->
                    <div class="mt-4">
                    <!-- submit button-->
          					<input class="btn btn-custom mb-2" type="submit" value="Save">
          					<!-- reset button-->
          					<a href="account.php" class="btn btn-delete mb-2 mx-1">Cancel</a>
                    </div>
                </div><!-- end second col-->
            </div><!-- end row -->
          </form>

        </div> <!-- end column -->
    </div> <!-- end row -->

    <!-- remove images -->
    <div class="m-0 p-2 mt-4 custom-title-create rounded-top">
      <h4 class="m-0 p-2">Remove Images</h4>
    </div>
    <!-- new row -->
    <div class="row mx-0 bg-forms p-3 mt-0 mb-0 rounded-bottom ">

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
              echo mysqli_error($conn);
            }else{
                for ( $i = 0 ; $i < mysqli_num_rows($result) ; $i++ ) {
                $row = mysqli_fetch_assoc($result);

                echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 p-0 m-0 ">';
                  echo '<div class="mx-auto">';
                    echo '<img class="d-block mx-auto" height="160" width="160" src="includes/getImage.php?image_id=' . $row['image_id'] . '" alt="' . $row['image_alt'] . '" title="' . $row['name']  .'"/>  ' . "\n";
                    echo '<a class="btn btn-delete btn-sm d-block mx-auto w-25 mt-2" href="includes/deleteImageScript.php?post_id=' . $post_id  . ' &image_id=' . $row['image_id'] . '">Delete</a>';

                  echo '</div>';
                echo '</div>';
                }
            }
            mysqli_close($conn);
          ?>




    </div> <!-- end row -->



  </div><!-- #container-->


<?php
	#include footer
	include('includes/footer.php');

?>
