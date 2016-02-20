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

$query = "SELECT * FROM user WHERE id='".$a."'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

echo"<div class='passbookhead'>
    <h4>CASH AVAILABLE</h4>
    <div>
      <span>₹</span>
      <span>".$row['balance']."</span>
    </div>
  </div>
  <div class='passbookbody'>
    <h4>LOAN AVAILABLE</h4>
    <div>
      <span>₹</span>
      <span>".$row['availLoan']."</span>
    </div>
  </div>
  <div class='passbookfoot'>
    <button class='loan loanapply' data-toggle='modal' data-target='#loaner' data-whatever='Apply'>Apply for Loan</button>
    <button class='loan loanrepay' data-toggle='modal' data-target='#loaner' data-whatever='Repay'>Repay Loan</button>
  </div>";

mysqli_close($connection);
?>