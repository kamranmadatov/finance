<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];
$balance = $infoarray['balance'];
$check = mysqli_query($conn, "SELECT * FROM production.user_acc WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$ID = $dbarray["userID"];

if (isset($_GET['price'])) {
	$price = $_GET['price'];
};
if (isset($_GET['shares'])) {
	$shares = $_GET['shares'];
};
if (isset($_GET['ask'])) {
	$ask = $_GET['ask'];
};
if (isset($_GET['bid'])) {
	$bid = $_GET['bid'];
};
if (isset($_GET['start'])) {
	$start = $_GET['start'];
};
if (isset($_GET['stop'])) {
	$stop = $_GET['stop'];
};
if (isset($_GET['ticker'])) {
	$ticker = $_GET['ticker'];
};
if (isset($_GET['maxshares'])) {
	$maxshares = $_GET['maxshares'];
};
if (isset($_GET['transnum'])) {
	$transnum = $_GET['transnum'];
};
if (isset($_GET['stocktype'])){
    $stocktype = $_GET['stocktype'];
}
if (isset($_GET['bp'])){
    $bp = $_GET['bp'];
}
if(isset($_GET['compName'])){
    $compName = $_GET['compName'];
}
if(isset($_GET['ah'])){
    $ah = $_GET['ah'];
}


$left = $maxshares - $shares;
if ($shares == $maxshares){
    $sql = "DELETE FROM production.user_trans where userID = '$ID' AND trans_num = '$transnum'";
}else{
    $sql = "UPDATE production.user_trans SET stock_shares = '$left' where userID = '$ID' AND trans_num = '$transnum'";
}
    

if($start == 0 && $stop == 0 && $shares <= $maxshares && $shares > 0 && $ah != "1"){
    if ($stocktype == 'L'){
        $dividend = $bid*$shares;
        $balance = $balance + $dividend;
        $message = "Sold Successfully At Long Price: ".$bid.", and Dividend Of: ".$dividend;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";   
    }else{
        $dividend = ($bp-$bid)*$shares;
        $balance = $balance + $bid*$shares + $dividend;
        $message = "Sold Successfully At Short Price: ".$bid.", and Dividend Of: ".$dividend;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
    }
}elseif($start != 0 && $stocktype == 'L' && $shares <= $maxshares && $shares > 0 || $ah == "1"){ //figuring out sell order for min price
    //if we want to set limit on min price we want to sell for long
    if($start > $bid || $ah == "1"){
        $sql = "INSERT INTO production.sell_orders (userID,stock_name,stock_ticker,stock_shares,stock_low,stock_high,stock_bp, orderType) VALUES ('$ID','$compName','$ticker','$maxshares','$start', '$stop', '$bp', '$stocktype');";
        $sql2 = "";
        $message = "Orders not Executed, waiting on Desired Long Selling Price At: ".$start.", Current Price: ".$bid;
    }else{
        $dividend = $bid*$shares;
        $balance = $balance + $dividend;
        $message = "Sold Successfully At Long Price: ".$bid.", and Dividend Of: ".$dividend;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
    }
}elseif($stop != 0 && $stocktype == 'S' && $shares <= $maxshares && $shares > 0 || $ah == "1"){ //figuring sell order for short price
    //setting the max price we are willing to short sell
    if($stop < $bid || $ah == "1"){ 
        $sql = "INSERT INTO production.sell_orders (userID,stock_name,stock_ticker,stock_shares,stock_low,stock_high,stock_bp, orderType) VALUES ('$ID','$compName','$ticker','$maxshares','$start', '$stop', '$bp', '$stocktype');";
        $sql2 = "";
        $message = "Orders not Executed, waiting on Desired Short Selling Price At: ".$stop.", Current Price: ".$bid;
    }else{
        $dividend = ($bp-$bid)*$shares;
        $balance = $balance + $bid*$shares + $dividend;
        $message = "Sold Successfully At Short Price: ".$bid.", and Dividend Of: ".$dividend;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
    }
}else{
    echo "<SCRIPT type='text/javascript'> //not showing me this
                alert('Insert valid values in each boxes');
            </SCRIPT>";
}

if (mysqli_query($conn, $sql)) {
    if ($sql2 == ""){
        echo "<SCRIPT type='text/javascript'> //not showing me this
                alert('$message');
                window.location.replace(\"http://localhost:8080/StockSim/profile.php\");
            </SCRIPT>";
    }else{
        mysqli_query($conn, $sql2);
        echo "<SCRIPT type='text/javascript'> //not showing me this
                alert('$message');
                window.location.replace(\"http://localhost:8080/StockSim/profile.php\");
            </SCRIPT>";
    }
}
else {
    $message = "Attempt as unsucessful. Please try again!";
    echo "<SCRIPT type='text/javascript'> //not showing me this
            alert('$message');
            window.location.replace(\"http://localhost:8080/StockSim/profile.php\");
        </SCRIPT>";;
};

?>