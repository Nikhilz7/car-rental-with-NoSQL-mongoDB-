<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include('connect.php');
    $cname=$_GET['bid'];
	$rows = $mng->executeQuery("riderent.booking",$query);
	foreach ($rows as $row)
	{
        if($row->car_name == $cname){
            $fare=$row->Fare;
            $total=$row->Total;
            
        }
    }
    // car Deletion
    include("connect.php");
    error_reporting(0);
    session_start();
    $email=$_SESSION['email'];
    $to      = $email; // Send email to our user
    $subject = 'Bill'; // Give the email a subject 
    $message = '
    Invoice from Ride&Rent
    ---------------------------------------------------------------------------
    Fare Amount='.$fare.'
    Total Amount='.$total.'
   -----------------------------------------------------------------------------
    Thankyou
    
    '; // Our message above including the link
                        
    $headers = 'From:noreply@riderent.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bill has been sent to Your Email</p>
    <button><a href="mybookings.php">Go Back</a></button>
</body>
</html>