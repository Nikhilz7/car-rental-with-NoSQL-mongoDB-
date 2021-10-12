<?php
include("connect.php"); //connection to db
error_reporting(0);
session_start();


// sending query
$cname=$_GET['bid'];
$bulkWrite->update(["car_name"=>$cname],['$set'=>['car_availabilty' => 'yes']]);
$mng -> executeBulkWrite('riderent.cars',$bulkWrite);


$mng1 = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query([]); 
$bulkWrite1 = new MongoDB\Driver\BulkWrite();

$bulkWrite1->delete(["car_name"=>$cname], ['limit' => 1]);
$mng1->executeBulkWrite('riderent.booking',$bulkWrite1);

header("location:mybookings.php");  //once deleted success redireted back to current page
?>
