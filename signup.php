<?php
require_once './init/db.php';;
require_once './utility/isEmailAvilable.php';

if ( isset($_SESSION['info'] )  ) {
    header('Location: http://localhost:8080/login_signup_php/dashboard/index.php');
}

if (isset($_POST['signup'])) {
	$username= htmlspecialchars(strip_tags($_POST['username']));
	$email= htmlspecialchars(strip_tags($_POST['email']));
	$phone= htmlspecialchars(strip_tags($_POST['phone']));
	$password= htmlspecialchars(strip_tags($_POST['password']));
	$errors=array();
	$message='';

	if (empty($username) && empty($email) && empty($phone) && empty($password) ) {
		array_push($errors,strtoupper("all field required"));
	} else {
		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors[]='Enter valid email';
		}
		elseif ( $isEmailAvailable($email) ==1 ) {
			$errors[]="This email {$email} already taken by someone. try another";
		}
		elseif ( strlen($phone)  !=10 ) {
		   $errors[]='enter 10 digit phone number';
		}

		elseif (strlen($password)<6) {
			$errors[]="password must be 6 characters long";
		}
		else  {
      	// insert into db
		$status=1;
		$sql="INSERT INTO `login_singnup_php`.`users` (`username`, `email`, `phone`, `password`, `status`) VALUES (?,?,?,?,?);
		";
       $hashedpassword=password_hash($password, PASSWORD_BCRYPT);
	   $stmt=	$conn->prepare($sql);
	   $stmt->bind_param("ssssi", $username,$email,$phone,$hashedpassword,$status);
	   $stmt->execute();
	   if ($conn->insert_id>0) {
		   array_push( $errors, strtoupper('successfully registered') );
	   }else {
		   array_push( $errors, strtoupper('oops something went wrong') );
		   
	   }

	}

	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>login singup using php (singnup)</title>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"/>
<!-- <link rel="stylesheet" type="text/css" href="./font-awesome/css/all.css"> -->
</head>
<body>
<div class="container">
	<div class="row">
		 <h1><i class="fa fa-lock" aria-hidden="true"></i> Create an account</h1>
       
        </div><br /><br />
		 
		<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		
		
		<?php
                  if (isset($errors) ) {
				      foreach ($errors as $key=> $error) {
						
					   echo "<p class='text-warning bg-primary'> {$error} </p>";
					   if ( $error==="SUCCESSFULLY REGISTERED" ) {
						   echo "<a href='./index.php'>click here to login</a>";
					   }
			           }
				  }					     
		?>
                	<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="username" class="form-control" placeholder="username"/>
							</div><br />

								<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="text" name="email" class="form-control" placeholder="email"/>
							</div><br />
         
                	<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-phone"></i></span>
								</div>
									<input type="number" name="phone" class="form-control" placeholder="phone number"/>
							</div><br />
							
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-key icon"></i></span>
								</div>
									<input type="password" name="password" class="form-control" placeholder="password"/>
							</div><br />


            <!-- <div class="checkbox">
              <label><input type="checkbox" value=""/> Remember me</label>
            </div> -->
            <br />
              <button type="submit" name="signup" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Signin</button>
		</form>
       <!--  <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span>Login with Facebook </button><br />
               <br /> <center><div style="border:1px solid black;height:1px;width:300px;"></div></center><br /> -->
         <div class="footer">
                  <p>Aleady registered! <a href="index.php">Login</a></p>
          <!-- <p>Forgot <a href="#">Password?</a></p> -->
        </div> 
 
	</div>
 

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>
</html>