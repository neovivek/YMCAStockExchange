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
$i = 1;

$query = "SELECT * FROM user WHERE 1 ORDER BY balance DESC ";
$result = mysqli_query($connection, $query);

while($row = mysqli_fetch_array($result)){
	echo"
	<tr>
		<td>".$i."</td>
		<td>".$row['firstname']." ".$row['lastname']."</td>
		<td>".$row['balance']."</td>
		<td>".$row['loan']."</td>	
	</tr>
	";
	$i ++;
}

mysqli_close($connection);
?>