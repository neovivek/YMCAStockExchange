<?php

require('connectdb.php');
session_start();
ini_set("precision", 3);

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
if(mysqli_num_rows($result) == 0) die('Can\'t Process Request');
$row = mysqli_fetch_array($result);

$query1 = "SELECT * FROM user WHERE id ='".$a."' ";
$result1 = mysqli_query($connection, $query1) or die("Mysql error ". mysql_error());
$userdata = mysqli_fetch_array($result1);

$_SESSION['cp'.$a.$row['id']] = $row['currPrice'];

$availshares = (int) bcmul(0.9, $row['shareLeft'], 2);
$shares = (int)$userdata['balance'] / (int)$row['currPrice'];
$shares = (int)$shares;

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
        <label class='control-label'>Shares you can Buy:</label>
        <input type='text' class='form-control' disabled value='". min($shares, $availshares, 5000) ."'>
      </div>
      <div class='form-group'>
        <label class='control-label'>How many shares you want to Buy:</label>
        <input type='text' class='form-control requirement' data-avail='".$availshares."' data-share='".$shares."'>
      </div>
    </form>";

mysqli_close($connection);
?>