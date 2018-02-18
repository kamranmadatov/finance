<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];

$check = mysqli_query($conn, "SELECT * FROM test.users WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$IDnum = $_SESSION['IDnum'];

if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];
};
if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
};

$sql = "INSERT INTO test.transaction (userID, Company, Ticker) VALUES ('$IDnum','$compName','$symbol');";

if (mysqli_query($conn, $sql)) {
    header('Location: ../profile.php');
}
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
};
?>