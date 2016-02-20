<?php

require('connectdb.php');
session_start();
$a = $_SESSION['userid'];
ini_set("precision", 3);

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM company WHERE 1";
$result = mysqli_query($connection, $query) or die("Mysql error". mysql_error());

$query1 = "SELECT * FROM user WHERE id ='".$a."' ";
$result1 = mysqli_query($connection, $query1) or die("Mysql error ". mysql_error());
$uesrdata = mysqli_fetch_array($result1);

while($row = mysqli_fetch_array($result)){
	$profit = bcmul(bcsub($row['currPrice'], $uesrdata['cost'.$row['id']], 3), $uesrdata['shares'.$row['id']], 3);
	echo "<tr id='".$row['id']."'>
		<td>".$row['name']."</td>
		<td>".$uesrdata['shares'.$row['id']]."</td>";
	if($profit < 0)
		echo "<td style='color: red;'> ▼".$profit."</td>";
	else
		echo "<td style='color: darkgreen;'> ▲".$profit."</td>";
	echo "<td>
			<button class='buy' type='button' data-toggle='modal' data-target='#confirmbox' data-whatever='".$row['name']."'>Buy</button>
			<button class='sell' type='button' data-toggle='modal' data-target='#confirmsell' data-whatever='".$row['name']."'>Sell</button>
		</td>
	</tr>";
}

mysqli_close($connection);
?>