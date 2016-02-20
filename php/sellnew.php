<?php

require('connectdb.php');
session_start();
$a = $_SESSION['userid'];
$b = $_REQUEST['name'];

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM company WHERE name='".$b."' ";
$result = mysqli_query($connection, $query) or die("Mysql error". mysql_error());
$row = mysqli_fetch_array($result);

$query1 = "SELECT * FROM user WHERE id ='".$a."' ";
$result1 = mysqli_query($connection, $query1) or die("Mysql error ". mysql_error());
$userdata = mysqli_fetch_array($result1);

$_SESSION['sp'.$a.$row['id']] = $row['currPrice'];

echo "<form>
      <div class='form-group'>
        <label class='control-label'>Available Balance:</label>
        <input type='text' class='form-control' disabled value='".$userdata['balance']."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>Share Price:</label>
        <input type='text' class='form-control' disabled value='".$row['currPrice']."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>Shares you can Sell:</label>
        <input type='text' class='form-control' disabled value='".$userdata['shares'.$row['id']]."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>How many shares you want to Sell:</label>
        <input type='text' class='form-control requirement'>
      </div>
    </form>";

mysqli_close($connection);
?>