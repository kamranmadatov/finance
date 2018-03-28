<?php
include_once 'database_connect.php';
if (isset($_GET['symbol'])) {
	$symbol = $_GET['symbol'];
};
if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
};


$date = date_create();
$old = date_format(date_sub($date, date_interval_create_from_date_string('30 days')), 'Y-m-d');
$date = date_format(date_create(), 'Y-m-d');
#$query = "SELECT articleURL,date, sentScore FROM articles WHERE date <= '$date' AND date >= '$old'";
$query = "SELECT articleURL,date,sentScore as avgScore FROM articles WHERE date <= '".$date."' AND date >= '".$old."' AND company='tesla' ORDER BY date ";
$result = mysqli_query($conn, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}
echo json_encode($data);


?>