<?php
session_start();
include_once 'database_connect.php';
$userid = $_SESSION['username'];
$infoarray = $_SESSION['infoarray'];

$check = mysqli_query($conn, "SELECT * FROM test.users WHERE userName = '$userid'");
$dbarray = mysqli_fetch_assoc($check);
$IDnum = $_SESSION['IDnum'];

if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];
};
if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
};

$sql = "INSERT INTO test.transaction (userID, Company, Ticker) VALUES ('$IDnum','$compName','$symbol');";

$date = date_format(date_sub($date, date_interval_create_from_date_string('20 days')), 'Y-m-d');

if (mysqli_query($conn, $sql)) {
    $row = mysqli_query($conn, "SELECT * FROM test.uniqueStocks WHERE Ticker = '$symbol'");
    $rowcount = mysqli_num_rows($row);
    if ($rowcount == 0){
        $newUnique = "INSERT INTO test.uniqueStocks (Company, Ticker, Date) VALUES ('$compName', '$symbol', '$date');";
        if (mysqli_query($conn, $newUnique)) {
            header('Location: ../profile.php');
        }
        
    }
    header('Location: ../profile.php');
}
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
};
?>