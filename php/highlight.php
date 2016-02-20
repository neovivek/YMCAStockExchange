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

echo"<marquee behavior='scroll' direction='left' scrollamount='4'>";
while( $row = mysqli_fetch_array($result) ){
	echo" ".$row['name'].":&nbsp;".$row['stockname']."&nbsp;".$row['currPrice']." ";
	if(bcsub($row['currPrice'] , $row['lastPrice'],3) < 0.000)
		echo "<span style='color: red'> ▼ ".bcsub($row['currPrice'], $row['lastPrice'],2)."</span>";
	else
		echo "<span style='color: darkgreen'> ▲ ".bcsub($row['currPrice'], $row['lastPrice'],2)."</span>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
}
echo"</marquee>";

mysqli_close($connection);
?>