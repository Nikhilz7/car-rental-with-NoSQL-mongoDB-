<?php
include("../connect.php");
error_reporting(0);
session_start();

// mysqli_query($db,"DELETE FROM users WHERE email = '".$_GET['user_del']."'");
$email=$_GET['user_del'];
$bulkWrite->delete(['email' => $email], ['limit' => 1]);
$mng->executeBulkWrite('riderent.users',$bulkWrite);

header("location:allusers.php");  

?>
