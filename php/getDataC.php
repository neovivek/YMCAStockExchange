<?php

require('connectdb.php');
date_default_timezone_set('Asia/Kolkata');

if(!(isset($_REQUEST['company']))){
	die('Can\'t process !! :(');
}
$a = $_REQUEST['company'];

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM trading WHERE companyId='".$a."' ";
$result = mysqli_query($connection, $query) or die('Query error '. mysql_error());

$query1 = "SELECT name FROM company WHERE id='".$a."' ";
$result1 = mysqli_query($connection, $query1) or die('company query error '.mysql_error());
$temp = mysqli_fetch_array($result1);

$column = array(
		array('id'=> '', 'label' => 'Time', 'pattern'=> '', 'type'=> 'string'), 
		array('id'=> '','label' => $temp['name'], 'pattern'=> '', 'type'=> 'number'));

$rows = array();

while($row = mysqli_fetch_array($result)){
	$date = explode(" ", $row['time']);
	$rate = array(
		'c' => array(
			array('v' => $date[1]),
			array('v' => $row['sharePrice']))
		);
	array_push($rows, $rate);
}
$json = array('cols'=> $column, 'rows' => $rows);

$jsonstring = json_encode($json);
echo($jsonstring);

?>