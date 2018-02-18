<?php
	
include_once 'database_connect.php';
if (isset($_POST['subtn'])){
	/*
	$userfname = trim($_POST['sFn']);
	$userfname = strip_tags($userfname);
	$userfname = htmlspecialchars($userfname);
    $userlname = trim($_POST['sLn']);
	$userlname = strip_tags($userlname);
	$userlname = htmlspecialchars($userlname);
    */
    $userid = trim($_POST['sUsername']);
	$userid = strip_tags($userid);
	$userid = htmlspecialchars($userid);
    $userpass = trim($_POST['sPassword']);
	$userpass = strip_tags($userpass);
	$userpass = htmlspecialchars($userpass);
    $usercpass = trim($_POST['scPassword']);
	$usercpass = strip_tags($usercpass);
	$usercpass = htmlspecialchars($usercpass);
	
	//add validation
	
	$check = mysqli_query($conn, "SELECT 1 FROM test.users WHERE userName = '$userid'");
    
    if (mysqli_fetch_assoc($check) == 0) {
        $cre = "INSERT INTO `users` (userName, userPassword) VALUES ('$userid','$userpass');";
            if (mysqli_query($conn, $cre)) {
				$message = 'Account created successfully! Please log in with new username and password under "Existing Member?"';
                echo "<SCRIPT type='text/javascript'> //not showing me this
                    alert('$message');
                    window.location.replace(\"http://localhost/StockSim/index.html\");
                </SCRIPT>";
                //header('Location: ../index.html');
            } else {
                $message = 'An error has occur. Please try again.';
                echo "<SCRIPT type='text/javascript'> //not showing me this
                    alert('$message');
                    window.location.replace(\"http://localhost/StockSim/index.html\");
                </SCRIPT>";
            }
    } else {
        //echo "Account was not created, not available name";
        $message = 'Account has failed to create. Retry with a different username.';
        echo "<SCRIPT type='text/javascript'> //not showing me this
            alert('$message');
            window.location.replace(\"http://localhost/StockSim/index.html\");
        </SCRIPT>";
        //header('Location: ../index.html');
    }
	
}
mysqli_close($conn);
?>