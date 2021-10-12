<?php
    // car Deletion
    include("../connect.php");
    error_reporting(0);
    session_start();
    // mysqli_query($db,"DELETE FROM cars WHERE car_id = '".$_GET['car_del']."'");
    $car_name=$_GET['car_del'];
    $bulkWrite->delete(['car_name' => $car_name], ['limit' => 1]);
    $mng->executeBulkWrite('riderent.cars',$bulkWrite);
    header("location:all_cars.php");  
?>