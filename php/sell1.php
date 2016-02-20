<?php

require('connectdb.php');
date_default_timezone_set('Asia/Kolkata');

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query1 = "SELECT * FROM user WHERE 1 ";
$result1 = mysqli_query($connection, $query1) or die("Mysql error ". mysql_error());

while($userdata = mysqli_fetch_array($result1)){

	for ($i=15001; $i < 15011; $i++) { 
		$query = "SELECT * FROM company WHERE id='".$i."' ";
		$result = mysqli_query($connection, $query) or die("Mysql error temp". mysql_error());
		$row = mysqli_fetch_array($result);
		if($userdata['shares'.$i] > 0){
			$payment1 = bcmul($row['currPrice'], $userdata['shares'.$i], 3);
			$query2 = "UPDATE user SET balance=".bcadd($userdata['balance'], $payment1, 2).", shares".$i."='0', cost".$i."='0'  WHERE id='".$userdata['id']."' ";
			$result2 = mysqli_query($connection, $query2) or die('Mysql error1'. mysql_error());
		}
	}
}

mysqli_close($connection);
?>