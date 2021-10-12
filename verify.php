<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<?php
    // car Deletion
    include("connect.php");
    error_reporting(0);
    session_start();
    $email=$_GET['email'];
    $bulkWrite->update(["email"=>$email],['$set'=>['verified' => 'yes']]);
    $mng -> executeBulkWrite('riderent.users',$bulkWrite);
    header("location:index.php");  
?>
</head>
<body>
 <center>Email has been verified</center>   
</body>
</html>