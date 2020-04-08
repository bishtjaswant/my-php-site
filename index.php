<?php
require_once './init/db.php';

if ( isset($_SESSION['info'] )  ) {
    header('Location: http://localhost:8080/login_signup_php/dashboard/index.php');
}


if (isset($_POST['login'])) {
	$email = htmlspecialchars(strip_tags($_POST['email']));
	$password = htmlspecialchars(strip_tags($_POST['password']));
	$errors = [];

	if (  empty($email) || empty($password) ) {
		$errors[] = 'email or password is required';
	} else {
		$sql = "SELECT `username`,`email`,`password`  AS `hashpassword`   FROM `users` WHERE `email`=? LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result($username, $email, $hashpassword);
		$stmt->store_result();
		if ($stmt->num_rows > 0) {	
			$stmt->fetch();
			if (password_verify($password, $hashpassword ) ) {
				//    create session
				$_SESSION['info']=[
					'username'=>$username,
					'email'=>$email
				];
				echo  "<script>
				window.location.assign('./dashboard/index.php');
				</script>";
			} else {
				$errors[]='password incorrect';
			}
			
		} else {
			$errors[]='invalid emaail address';
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>login signup using php (Login)</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" />
</head>

<body>
	<div class="container">
		<div class="row">
			<h1><i class="fa fa-lock" aria-hidden="true"></i> Login</h1>

		</div><br /><br />
		<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

			<?php


			if (isset($errors)) {
				foreach ($errors as  $error) {
					echo '<p class="text-danger">' . $error . '</p>';
				}
			}
			?>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
				</div>
				<input type="email" name="email" class="form-control" placeholder="email" />
			</div><br />

			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
				</div>
				<input type="password" name="password" class="form-control" placeholder="password" />
			</div><br />

			<br />
			<!-- <div class="checkbox">
              <label><input type="checkbox" value=""/> Remember me</label>
            </div> -->
			<br />
			<button type="submit" name="login" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Login</button>

			<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span>Login with Facebook </button><br />
			<br />
			<div style="border:1px solid black;height:1px;width:300px;margin:0 auto;"></div><br />


		</form>

		<div class="footer">
			<p>Don't have an Account! <a href="./signup.php">Sign Up Here</a></p>
			<!-- <p>Forgot <a href="#">Password?</a></p> -->
		</div>

	</div>


	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>