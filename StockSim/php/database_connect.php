<?php

/*
$servername = "slustockmarket.chy61trcz99n.us-west-2.rds.amazonaws.com";
$username = "SLU_USER";
$password = "slupassword";
*/
$servername = "127.0.0.1";
$username = "root";
$password = "";

$dbname = "production";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
