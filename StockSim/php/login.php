<?php

include_once 'database_connect.php';
session_start();
if (isset($_POST['loginbtn'])){
	$userid = trim($_POST['lUsername']);
	$userid = strip_tags($userid);
	$userid = htmlspecialchars($userid);
    $userpass = trim($_POST['lPassword']);
	$userpass = strip_tags($userpass);
	$userpass = htmlspecialchars($userpass);
	
	$check = mysqli_query($conn, "SELECT * FROM test.users WHERE userName = '$userid'");
    
	$dbarray = mysqli_fetch_assoc($check);
    
	if ($dbarray["userPassword"] == $userpass){
        $_SESSION['username'] = $userid;
        $_SESSION['IDnum'] = $dbarray["id"];
        header('Location: ../profile.php');
    }else{
        header('Location: ../index.html');
        
    }
}
?>