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

        ===========================
        CREATESIMPLEPOST.PHP START
        ===========================

     -->

    <!-- container  -->
	<div class="container pt-3">
    <!-- display welcome message-->
    <div class="bg-forms p-3 mt-3 d-inline-block rounded">
      <h1>Create Simple Post</h1>
  		<p class="text-muted">Create a simple post using the form below.</p>

      <p class="small text-danger mt-3">*** Note: Posts created using the Create Simple Post Form will only be displayed
        in simple search results. i.e. Searches conducted with Javascript disabled. To create a full post, enable Javascript and head back to the Account page. ***</p>

    </div>



    <!--

    ****************CREATE NEW SIMPLE POST**************

    -->

    <!-- new row -->
    <div class="mx-0 row mt-5">
    	 <div class="col-md-12 px-0">

         <!-- create simple post form -->
        <form class="rounded px-3 bg-forms" action="includes/addPostScript.php" method="POST">

            <!-- create new row-->
            <div class="row">
              <!-- start first column-->
              <div class="col-md-6 col-xs-12">
                  <!--post title -->
                  <div class="form-group mt-3">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" id="title"  name="title" required>
                  </div>

                  <!-- start point -->
                  <div class="form-group mt-4">
                    <label for="start">Start Point</label>
                    <input type="text" class="form-control" id="start" name="start" required>
                  </div>
                  <!-- end point -->
                  <div class="form-group mt-3">
                    <label for="end">End Point</label>
                    <input type="text" class="form-control" id="end" name="end" required>
                  </div>

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

                </div><!-- end first col -->

                <!-- start second column-->
                <div class="col-md-6 col-xs-12">

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

                      <!-- pass empty values for start/end lat/long-->
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
