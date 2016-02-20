<?php
require('connectdb.php');

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

$query = "SELECT * FROM company WHERE id='".$a."' ";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

echo"<h2 style='text-transform: capitalize;color: #1EECEC; text-align: center'>".$row['name']."</h2>
	<p class='info'><span style='text-transform: capitalize;'>".$row['name']."</span> was established in ".$row['estb']."</p>
	<p class='info'>".$row['datah']."</p>
	<p class='info'>".$row['centers']."</p>
	<p class='info'>Company mainly deals in ".$row['deal']."</p>
	<p class='info'>Below you can find data about today's company trading.</p>
	<div id='ex4'></div>
";

mysqli_close($connection);
?>