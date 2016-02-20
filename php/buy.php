<?php

require('connectdb.php');
session_start();
date_default_timezone_set('Asia/Kolkata');

if(date('M-d') < 'Mar-20' or date('M-d') > 'Mar-27') die("You can play only between 21th march and 27th March.");
if(!( date('H') >= 10 and date('H') <23 )) die('YOu can play only between 10am and 11 pm');

$a = $_SESSION['userid'];
$b = $_REQUEST['name'];
$c = abs(floor($_REQUEST['requirement']));
if($c == 0) die('Fill Amount > 0');

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM company WHERE name='".$b."' ";
$result = mysqli_query($connection, $query) or die("Mysql error temp". mysql_error());
$row = mysqli_fetch_array($result);

$query1 = "SELECT * FROM user WHERE id ='".$a."' ";
$result1 = mysqli_query($connection, $query1);
if(!$result1){
	die("Mysql error ". mysql_error());
}
$userdata = mysqli_fetch_array($result1);

if(isset($_SESSION['cp'.$a.$row['id']])){
	if(($_SESSION['cp'.$a.$row['id']] * $c) > $userdata['balance']){
		echo "Don't have enough balance :( ".bcmul($_SESSION['cp'.$a.$row['id']], $c)." rupees needed";
		die();
	}
}else{
	echo "Can\'t Process Request";
	die();
}
if($c > $row['shareLeft']) die('Can\'t Process Request');
if($c > 5000) die('Can\'t Process Request');
if(bcadd($userdata['shares'.$row['id']], $c, 2) > 5000) die('Can\'t Process Request. U can have max 5000 shares of a company');

$oldprice = $userdata['cost'.$row['id']];
$oldshares = $userdata['shares'.$row['id']];
$payment = bcmul($_SESSION['cp'.$a.$row['id']], $c, 3);
$payment1 = $payment;
$newprice = bcdiv(bcadd($payment, bcmul($oldshares, $oldprice, 3), 3), bcadd($c, $oldshares), 3);
if($userdata['balance'] > 100000000) {
	$payment1 = bcmul(1.18, $payment, 3);
}
else if($userdata['balance'] > 8000000) {
	if($c > 4000) $payment1 = bcmul(1.08, $payment, 3);
	else if($c > 3000) $payment1 = bcmul(1.06, $payment, 3);
	else if( $c > 1000 ) $payment1 = bcmul(1.02, $payment, 3);
}

$query2 = "UPDATE user SET balance=". bcsub($userdata['balance'], $payment1, 2).", shares".$row['id']."=".$c ."+". $oldshares.", cost".$row['id']."=".$newprice." WHERE id='".$a."' ";
$result2 = mysqli_query($connection, $query2) or die('Mysql error1'. mysql_error());

$companyshare = bcsub($row['shareLeft'], $c);
$newstockprice = bcdiv(bcmul(0.91, bcadd($row['companyValue'], $payment, 3), 3), $companyshare, 3);

$query3 = "UPDATE company SET shareSold=".$row['shareSold'] ."+". $c.", shareLeft=".$companyshare.", companyValue=".$row['companyValue'] ."+". $payment.", lastPrice=".$row['currPrice'].", currPrice=".$newstockprice." WHERE id='".$row['id']."' ";
$result3 = mysqli_query($connection, $query3) or die('Mysql error2'. mysql_error());

if($row['dayHigh'] < $newstockprice){
	$query4 = "UPDATE company SET dayHigh=".$newstockprice." WHERE id='".$row['id']."' ";
	$result4 = mysqli_query($connection, $query4) or die('mysql error '. mysql_error());
}

$query5 = "INSERT INTO `history` (`userId`, `action`, `amount`, `time`, `cost`, `company`, `price`) VALUES ('".$a."', 'BUY', '".$c."', '".date('Y-m-d H:i:s')."' , '".$payment1."', '".$b."', '".$_SESSION['cp'.$a.$row['id']]."') ";
$result5 = mysqli_query($connection, $query5);
if(!$result5){
	die("Mysql error3 ".mysql_error());
}else{
	echo $c." shares bought from ".$b." for ".$payment1;
	unset($_SESSION['cp'.$a.$row['id']]);
}

mysqli_close($connection);
?>