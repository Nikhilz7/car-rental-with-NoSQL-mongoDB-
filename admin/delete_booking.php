<?php
include("../connect.php");
error_reporting(0);
session_start();


// sending query
$email=$_GET['book_del'];
$car=$_GET['car'];
$bulkWrite->update(["car_name"=>$car],['$set'=>['car_availabilty' => 'yes']]);
$mng -> executeBulkWrite('riderent.cars',$bulkWrite);

$mng1 = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query([]); 
$bulkWrite1 = new MongoDB\Driver\BulkWrite();

$bulkWrite1->delete(['email' => $email], ['limit' => 1]);
$mng1->executeBulkWrite('riderent.booking',$bulkWrite1);

header("location:all_booking.php");  

?>
