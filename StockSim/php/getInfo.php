<?php
include_once 'database_connect.php';

/* Get name and balance */
$infoGet = $check = mysqli_query($conn, "SELECT * FROM production.user_acc WHERE userName = '$userID'");
$infoRes = mysqli_fetch_assoc($infoGet);
$_SESSION['infoarray'] = $infoRes;

/* Get stock array lists */
$_SESSION['trans'] = mysqli_query($conn, "SELECT * FROM production.user_trans WHERE userID = $IDnum");


/* Get orders */
$_SESSION['buyOrders'] = mysqli_query($conn, "SELECT * FROM production.buy_orders WHERE userID = $IDnum");

/* Get watch list */
$_SESSION['watchLists'] = mysqli_query($conn, "SELECT * FROM production.watch_lists WHERE userID = $IDnum");

/* Get sell orders */
$_SESSION['sellOrders'] = mysqli_query($conn, "SELECT * FROM production.sell_orders WHERE userID = $IDnum");
?>