<?php
require('connectdb.php');
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
$result = mysqli_query($connection, $query);

while($row = mysqli_fetch_array($result)){
	echo"<tr>
		<td>".$row['name']."</td>
		<td>".$row['currPrice']."</td>";
	if(bcsub($row['currPrice'] , $row['lastPrice'],3) < 0.000)
		echo "<td style='color: red'> ▼".bcsub($row['currPrice'], $row['lastPrice'], 3)."</td>";
	else
		echo "<td style='color: darkgreen'> ▲".bcsub($row['currPrice'], $row['lastPrice'], 3)."</td>";
	echo"<td>".$row['dayHigh']."</td>
		<td>".$row['dayLow']."</td>
	</tr>
	";
}

mysqli_close($connection);
?>