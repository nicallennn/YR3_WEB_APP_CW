<?php
  //start the session
  session_start();

  //define TITLE constant
	define("TITLE", "GRF - Search");
  //include header
  include('includes/header.php');

?>

<!-- check if js is enabled, if not redirect to simple search -->
<!-- /*******************************************************************
CODE ADAPTED FROM STACK OVERFLOW - HOW TO REDIRECT IF JAVASCRIPT IS DISABLED
Found at: https://stackoverflow.com/questions/2489376/how-to-redirect-if-javascript-is-disabled
********************************************************************/ -->
<noscript>
  <!-- do not display search.php -->
  <style>html{display:none;}</style>
  <!-- refresh the browser, redirected to simpleSearch.php -->
  <meta http-equiv="refresh" content="0; url=http://stuweb.cms.gre.ac.uk/~na2880g/web/cw/simpleSearch.php" />
</noscript>

<!--

      ==================
      SEARCH.PHP START
      ==================

   -->

<!-- container  -->
<div class="container pt-3">
  <!-- display post title and publish date-->
  <div class="bg-forms p-3 pb-0 mb-0 mt-3 d-inline-block rounded">
    <h1 class="m-0 p-0">Search Posts</h1>
    <p class="text-muted p-0 m-0 mt-1">Use the form below to search for posts.</p>
  </div>

  <!--

  **************** ENTER SEARCH PERAMETERS **************

  -->

      <!-- new row -->
      <div class="mx-0 row mt-5">
         <div class="col-md-12 px-0">

          <!-- create new post form-->
          <div class="m-0 p-2 py-2 custom-title-create rounded-top">
            <h4 class="m-0 p-2">Search Parameters</h4>
          </div>

          <form class="rounded-bottom px-3 bg-forms" action="searchResults.php" method="POST">

          <!-- create new row-->
          <div class="row">
            <!-- start first column-->
            <div class="col-xs-12 col-md-12">

                <!-- *********** GOOGLE MAP ******************
                CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - GOOGLE MAP INTEGRATION
                Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/JavaScript/GoogleMap.html
                -->
                    <div class="form-group mt-3">
                      <label for="start_end">Select Start and End Points</label>
                      <!-- map -->
                      <div id="map" class=" mt-0 rounded bg-forms" style="width:100%;height:400px;"></div>
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
                        alert("You may only add two markers at a time!");

                      }

                    }//end placemarker function
                      </script>

                      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuYMbDntArftsjQfjm1cwciEvVhCHMQYo&callback=myMap"></script>

                      <!--
                      To use this code on your website, get a free API key from Google.
                      Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
                      -->
                    </div><!-- end column -->
                </div><!-- end row -->


                <!-- second row -->
            <div class="row">
              <div class="col-xs-12 col-md-6">

                <!-- start point -->
                <div class="form-group mt-3">
                  <label for="start">Start Point</label>
                  <input type="text" class="form-control" id="start" readonly name="start" required>
                </div>
                <!-- end point -->
                <div class="form-group mt-3">
                  <label for="end">End Point</label>
                  <input type="text" class="form-control" id="end" readonly name="end" required>
                </div>
                <!-- time -->
                <div class="form-group mt-3">
                  <label for="time">Between Times</label>
                  <div class="row px-3">
                  <input type="time" class="form-control col-sm-6" id="start-time" name="start-time" value="07:00" required>
                  <input type="time" class="form-control col-sm-6" id="end-time" name="end-time" value="08:00" required>
                  </div>
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

                <!-- obtain or provide lift -->
                <div class="form-group mt-3">
                  <label for="obtain_provide">Days</label>
                  <select class="form-control" id="obtain_provide" name="obtain_provide">
                    <option value="Obtain" select="selected">Obtain</option>
                    <option value="Provide">Provide</option>
                  </select>
                </div>




              </div><!-- end first col -->



              <!-- start second column-->
              <div class="col-md-6 col-xs-12">
                <!-- max start distance -->
                <div class="form-group mt-3">
                  <label for="time">Max Distance from Start Point (miles)</label>
                  <select class="form-control" id="start-distance" name="start-distance">
                      <option value="1">1</option>
                      <option value="5" selected="selected">5</option>
                      <option value="10">10</option>
                      <option value="20">20</option>
                  </select>
                </div>

                <!-- max end distance -->
                <div class="form-group mt-3">
                  <label for="time">Max Distance from End Point (miles)</label>
                  <select class="form-control" id="end-distance" name="end-distance">
                    <option value="1">1</option>
                    <option value="5" selected="selected">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                  </select>
                </div>



                <!-- sort results by distance -->
                <div class="form-group mt-3">
                  <label for="time">Sort Results via Distance to</label>
                  <select class="form-control" name="sortBy" id="sortBy">
                      <option value="start">Start</option>
                      <option value="end">End</option>
                  </select>
                </div>

                <!-- include posts without images -->
                <div class="form-group mt-3">
                  <label for="postImages">Include Posts without Images</label>
                  <select class="form-control" name="postImages" id="postImages">
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                  </select>
                </div>

                <!-- buttons -->
                <div class="mt-4">
                  <!-- submit button-->
                  <input class="btn btn-custom mb-2" type="submit" value="Submit">
                  <!-- reset button-->
                  <button class="btn btn-delete mb-2 mx-1" onclick="clearOverlays()" type="reset">Reset</button>
                </div>


                    <!-- hidden inputs for lat/lng for comments -->
                    <div class="form-group mt-3">
                      <input type="hidden" name="start-lat" id="start-lat" value = "">
                      <input type="hidden" name="start-lng" id="start-lng" value = "">
                      <input type="hidden" name="end-lat" id="end-lat" value = "">
                      <input type="hidden" name="end-lng" id="end-lng" value = "">
                    </div>







              </div><!-- end second col-->
          </div><!-- end row -->
        </form>

      </div> <!-- end column -->
  </div> <!-- end row -->

</div><!-- end container -->

<?php

  include('includes/footer.php');

?>
