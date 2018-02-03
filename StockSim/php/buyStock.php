<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];
$balance = $infoarray['balance'];
$check = mysqli_query($conn, "SELECT * FROM production.user_acc WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$ID = $dbarray["userID"];

if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
};
if (isset($_GET['numShares'])) {
	$numShares = $_GET['numShares'];
};
if (isset($_GET['sharePrice'])) {
	$sharePrice = $_GET['sharePrice'];
};
if (isset($_GET['totalPrice'])) {
	$totalPrice = $_GET['totalPrice'];
};
if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];
};
if (isset($_GET['longOrshort'])) {
	$longOrshort = $_GET['longOrshort'];
};
if (isset($_GET['stop'])) {
	$stop = $_GET['stop'];
};
if (isset($_GET['start'])) {
	$start = $_GET['start'];
};
if (isset($_GET['ask'])) {
	$ask = $_GET['ask'];
};
if (isset($_GET['bid'])) {
	$bid = $_GET['bid'];
};
if ($longOrshort == 2){
    $orderType = 'S';
}
else {
	$orderType = 'L';
}

$totalPrice = (int) $totalPrice;
$balance = (int) $balance;
if($start == 0 && $stop == 0 && $totalPrice <= $balance){ 
    $message = "Orders Executed, Bought Shares:".$numShares.", Current Price: ".$ask;
    $sql = "INSERT INTO production.user_trans(userID, stock_name, stock_ticker, stock_bp, stock_type, stock_change, stock_shares) VALUES ('$ID', '$compName','$symbol','$ask','$orderType', '0' ,'$numShares');";
	$balance = $balance - $totalPrice;
    $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
}elseif ($start != 0 && $orderType == 'L'){
    if($ask > $start){ //buyer wants a lower price than ask
        $sql = "INSERT INTO production.buy_orders (userID,stock_name,stock_ticker,stock_shares,stock_low,stock_high,stock_bp, orderType) VALUES ('$ID','$compName','$symbol','$numShares','$stop', '$start', '$sharePrice', '$orderType');";
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
        $message = "Orders not Executed, waiting on Desired Long Price At: ".$start.", Current Price: ".$ask;
    }else{
        $sql = "INSERT INTO production.user_trans(userID, stock_name, stock_ticker, stock_bp, stock_type, stock_change, stock_shares) VALUES ('$ID', '$compName','$symbol','$ask','$orderType', '0' ,'$numShares');";
        $balance = $balance - $totalPrice;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
        $message = "Orders Executed, Bought Shares:".$numShares.", Current Price: ".$ask;
    }
}elseif ($stop != 0 && $orderType == 'S'){
    if($stop > $ask){ //short buying, wait til stocks reach price higher
        $sql = "INSERT INTO production.buy_orders (userID,stock_name,stock_ticker,stock_shares,stock_low,stock_high,stock_bp, orderType) VALUES ('$ID','$compName','$symbol','$numShares','$stop', '$start', '$sharePrice', '$orderType');";
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
        $message = "Orders not Executed, waiting on Desired Shorting Price At: ".$start.", Current Price: ".$ask;
    }else{
        $sql = "INSERT INTO production.user_trans(userID, stock_name, stock_ticker, stock_bp, stock_type, stock_change, stock_shares) VALUES ('$ID', '$compName','$symbol','$ask','$orderType', '0' ,'$numShares');";
        $balance = $balance - $totalPrice;
        $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
        $message = "Orders Executed, Bought Shares:".$numShares.", Current Price: ".$ask;
    }
}elseif ($totalPrice > $balance){
    $message = 'Too many shares, past balance';
    $sql = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
    $sql2 = "UPDATE production.user_acc SET balance = '$balance' WHERE userID = '$ID';";
}

if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
    echo "<SCRIPT type='text/javascript'> //not showing me this
            alert('$message');
            window.location.replace(\"http://localhost:8080/StockSim/search.php\");
        </SCRIPT>";
}
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
};

?>