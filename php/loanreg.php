<?php
require('connectdb.php');

session_start();
date_default_timezone_set('Asia/Kolkata');

if(date('M-d') < 'Mar-20' or date('M-d') > 'Mar-27') die("You can play only between 21th march and 27th March.");
if(!( date('H') >= 10 and date('H') <23 )) die('YOu can play only between 10am and 11 pm');

$a = $_SESSION['userid'];
$b = $_REQUEST['tag'];
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

$query = "SELECT * FROM user WHERE id='".$a."'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($b == 1 ){
  if($row['availLoan'] < $c) die("You'r not allowed to have that much loan");
  if($row['loan'] > 0){
    $query1 = "UPDATE user SET availLoan=".bcsub($row['availLoan'], $c).", loan=".bcadd($row['loan'], $c).", balance=".bcadd($row['balance'], $c)."  WHERE id='".$a."'";
    $result1 = mysqli_query($connection, $query1);
    if(!$result1){
      die("Can't process your loan right now, bt u still have earlier loan.");
    }else{
      echo "Congratulation! your loan is processed";
    }
  }else{
    $query2 = "UPDATE user SET availLoan='".bcsub($row['availLoan'], $c)."', loan='".bcadd($row['loan'], $c)."', loantime='".date('Y-m-d H:i:s')."', balance='".bcadd($row['balance'], $c)."'  WHERE id='".$a."' ";
    $result2 = mysqli_query($connection, $query2);
    if(!$result2){
      die("Can't process your loan right now");
    }else{
      echo "Congratulation! your loan of INR ".$c." is processed";
    }
  }

}else if($b == 2 ){
  if($row['balance'] < bcmul(1.2, $c, 2)) die('You don\'t have enough balance to repay ');
  if($c > $row['loan']) die('You are paying more than you have loaned ');
  
  if($row['balance'] > 10000000.00) $return = bcmul(1.1, $c, 3);
  else $return = bcmul(1.02, $c, 3);
  $query3 = "UPDATE user SET availLoan=".bcadd($row['availLoan'], $c).", loan=".bcsub($row['loan'], $c).", balance=".bcsub($row['balance'], $return, 2)."  WHERE id='".$a."'";
  $result3 = mysqli_query($connection, $query3);
    if(!$result3){
      die("Can't clear your loan right now");
    }else{
      echo "Congratulation! your loan is now cleared. Extra fees deducted was ".bcsub($return, $c, 2);
    }
}

mysqli_close($connection);
?>