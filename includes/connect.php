<?php

//connection script
//arguments for mysqli connect method submitted via POST from form

$serverName = "-----";
$username = "-----";
$password = "-----";
$db = "mdb_na2880g";


// Create connection
$conn = mysqli_connect($serverName, $username, $password, $db);

//check the connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}else{
    //echo "Connected successfully";
}

?>
