<?php
include_once 'database_connect.php';

/* Get name and balance */
$infoGet = $check = mysqli_query($conn, "SELECT * FROM test.users WHERE userName = '$userID'");
$infoRes = mysqli_fetch_assoc($infoGet);
$_SESSION['infoarray'] = $infoRes;

/* Get stock array lists */
$_SESSION['transaction'] = mysqli_query($conn, "SELECT * FROM test.transaction WHERE userID = $IDnum");
