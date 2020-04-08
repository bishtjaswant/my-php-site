<?php

require_once '../init/db.php';
if (  ! isset($_SESSION['info'] )  ) {
    header('Location: http://localhost:8080/login_signup_php/index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>login signup using php (Dashboard)</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" />
</head>

<body>


<div class="container">
    <div class="jumbotron">
        <h1 class="display-3">Hello, <?=$_SESSION['info']['username'];?>!</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>  <?=$_SESSION['info']['email'];?>  </p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="http://localhost:8080/login_signup_php/logout.php" role="button">Logout</a>
        </p>
      </div>
</div>

</body>
</html>