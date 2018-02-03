<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];
$balance = $infoarray['balance'];
$check = mysqli_query($conn, "SELECT * FROM production.user_acc WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$ID = $dbarray["userID"];

if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];
};
if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
};

$sql = "INSERT INTO production.watch_lists(userID, stock_ticker, stock_name) VALUES ('$ID','$symbol','$compName');";

if (mysqli_query($conn, $sql)) {
    header('Location: ../profile.php');
}
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
};
?>