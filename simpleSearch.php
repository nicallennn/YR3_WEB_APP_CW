<?php
  //start the session
  session_start();


  //define TITLE constant
	define("TITLE", "GRF - Search");
  //include header
  include('includes/header.php');

?>


<!--

      ==================
      SIMPLESEARCH.PHP START
      ==================

   -->

<!-- container  -->
<div class="container pt-3">
  <!-- display post title and publish date-->
  <div class="bg-forms p-3 pb-0 mb-0 mt-3 d-inline-block rounded">
    <h1 class="m-0 p-0">Simple Search</h1>
    <p class="text-danger p-0 m-0 mt-1">Javascript is not enabled in your browser!</p><br>
    <p class="text-muted p-0 m-0 mt-1">Enable Javascript to access the full search parameters or use the form below to conduct a simple search.</p>

    <p class="small text-danger p-0 m-0 mt-3">*** Note: The simple search will only find results with an exact postcode match.
      If you do not find any results try entering just the first part of your postcode. (e.g. For: SE10 9LS, Search: SE10) ***</p>

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

          <form class="rounded-bottom px-3 bg-forms" action="simpleSearchResults.php" method="POST">

                <!-- second row -->
            <div class="row">
              <div class="col-xs-12 col-md-6">

                <!-- start point -->
                <div class="form-group mt-3">
                  <label for="start">Start Postcode</label>
                  <input type="text" class="form-control" id="start" name="start" required>
                </div>
                <!-- end point -->
                <div class="form-group mt-3">
                  <label for="end">End Postcode</label>
                  <input type="text" class="form-control" id="end" name="end" required>
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

              </div><!-- end first col -->



              <!-- start second column-->
              <div class="col-md-6 col-xs-12">

                <!-- obtain or provide lift -->
                <div class="form-group mt-3">
                  <label for="obtain_provide">Days</label>
                  <select class="form-control" id="obtain_provide" name="obtain_provide">
                    <option value="Obtain" select="selected">Obtain</option>
                    <option value="Provide">Provide</option>
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
