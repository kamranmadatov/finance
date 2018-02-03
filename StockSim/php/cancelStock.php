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
if (isset($_GET['buyorsell'])) {
	$buyorsell = $_GET['buyorsell'];
};

if($buyorsell == 0){
    $sql = "DELETE FROM production.buy_orders WHERE trans_num = '$orderNum' AND userID = '$ID'";
}else{
    $sql = "DELETE FROM production.sell_orders WHERE trans_num = '$orderNum' AND userID = '$ID'";
}
if (mysqli_query($conn, $sql)) {
    header('Location: ../profile.php');
}else
    echo "Could not delete";

?>