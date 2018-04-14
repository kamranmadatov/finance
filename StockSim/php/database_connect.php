<?php


$servername = "finacedb.cc4bh686d7ef.us-east-2.rds.amazonaws.com";
$username = "fin";
$password = "financeteam";
/*
$servername = "127.0.0.1";
$username = "mysql";
$password = "";
*/

$dbname = "test";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
