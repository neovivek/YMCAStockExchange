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

echo"<form>
      <div class='form-group'>
        <label class='control-label'>Available Loan Amount:</label>
        <input type='text' class='form-control' disabled value='".$row['availLoan']."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>Loan Taken:</label>
        <input type='text' class='form-control' disabled value='".$row['loan']."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>Amount to be payed back:</label>
        <input type='text' class='form-control requirement'>
      </div>
    </form>";

mysqli_close($connection);
?>