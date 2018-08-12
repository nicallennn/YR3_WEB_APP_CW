<?php
  session_start();
  //check user is logged in
  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
    //echo "logged in";
  } else {
    //if user is not logged in, redirect to login page
    header('Location: index.php');
    die();
  }

  //check if the post_id is set in the session
  if(!isset($_SESSION['post_id'])){
  //get post_id from get and store in session variable
  $_SESSION['post_id'] = $_GET['post_id'];
  }
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
  }

	//define TITLE constant
	define("TITLE", "GRF - Add Image");
	#nclude header
	include('includes/header.php');

?>

	<!--

        ==================
        ADDIMAGE.PHP START
        ==================

     -->

    <!-- container  -->
	<div class="container pt-3">

    <!-- inform user of image upload success or failure-->
    <?php
      if(isset($_GET['uploaded']) && $_GET['uploaded'] == "true"){
        $post_id = $_SESSION['post_id'];
        echo '<div class="bg-forms m-0 p-3 mt-3 d-block-block rounded">';
        echo '<p class="m-0 p-0">Image uploaded successfully!</p>
              <p class="text-muted mb-0 pb-0 mt-3">Add another image or
              <a href="viewPost.php?post_id=' . $post_id . '">view your post</a>.</p>';
        echo '</div>';
        unset($_GET['uploaded']);
        //reset get variable
        //$_GET['uploaded'] = "";
      } elseif(isset($_GET['uploaded']) && $_GET['uploaded'] == "false") {
        echo '<div class="bg-forms m-0 p-3 mt-3 d-block-block rounded">';
        echo '<p class="m-0 p-0 text-danger">Image not uploaded!</p>';
        echo '</div>';
        unset($_GET['uploaded']);
        //reset get varaible
        //$_GET['uploaded'] = "";
      }

    ?>


    <!-- display welcome message-->
    <div class="bg-forms p-3 mt-3 d-inline-block rounded">
      <h1>Add Images</h1>
  		<p class="text-muted">Add images to your post.</p>

      <!-- error messages -->
			<?php
			//check for error message in get array - SET ERROR IF FOUND
				if(isset($_GET['error']) && $_GET['error'] == "imageNotCompatible"){
					//if filetype incorrect
					echo '<p class="small text-danger">Incorrect file type! Please try again.</p>';
					//unset the get variable
					unset($_GET['error']);
				//alt text/ description error
				}elseif(isset($_GET['error']) && $_GET['error'] == "altText"){
						echo '<p class="small text-danger">Invalid description! Must be at least 5 characters.</p>';
						//unset the get variable
						unset($_GET['error']);
          }//image too large error
            elseif(isset($_GET['error']) && $_GET['error'] == "imageTooLarge"){
    						echo '<p class="small text-danger">Your image exceeds the upload size! Please upload a smaller image.</p>';
    						//unset the get variable
    						unset($_GET['error']);
              }//no db connect error
                elseif(isset($_GET['error']) && $_GET['error'] == "noDbConnection"){
        						echo '<p class="small text-danger">No database connection!</p>';
        						//unset the get variable
        						unset($_GET['error']);
        						}
                    elseif(isset($_GET['error']) && $_GET['error'] == "canNotOpenTempFile"){
            						echo '<p class="small text-danger">Can not open temporary file!</p>';
            						//unset the get variable
            						unset($_GET['error']);
            						}
                        elseif(isset($_GET['error']) && $_GET['error'] == "canNotReadTempFile"){
                						echo '<p class="small text-danger">Can not read temporary file!</p>';
                						//unset the get variable
                						unset($_GET['error']);
                						}


			?>
    </div>

    <!-- ****************** ADD IMAGE FORM ****************************** -->
    <!--
        /*******************************************************************
        CODE ADAPTED FROM WEB APPLICATIONS COURSE NOTES - UPLOADING FILES TO MYSQL
        Found at: http://stuweb.cms.gre.ac.uk/~ha07/web/PHP/imageUpload.html
        ********************************************************************/
  -->
    		<!-- new row -->
    		<div class="row">
    			<div class="col-md-8">
    					<form class="form-group rounded px-3 mt-3 d-block mx-auto  bg-forms"
               action="includes/addImageScript.php" method="POST" enctype="multipart/form-data">
               <!-- hidden input to hold post_id-->
               <input type="hidden" name="post_id" value="<?php echo $_SESSION['post_id']; ?>">
                <!-- get image title -->
                <div class="form-group mt-3">
                    <label for="imageTitle">Image Title</label>
                    <input class="form-control" name="imageTitle" id="imageTitle" type="text" required>
                </div>
                <!-- get image description -->
                <div class="form-group mt-3">
                    <label for="altText">Description</label>
                    <textarea id="altText" class="form-control" name="altText" rows="3" required></textarea>
                </div>
                <!-- get file-->
                <div class="form-group mt-3">
                    <label for="userFile">Upload Image </label>
                    <input class="d-block" type="file" size="40" name="userFile" id="userFile" required>
                </div>

                <input class="btn btn-custom mb-2" type="submit" value="Upload">
    						<!-- reset button-->
    						<input class="btn btn-delete mb-2 mx-1" type="reset">

              </form>
            </div><!-- end column -->
        </div> <!-- end row -->

  </div> <!-- close container -->

  <?php
  	#include footer
  	include('includes/footer.php');

  ?>
