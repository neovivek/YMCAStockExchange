<?php
require('connectdb.php');

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM user WHERE 1";
$result = mysqli_query($connection, $query);
while($row = mysqli_fetch_array($result)){

  $c = $row['loan'];
  if($row['balance'] > 10000000.00) $return = bcmul(1.1, $c, 3);
  else $return = bcmul(1.02, $c, 3);
  $query3 = "UPDATE user SET availLoan=".bcadd($row['availLoan'], $c).", loan=".bcsub($row['loan'], $c).", balance=".bcsub($row['balance'], $return, 2)."  WHERE id='".$row['id']."'";
  $result3 = mysqli_query($connection, $query3);
  if(!$result3){
    die("Can't clear your loan right now ".$row['id']."<br>");
  }else{
    echo "Congratulation! your loan is now cleared. Extra fees deducted was ".bcsub($return, $c, 2)."<br>";
  }
}

mysqli_close($connection);
?>