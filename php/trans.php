<?php
require('connectdb.php');

session_start();
$a = $_SESSION['userid'];
$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM history WHERE userId='".$a."' ORDER BY sequence DESC ";
$result = mysqli_query($connection, $query);

while($row = mysqli_fetch_array($result)){
	echo"
	<tr>
		<td>".$row['time']."</td>
		<td>".$row['action']."</td>
		<td>".$row['company']."</td>
		<td>".$row['amount']."</td>
		<td>".$row['cost']."</td>
	</tr>
	";
}

mysqli_close($connection);
?>