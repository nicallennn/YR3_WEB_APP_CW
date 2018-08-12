<?php
  session_start();


  /*******************************************************************
  CODE ADAPTED FROM W3SCHOOLS - PHP 5 SESSIONS
  Found at: https://www.w3schools.com/php/php_sessions.asp
  ********************************************************************/
  // remove all session variables
  session_unset();

  // destroy the session
  session_destroy();

  ?>

  <!--
  /*******************************************************************
  CODE ADAPTED FROM W3SCHOOLS - JAVASCRIPT WINDOW LOCATION
  Found at: https://www.w3schools.com/js/js_window_location.asp?output=printPagePage
  ********************************************************************/
  inform user they are logged out, redirct to login page-->
  <script type="text/javascript">
  alert("You have been logged out!");
  window.location.href = '../index.php';
  </script>

  <noscript>
    <!-- do not display search.php -->
    <style>html{display:none;}</style>
    <!-- refresh the browser, redirected to simpleSearch.php -->
    <meta http-equiv="refresh" content="0; url=http://stuweb.cms.gre.ac.uk/~na2880g/web/cw/index.php" />
  </noscript>
