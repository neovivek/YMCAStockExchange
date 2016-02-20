<?php
require('connectdb.php');
date_default_timezone_set('Asia/Kolkata');

if(date('M-d') < 'Mar-21' or date('M-d') > 'Mar-27') die("You can play only between 20th march and 27th March.");
if(!( date('H') >= 10 and date('H') <23 )) die('YOu can play only between 10am and 11 pm');

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
$time = date('H:i');
$shareprice = array();
$zensex = 0;

$query1 = "SELECT * FROM company WHERE 1";
$result1 = mysqli_query($connection, $query1) or die('no selection '.mysql_error());

while($row = mysqli_fetch_array($result1)){
	$query = "INSERT INTO trading (`companyId`,`time`,`date`,`sharePrice`) VALUES ('".$row['id']."', '".$time."', '".date('Y-m-d')."', '".$row['currPrice']."' )";
	$result = mysqli_query($connection, $query) or die("error ".mysql_error());
	array_push($shareprice, $row['currPrice']);
}
rsort($shareprice);

for ($i=0; $i < 5; $i++) { 
	$zensex += $shareprice[$i];
}

$query2 = "INSERT INTO trading (`companyId`,`time`,`date`,`sharePrice`) VALUES ('16001', '".$time."', '".date('Y-m-d')."', '".$zensex."' )";
$result2 = mysqli_query($connection, $query2) or die("error ".mysql_error());

mysqli_close($connection);
?>