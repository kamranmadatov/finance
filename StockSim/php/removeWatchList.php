<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];

$check = mysqli_query($conn, "SELECT * FROM test.users WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$IDnum = $_SESSION['IDnum'];

if (isset($_GET['orderNum'])) {
	$orderNum = $_GET['orderNum'];
};

$sql = "DELETE FROM test.transaction WHERE id = '$orderNum' AND userID = '$IDnum'";
if (mysqli_query($conn, $sql)) {
    header('Location: ../profile.php');
}else
    echo "Could not delete";

?>