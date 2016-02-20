<?php

require('connectdb.php');

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM company WHERE 1 ";
$result = mysqli_query($connection, $query) or die("Mysql error temp". mysql_error());
while($row = mysqli_fetch_array($result)){
	$query1 = "UPDATE company SET lastPrice='".$row['currPrice']."', dayLow='".$row['currPrice']."', dayHigh='".$row['currPrice']."' WHERE id ='".$row['id']."' ";
	$result1 = mysqli_query($connection, $query1) or die('Can\'t update');
}

mysqli_close($connection);
?>