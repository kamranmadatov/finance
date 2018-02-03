<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];
$balance = $infoarray['balance'];
$check = mysqli_query($conn, "SELECT * FROM production.user_acc WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$ID = $dbarray["userID"];

if (isset($_GET['orderNum'])) {
	$orderNum = $_GET['orderNum'];
};

$sql = "DELETE FROM production.watch_lists WHERE num = '$orderNum' AND userID = '$ID'";
if (mysqli_query($conn, $sql)) {
    header('Location: ../profile.php');
}else
    echo "Could not delete";

?>