<!DOCTYPE html>
<html lang="en" >
<?php
include("header.php");
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$testpassword=0;
	if(!empty($_POST["submit"]))   // if records were not empty
      {
        $row=$mng->executeQuery('riderent.admin',$query);
        foreach ($row as $key) {
          if($key->username == $username) 
          {
            if($key->password==$password)
            {
              $testpassword=1;  
              break;
            }
          }
	    }      
        if($testpassword==1)  // if matching records in the array & if everything is right
        {
          $_SESSION["logged"] = true; // put user id into temp session
          $_SESSION['email'] = $_POST['email'];
          header("location: dashboard.php"); // redirect to index.php page 
        }
        else
        {
          $message = "Invalid email or Password!"; // throw error
        }
      }	
}

if(isset($_POST['submit1'] ))
{
	$bulkWrite = new MongoDB\Driver\BulkWrite;
	$un=$_POST['cr_user'];
	$em=$_POST['cr_cpass'];
    $check_username=0;
    $check_email=0;
    $row=$mng->executeQuery('riderent.admin',$query);
    foreach ($row as $key) {
    	if($key->email == $em ) 
        {
        	$check_email=1;
            break;
        }
        if($key->username==$un) 
        {
        	$check_username=1;
            break;
        }
	}
     if(empty($_POST['cr_user']) ||empty($_POST['cr_email'])||empty($_POST['cr_pass']) ||empty($_POST['cr_cpass']))
	{
		$message = "ALL fields must be fill";
	}
	else
	{		
		if($_POST['cr_pass'] != $_POST['cr_cpass']){
			$message = "Password not match";
		}
		
		elseif (!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) // Validate email address
		{
			$message = "Invalid email address please type a valid email!";
		}
		elseif($check_username)
		{
			$message = 'username Already exists!';
		}
		elseif($check_email)
		{
			$message = 'Email Already exists!';
		}
						
		else//if code is valid 
		{
			$doc = ["user_name"=>$_POST['cr_user'],"email"=>$_POST['cr_email'],"password"=>$_POST['cr_cpass']];
          	$bulkWrite->insert($doc);
        	$mng->executeBulkWrite('riderent.admin',$bulkWrite);
			$message = "Admin Added successfully!";
		}
        
	}

}
?>

<head>
  <title>Login Form</title>  
</head>
<body>
<div class="container">
  <div class="info">
    <h1>Administration </h1><span> login Account</span>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="images/manager.png"/></div>
  
  <form class="register-form" action="index.php" method="post">
    <input type="text" placeholder="username" name="cr_user"/>
    <input type="text" placeholder="email address"  name="cr_email"/>
	 <input type="password" placeholder="password"  name="cr_pass"/>
	  <input type="password" placeholder="Confirm password"  name="cr_cpass"/>
   <input type="submit"  name="submit1" value="Create" />
    <p class="message">Already registered? <a href="#">Sign In</a></p>
  </form>
  
  <span style="color:red;"><?php echo $message; ?></span>
   <span style="color:green;"><?php echo $success; ?></span>
  <form class="login-form" action="index.php" method="post">
    <input type="text" placeholder="username" name="username"/>
    <input type="password" placeholder="password" name="password"/>
    <input type="submit"  name="submit" value="login" />
    <p class="message">Not registered? <a href="#">Create an account</a></p>
  </form>
  
</div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='js/index.js'></script>
  

    



</body>

</html>
