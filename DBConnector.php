<?php

$servername = "sql309.infinityfree.com";
$username = "if0_39057109";
$password = "mpXVRUW4bA1bUs";
$dbname = "if0_39057109_sample";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " .$conn-> connect_error);
}

// echo "Connected successfully <br/>";
?>