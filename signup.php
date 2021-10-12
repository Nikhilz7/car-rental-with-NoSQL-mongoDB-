<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Signup</title>
    <!-- links and navbar -->
    <?php
      $_SESSION['logged']=false;
      include "header.php"
    ?>
  </head>
  <?php
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  if(isset($_POST['submit']))   // if button is submit
  {  
    //lisence picture
    $filename = $_FILES["dlpic"]["name"]; 
    $tempname = $_FILES["dlpic"]["tmp_name"];  
    $folder = "license/".$filename;
     //fetching and find if its empty
      if(empty($_POST['fname'])||empty($_POST['lname'])||empty($_POST['email'])||empty($_POST['phone'])||empty($_POST['password'])||empty($_POST['cpassword'])||empty($_POST['age'])||(($_FILES['dlpic']['size'] == 0 && $_FILES['dlpic']['error'] == 0)))
      {
        $message = "All fields must be Required!";
      }
      else
      {
        //cheching username & email if already present
        $password=$_POST['password'];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $symbol = preg_match('@[\W]@',$password);
        //Password requirements:
        // Must be a minimum of 8 characters
        // Must contain at least 1 number
        // Must contain at least one uppercase character
        // Must contain at least one lowercase character
        // Must contain at least one symbol
        $em=$_POST['email'];
        $pn=$_POST['phone'];
        
        $check_email=0;
        $check_phone=0;
        $row=$mng->executeQuery('riderent.users',$query);
        foreach ($row as $key) {
          if($key->email == $em ) 
          {
            $check_email=1;
            break;
          }
          if($key->phone == $pn ) 
          {
            $check_phone=1;
            break;
          }
        }
        if($_POST['password'] != $_POST['cpassword']){  //matching passwords
          $message = "Passwords did not match";
        }
        elseif(!$uppercase || !$lowercase || !$number||!$symbol || strlen($password) < 8)  //cal password length
        {
          $message = "Password did not meet requirements";
        }
        elseif(strlen($_POST['phone']) < 10)  //cal phone length
        {
          $message = "invalid phone number!";
        }
        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
        {
          $message = "Invalid email address please type a valid email!";
        }
        elseif($check_email) //check email
        {
          $message = 'Email Already exists!';
        }
        elseif($check_phone)  //check username
        {
          $message = 'phoneno Already exists!';
        }
        else{
          //inserting values into db
          $doc = ["f_name"=>$_POST['fname'],"l_name"=>$_POST['lname'],"email"=>$_POST['email'],"phone"=>$_POST['phone'],"password"=>$_POST['password'],"license"=>$filename,"age"=>$_POST['age'],'verified'=>'no'];
          $bulkWrite->insert($doc);
          $mng->executeBulkWrite('riderent.users',$bulkWrite);

          $email=$_POST['email'];
          $to      = $email; // Send email to our user
          $subject = 'Signup | Verification'; // Give the email a subject 
          $con = '
          
          Thanks for signing up!
          Your account has been created,
          Please activate your account by pressing the url below.
        -----------------------------------------------------------------------------
          Please click this link to activate your account:
          http://localhost/carrentmongo/verify.php?email='.$email.'
          
          '; // Our message above including the link
                              
          $headers = 'From:noreply@riderent.com' . "\r\n"; // Set from headers
          mail($to, $subject, $con, $headers); // Send our email

          $success = "Account Created successfully! <p>You will be redirected in <span id='counter'>5</span> second(s).</p>
                                    <script type='text/javascript'>
                                    function countdown() {
                                      var i = document.getElementById('counter');
                                      if (parseInt(i.innerHTML)<=0) {
                                        location.href = 'login.php';
                                      }
                                      i.innerHTML = parseInt(i.innerHTML)-1;
                                    }
                                    setInterval(function(){ countdown(); },1000);
                                    </script>'";
          header("refresh:5;url=login.php"); // redireted once inserted success
        }
      }
  }
  ?>
  <body>
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/image_6.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay align-items-center"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-20 ftco-animate">
            <div class="col-md-20 d-flex align-items-center">
                <form action="" method="post" class="request-form ftco-animate bg-primary" enctype="multipart/form-data">
                <h2>Join us now to ride!</h2>
                    <span style="color:orange;"><?php echo $message; ?></span>
                     <span style="color:green;"><?php echo $success; ?></span>
                <div class="d-flex">
                  <div class="form-group mr-1">
                    <label class="label" for="">First Name</label>
                    <input class="form-control" type="text"  name="fname" placeholder="First Name"> 
                  </div>
                  <div class="form-group ml-1">
                    <label class="label" for="">Last Name</label>
                    <input class="form-control" type="text" name="lname" placeholder="Last Name"> 
                  </div>
                </div>
                <div class="d-flex">
                <div class="form-group mr-1">
                    <label for="" class="label">Enter your Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group ml-1">
                    <label for="" class="label">Enter your Phone no</label>
                    <input type="text" class="form-control" name="phone" placeholder="Phone no">
                </div>
                </div>
                <div class="d-flex">
                  <div class="form-group mr-1">
                    <label class="label" for="">Enter Your Age</label>
                    <input class="form-control" type="text"  name="age" placeholder="Age"> 
                  </div>
                  <div class="form-group ml-1">
                    <label for="" class="label">Upload Picture of License</label>
                    <input type="file" class="form-control" name="dlpic" id="dlpic">
                  </div>
                </div>
                <div class="form-group">
                    <label for="" class="label">Enter your Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="" class="label">Confirm your Password</label>
                    <input type="password" class="form-control" name="cpassword" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="submit" value="Register" name="submit" class="btn btn-secondary py-3 px-4">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- footer -->
    <?php include "footer.html"?>
  </body>
</html>