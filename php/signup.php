<?php
require('connectdb.php');
date_default_timezone_set('Asia/Kolkata');

$a = $_REQUEST['fname'];
$b = $_REQUEST['lname'];
$c = $_REQUEST['email'];
$d = $_REQUEST['gender'];

if(!(isset($a)) or !(isset($b)) or !(isset($c)) or !(isset($d))) die('Can\'t Process Request.');
settype($a, "string");
settype($b, "string");
settype($c, "string");
settype($d, "string");
session_start();

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT id from user WHERE email = '".$c."' AND firstname = '".$a."' AND lastname ='".$b."' ";
$result =mysqli_query($connection, $query) or die('Error '.mysql_error());
if(mysqli_num_rows($result) > 0){
}
else{
	$result = mysqli_query($connection, 'INSERT INTO `user`( `firstname`, `lastname`, `email`, `gender`, `balance`, `availLoan`) VALUES ("'.$a.'", "'.$b.'", "'.$c.'", "'.$d.'", "50000", "50000" )');
	if(!$result){
		echo ('Can\'t Process Your Signup .Please try again after some time .');
		die(mysql_error());
	}
}
$result = mysqli_query($connection, "SELECT id from user WHERE email = '".$c."' AND firstname = '".$a."' AND lastname ='".$b."' ");
$row = mysqli_fetch_array($result);
echo ("Welcome ".$a."!");
$_SESSION['username'] = $a;
$_SESSION['userid'] = $row['id'];
mysqli_close($connection);
?>