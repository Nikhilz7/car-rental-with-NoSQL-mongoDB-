<!DOCTYPE html>
<html lang="en">
  <head>
	<title>MyBookings</title>
  <!-- links and navbar -->
  <?php include "header.php" ?>

  </head>
  <body>    
  <section class="hero-wrap hero-wrap-2" style="background-image: url('images/image_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
	  <div class="row no-gutters slider-text align-items-end justify-content-start">
		  <div class="col-md-9 ftco-animate pb-5">
			  <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home<i class="ion-ios-arrow-forward"></i></a></span> <span>My Bookings <i class="ion-ios-arrow-forward"></i></span></p>
			  <h1 class="mb-3 bread">My Journey</h1>
			</div>
        </div>
	</div>
</section>

<style>

.container {
overflow-x:auto;
}
table{
	background-color:#01d28e;
}

th,td {
	text-align: center;
	padding: 15px;
	color: black;
}

th {
	color: #01d28e;
	background-color: black;
}
</style>

<section class="ftco-section ftco-cart">
    	<div class="container">
			<div class="row">
				<div class="col-md-12 ftco-animate" style="overflow-x:auto;">
					<table class="table"> 
					<form action="" method="POST">
					<?php 
						$rows = $mng->executeQuery("riderent.booking",$query);
						if($rows==""){
							echo '<h1 class="mb-3 bread"><center><a href="car.php">Choose Your Ride Now</a></center></h1>';
						}
						else{
					?>
					<thead>
						<tr>
							<th>Car Name</th>
							<th>PickUp Location</th>
							<th>DropOff Location</th>
							<th>PickUp Date</th>
							<th>DropOff Date</th>
							<th>PickUp time</th>
							<th>Status</th>
							<th>Fare</th>
							<th colspan='2'>Action</th>
						</tr>
					</thead>
						<?php
						$rows1 = $mng->executeQuery("riderent.booking",$query);
						foreach ($rows1 as $row)
					 	{	if($row->email == $_SESSION['email']){
						?>
						<tbody>				
							<tr>	
								<td data-column="Car Name"> <?php echo $row->car_name ?></td>
								<td data-column="PickUp Location"><?php echo $row->pickup_loc ?></td>
								<td data-column="DropOff Location"><?php echo $row->dropoff_loc ?></td>
								<td data-column="PickUp Date"><?php echo $row->pickup_date ?></td>
								<td data-column="DropOff Date"><?php echo $row->dropoff_date ?></td>
								<td data-column="PickUp time"><?php echo $row->pickup_time ?></td>
								<?php
															if($row->status=='Pending')
															{
																echo'<td data-column="Status">Pending</td>';
															?>
															<td data-column="Fare"><?php echo $row->Total; ?></td>
															<td data-column="Action"> <a href="updatebooking.php?bid=<?php echo $row->car_name;?>" onclick="return confirm('Status Updated');" class="btn btn-success btn-flat btn-addon btn-xs m-b-10">Collect</a> 
															</td>
															<td data-column="Action"> <a href="cancelbooking.php?bid=<?php echo $row->car_name;?>" onclick="return confirm('Are you sure You want to cancel Your Booking?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">Cancel</a> 
															</td>
													
														<?php
															}
															elseif($row->status=='Collected')
															{
																echo'<td data-column="Status">Collected</td>';
																?>
																<td data-column="Fare"><?php echo $row->Total; ?></td>
																<td data-column="Action"> <a href="returncar.php?bid=<?php echo $row->car_name;?>"  onclick="return confirm('Are you sure You want to Return the Car?');" class="btn btn-success btn-flat btn-addon btn-xs m-b-10">Return</a></td>
															<?php
															}
															elseif($row->status=='Returned') {
																echo'<td data-column="Status">Returned</td>';
															?>
																<td data-column="Fare"><?php echo $row->Total; ?></td>
																<td data-column="Action"> <a href="bill.php?bid=<?php echo $row->car_name;?>"  class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">Pay</a></td>
															<?php
															}
															else {
																echo'<td data-column="Status">Paid</td>';
																?>
																<td data-column="Fare"><?php echo $row->Total;?></td>
																<td data-column="Action"> <a href="" class="btn btn-success btn-flat btn-addon btn-xs m-b-10">Paid</a></td>
															<?php
															}
														?>
							</tr>
						<?php	
							} 
						}	
						}
						?>											
						</tbody>
					</form>
				</table>
			</div>
		</div>
   	</div>
</section>

<!-- footer -->
	<?php include "footer.html"?>     
</body>
</html>