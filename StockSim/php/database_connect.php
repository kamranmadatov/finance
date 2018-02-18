<?php


$servername = "financegroup.cs8piwvafix8.us-east-1.rds.amazonaws.com";
$username = "slustudents";
$password = "financeteam";
/*
$servername = "127.0.0.1";
$username = "root";
$password = "";
*/

$dbname = "users";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
