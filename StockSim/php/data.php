<?php
include_once 'database_connect.php';

$date = date_create();
$old = date_format(date_sub($date, date_interval_create_from_date_string('30 days')), 'Y-m-d');
$date = date_format(date_create(), 'Y-m-d');

$query = "SELECT articleURL,date, sentScore as avgScore FROM articles WHERE date <= '".$date."' AND date >= '".$old."' ORDER BY date";

if (isset($_GET['compName'])) {
	$compName = $_GET['compName'];
    $query = "SELECT articleURL,date,sentScore as avgScore FROM articles WHERE date <= '".$date."' AND date >= '".$old."' AND company='".$compName."' ORDER BY date";
};

$result = mysqli_query($conn, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}
echo json_encode($data);
?>