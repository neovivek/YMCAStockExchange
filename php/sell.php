<?php

require('connectdb.php');
session_start();
date_default_timezone_set('Asia/Kolkata');

if(date('M-d') < 'Mar-20' or date('M-d') > 'Mar-27') die("You can play only between 20th march and 27th March.");
if(!( date('H') >= 10 and date('H') <23 )) die('YOu can play only between 10am and 11 pm');

$a = $_SESSION['userid'];
$b = $_REQUEST['name'];
$c = abs(floor($_REQUEST['requirement']));
if ($c == 0) die('Fill Amount > 0');

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

if(isset($_SESSION['sp'.$a.$row['id']])){
	if($c > $userdata['shares'.$row['id']]){
		echo "Don't have enough shares :(";
		die();
	}
}else{
	echo "Can\'t Process Request";
	die();
}

$oldprice = $userdata['cost'.$row['id']];
$oldshares = $userdata['shares'.$row['id']];
$payment = bcmul( $_SESSION['sp'.$a.$row['id']], $c, 3);
$payment1 = $payment;
if($userdata['balance'] > 100000000) $payment1 = bcmul(0.85, $payment, 3);
else if($payment > 6000000.00) $payment1 = bcmul(0.9, $payment, 3);
else if($payment > 800000.00) $payment1 = bcmul(0.97, $payment, 3);
else if($payment > 300000.00) $payment1 = bcmul(0.99 ,$payment, 3);

$query2 = "UPDATE user SET balance=".bcadd($userdata['balance'], $payment1, 2).", shares".$row['id']."=".$oldshares ."-". $c." WHERE id='".$a."' ";
$result2 = mysqli_query($connection, $query2) or die('Mysql error1'. mysql_error());

if(($oldshares - $c) == 0){
	$que = "UPDATE user SET cost".$row['id']."='0' WHERE id='".$a."' ";
	$res = mysqli_query($connection, $que) or die('can\'t update');
}

$companyshare = bcadd($row['shareLeft'], $c, 3);
$newstockprice = bcdiv(bcmul(0.91, bcsub($row['companyValue'], bcmul(0.7, $payment, 2), 3), 3), $companyshare, 3);

$query3 = "UPDATE company SET shareSold=".$row['shareSold'] ."-". $c.", shareLeft=".$companyshare.", companyValue=".$row['companyValue'] ."-". bcmul(0.7, $payment, 2).", lastPrice=".$row['currPrice'].", currPrice=".$newstockprice." WHERE id='".$row['id']."' ";
$result3 = mysqli_query($connection, $query3) or die('Mysql error2'. mysql_error());

if($row['dayLow'] > $newstockprice){
	$query4 = "UPDATE company SET dayLow=".$newstockprice." WHERE id='".$row['id']."' ";
	$result4 = mysqli_query($connection, $query4) or die('mysql error '. mysql_error());
}

$query5 = "INSERT INTO `history` (`userId`, `action`, `amount`, `time`, `cost`, `company`, `price`) VALUES ('".$a."', 'SELL', '".$c."', '".date('Y-m-d H:i:s')."' , '".$payment1."', '".$b."', '".$_SESSION['sp'.$a.$row['id']]."') ";
$result5 = mysqli_query($connection, $query5);
if(!$result5){
	die("Mysql error3 ".mysql_error());
}else{
	echo $c." shares sold from ".$b." for ".$payment1;
	unset($_SESSION['sp'.$a.$row['id']]);
}

mysqli_close($connection);
?>