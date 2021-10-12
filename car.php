<!DOCTYPE html>
<html lang="en">
  <head>
	<title>CarList</title>
  <!-- links and navbar -->
  <?php include "header.php"; ?>
	<style>
	.active-cyan-4 input[type=text]:focus:not([readonly]) {
  border: 1px solid #4dd0e1;
  box-shadow: 0 0 0 1px #4dd0e1;
}
.active-cyan-3 input[type=text] {
  border: 1px solid #4dd0e1;
  box-shadow: 0 0 0 1px #4dd0e1;
}
.but{
	float:right;
	width:150px;
}
	</style>
  </head>
  <body>    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/image_5.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Cars <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Choose Your Car</h1>
          </div>
        </div>
      </div>
    </section>

	<section class="ftco-section bg-light">
    	<div class="container">
		<form name="ser"action="" method="POST">
		<div class="active-cyan-3 active-cyan-4 mb-4">
			<input type="text" name="car" class="form-control" ><br>
			<input type="submit" name="search" value="search" class="btn btn-primary py-2 ml-1 but" >
			</div>
		</form><br><br>
			<form action="" method="POST">
				<div class="row">
					<!-- php car details -->
					<?php
						if(isset($_POST['search'])){
									$car=$_POST['car'];
									require 'vendor/autoload.php';
									$client1=new MongoDB\Client;
									$a1=$client1->riderent;
									$b1=$a1->cars;
									$g=[['$match'=>['car_name'=>$car]]];
									$results=$b1->aggregate($g); 
									if ($results) {
									foreach($results as $ros){

											echo '<div class="col-md-4">
											<div class="car-wrap rounded ftco-animate">
											<div class="img rounded d-flex align-items-end" style="background-image: url('.$ros->car_img.');">
											</div>
											<div class="text">
											<h2 class="mb-0">'.$ros->car_name.'</h2>
											<div class="d-flex mb-3">
											<p class="price ml-auto">&#x20B9;'.$ros->car_priceperday.' <span>/day</span></p>
											</div>';
											echo '<p class="d-flex mb-0 d-block"><a href="booking.php?car='.$ros->car_name.'" class="btn btn-primary py-2 ml-1" type="submit" name='.$ros->car_id.'>Book now</a><a href="#" class="btn btn-secondary py-2 ml-1">Details</a> </p>';
											echo'</div>
											</div>
											</div>';
										}
										
									}else {
											echo'no cars found';
										}
									}else{

						$rows = $mng->executeQuery("riderent.cars",$query);
						
					 	foreach ($rows as $row)
						{
							 if($row->car_availability == 'yes'){
								
										echo '<div class="col-md-4">
												<div class="car-wrap rounded ftco-animate">
													<div class="img rounded d-flex align-items-end" style="background-image: url('.$row->car_img.');">
													</div>
													<div class="text">
														<h2 class="mb-0">'.$row->car_name.'</h2>
														<div class="d-flex mb-3">
															<p class="price ml-auto">&#x20B9;'.$row->car_priceperday.' <span>/day</span></p>
														</div>';
														echo '<p class="d-flex mb-0 d-block"><a href="booking.php?car='.$row->car_name.'" class="btn btn-primary py-2 ml-1" type="submit" name='.$row->car_id.'>Book now</a><a href="#" class="btn btn-secondary py-2 ml-1">Details</a> </p>';
													echo'</div>
												</div>
											</div>';
								
								}
							}
						}
					?>
					<!-- cars rows ending -->
				</div>
			</form>
    	<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
    	</div>
	</section>
	
	<!-- footer -->
	<?php include "footer.html"?>     
  </body>
</html>