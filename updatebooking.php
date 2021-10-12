<?php
include("connect.php"); //connection to db
error_reporting(0);
session_start();


// sending query
$cname=$_GET['bid'];
$bulkWrite->update(["car_name"=>$cname],['$set'=>['status' => 'Collected']]);
$mng -> executeBulkWrite('riderent.booking',$bulkWrite);
header("location:mybookings.php");  //once deleted success redireted back to current page
?>