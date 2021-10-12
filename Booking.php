<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Booking</title>
  <!-- links and navbar -->
    <?php include ("header.php");?>
  </head>
  <body>
<?php
	$bulkWrite = new MongoDB\Driver\BulkWrite;
	if ($_SESSION["logged"]==true) {	
		if(isset($_POST['submit']))   // if button is submit
  		{  
			$var=0;
			$row1=$mng->executeQuery('riderent.users',$query);
        	foreach ($row1 as $key) {
          	if($key->email ==$_SESSION['email'] ) 
          	{
				if ($key->verified=="yes") {
					$var=1;
					break;
				}
            }
          }	
			//fetching and find if its empty
			if(empty($_POST['pickuploc'])||empty($_POST['dropoffloc'])||empty($_POST['pickupdate'])||empty($_POST['dropoffdate'])||empty($_POST['pickuptime']))
			{
				$message = "All fields must be Required!";
			}
			elseif ($var==0) {
				$message = "Please verify your Email!";
			}
			else
			{
				$email=$_SESSION['email'];
				$pdate=$_POST['pickupdate'];
				$pdate1=date("Y-m-d",strtotime($pdate));
				$ddate=$_POST['dropoffdate'];
				$ddate1=date("Y-m-d",strtotime($ddate));
				$carid=$_GET['id'];
				$carname=$_GET['car'];
				//inserting values into db
				$doc = ["email"=>$email,"pickup_loc"=>$_POST['pickuploc'],"dropoff_loc"=>$_POST['dropoffloc'],"pickup_date"=>$pdate1,"dropoff_date"=>$ddate1,"pickup_time"=>$_POST['pickuptime'],"car_name"=>$carname,"status"=>'Pending'];
				$bulkWrite->insert($doc);
				$mng->executeBulkWrite('riderent.booking',$bulkWrite);
				
    			$bulkWrite1 = new MongoDB\Driver\BulkWrite();
				$bulkWrite1->update(["car_name"=>$cname],['$set'=>['car_availability' => 'no']]);
				$mng -> executeBulkWrite('riderent.booking',$bulkWrite1);
				
				$success = "Car has been booked successufully<p>You will be redirected in <span id='counter'>5</span> second(s).</p>
							<script type='text/javascript'>
								function countdown() {
									var i = document.getElementById('counter');
									if (parseInt(i.innerHTML)<=0) {
										location.href = 'mybookings.php';
									}
									i.innerHTML = parseInt(i.innerHTML)-1;
								}
								setInterval(function(){ countdown(); },1000);
							</script>'";
					header("refresh:5;url=mybookings.php"); // redireted once inserted success
			}
		}
	}	
else
	$message="Please Login to Book your Car";
  	
?>
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/image_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay align-items-center"></div>
      <div class="container form">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-20 ftco-animate">
            <div class="col-md-20 d-flex align-items-center">
              <form action="" method="POST" class="request-form ftco-animate bg-primary">
                    <h2>Make your trip</h2>
					<span style="color:orange;"><?php echo $message; ?></span>
                     <span style="color:green;"><?php echo $success; ?></span>
			    	<div class="form-group">
			    		<label for="sel1" class="label">Pick-up location</label>
						<!-- <input type="text" class="form-control"  name="pickuploc" placeholder="City, Airport, Station, etc"> -->
						<select class="form-control" name="pickuploc"  id="sel1" placeholder="City, Airport, Station, etc">
							<option>Indranagar</option>
							<option>Kormangala</option>
							<option>Mathikeri</option>
						</select>
			    	</div>
			    	<div class="form-group">
			    		<label for="sel2" class="label">Drop-off location</label>
						<!-- <input type="text" class="form-control" name="dropoffloc" placeholder="City, Airport, Station, etc" > -->
						<select class="form-control" name="dropoffloc"  id="sel2" placeholder="City, Airport, Station, etc">
							<option>Indranagar</option>
							<option>Kormangala</option>
							<option>Mathikeri</option>
						</select>
			    	</div>
			    	<div class="d-flex">
			    		<div class="form-group mr-2">
							<label for="" class="label">Pick-up date</label>
							 <?php $today = date("Y-m-d") ?>
			                <input type="date" class="form-control" name="pickupdate"  min="<?php echo($today);?>" placeholder="Date">
			            </div>
			            <div class="form-group ml-2" id="myDate">
			                <label for="" class="label">Drop-off date</label>
			                <input type="date" class="form-control" name="dropoffdate"  min="<?php echo($today);?>" placeholder="Date" >
			            </div>
		            </div>
		            <div class="form-group">
		                <label for="" class="label">Pick-up time</label>
		                <input type="time" class="form-control" id="appt" name="pickuptime" name="appt">
		            </div>
			        <div class="form-group">
			            <input type="submit" value="Rent a Car Now" name="submit" class="btn btn-secondary py-3 px-4">
			        </div>
			    </form>
            </div>
          </div>
        </div>
      </div>
    </div>    
    <!-- footer -->
    <?php include "footer.html"?>
</html>