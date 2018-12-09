<?php

include_once 'db_config.php';

$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$id 			= 2625; /*($_POST["id"]);*/
$user 		= ($_POST["username"]);
$x 				= ($_POST["password"]);


$password = password_hash($x, PASSWORD_DEFAULT);


$email 		= ($_POST["email"]);

if ( (!empty($id)) && (!empty($user)) && (!empty($password)) && (!empty($email))) {

	$sql 	= "INSERT INTO accounts (id,username,password,email) VALUES ('$id','$user','$password','$email')";

	if(mysqli_query($con, $sql)){
		echo "Records inserted successfully.";
		$id="";
		$user="";
		$password="";
		$email="";

		header('Location: register.php');
	} else{
    	echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
	}

}
 
?>









<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sign up</title>
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
</head>
<body class="text-center">
	<!-- -----------------------NAVBAR----------------------- -->
	<nav class="navbar navbar-expand-lg custNav">
		<!-- LOGO -->
	  	<a class="navbar-brand" href="#">
	  		<img src="images/logo.png" style="max-width:50px;">
	  	</a>
	  	<!-- Toggle Button -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#togglerBar" aria-controls="togglerBar" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="glyphicon glyphicon-align-justify" style="color:rgb(241,237,74);"></span>
  		</button>
		<div class="collapse navbar-collapse" id="togglerBar">
		    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
		        <a class="nav-link" href="index.html">Unlock</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Orders</a>
		      </li>
		    </ul>
		    <!-- USERNAME DROPDOWN -->
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" style="margin-right :60px;">
		          User
		          <span class="glyphicon glyphicon-user" ></span>
		        </a>
		        <ul class="dropdown-menu">
				<li class='drpItems'><a class='dropdown-item dropList' href='login.php'><span class='glyphicon glyphicon-credit-card'></span> Login</a></li>
								<li class='drpItems'><a class='dropdown-item dropList' href='register.php'><span class='glyphicon glyphicon-credit-card'></span> Signup</a></li>
		        </ul>
		      </li>
		    </ul>
	  	</div>
	</nav>
	<!-- -----------------------END OF NAVBAR----------------------- -->
	<div class="form-signin">
		<img class="mb-4" src="images/logo.png" alt="" width="100" height="100">
		<h1 class="h3 mb-3 font-weight-bold">Welcome</h1>
		<h4 class="h4 mb-4 font-weight-light">Enter your Information</h4>
	
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

		<label for="inputName" class="sr-only">Name</label>
		<input type="text" name="username" class="form-control" placeholder="Name" required autofocus>
	
		<label for="inputEmail" class="sr-only">Email Address</label>
		<input type="email" name="email" class="form-control"  placeholder="Email Address" required>
	
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" class="form-control"  placeholder="Password" required>
	
		<label for="confirmPassword" class="sr-only">Confirm Password</label>
		<input type="password" id="cpassword" class="form-control" style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; margin-bottom: 10px;" placeholder="Confirm Password" required>
	
		<div class="checkbox mb-3">
		</div>
		<button id="registerBtn" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
		<p class="mt-5 mb-3" style="display:none; color:green;" id="userCreated">User Successfully created</p>

		</form>

		<button id="loginBtn" style="display:none" onclick="window.location.replace('index.html')" class="btn btn-lg btn-primary btn-block">Log in</button>
		<p class="mt-5 mb-3 text-muted">&copy; Copyright 2018</p>
	</div>
	<script src="scripts/home.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>


