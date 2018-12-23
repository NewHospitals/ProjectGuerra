<?php

include_once 'db_config.php';

$validUsername = false;
$validEmail	   = false;


if( isset($_POST['ajax']) && isset($_POST['name']) ){
 $checked_arr = $_POST['name'];

 $response	= array();
 $username	= mysqli_real_escape_string($con,$_POST['name']); 
 $sql		= "SELECT username from accounts where accounts.username='".$username."'";
 $res		= mysqli_query($con, $sql);
 $count		= mysqli_num_rows($res);
 
 if($count > 0){
	 $response['status'] = false;
	 $response['msg'] = 'Username already exists.';
 }else if(strlen($username) < 6 || strlen($username) > 15){
	 $response['status'] = false;
	 $response['msg'] = 'Username must be 6 to 15 characters';
 }else if (!preg_match("/^[a-zA-Z1-9]+$/", $username)){
	 $response['status'] = false;
	 $response['msg'] = 'Use alphanumeric characters only.';
 }else{
	 $response['status'] = true;
	 $response['msg'] = 'Username is available.';
	 $validUsername = true;
 }

 echo json_encode($response);
 exit;
}


if( isset($_POST['ajax']) && isset($_POST['email']) ){
	$checked_arr = $_POST['email'];
   
	$response	= array();
	$email	    = mysqli_real_escape_string($con,$_POST['email']); 
	$sql		= "SELECT email from accounts where accounts.email='".$email."'";
	$res		= mysqli_query($con, $sql);
	$count		= mysqli_num_rows($res);
	
	if($count > 0){
		$response['status'] = false;
		$response['msg'] = 'Email already exists.';
	}else if($count==0){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response['status'] = false;
			$response['msg'] = 'Enter valid email address.';	
		}else{
			$response['status'] = true;
			$response['msg'] = 'Valid email address.';
			$validEmail = true;
		}
	}
   
	echo json_encode($response);
	exit;
}




include_once 'db_config.php';

$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$error = false;
$message = "";
$success = false;

if(isset($_POST['registerBtn'])){

	$message = "";

	$id 		= 'U'.uniqid();
	$user 		= ($_POST["username"]);
	$x 			= ($_POST["password"]);
	$confirmPassword = ($_POST["cpassword"]);


	$password = password_hash($x, PASSWORD_DEFAULT);


	$email 		= ($_POST["email"]);

	if ( (!empty($id)) && (!empty($user)) && (!empty($password)) && (!empty($confirmPassword)) && (!empty($email))) {
		
		/*if(($validEmail) && ($validUsername)){*/
			if($x === $confirmPassword) {

				$sql1 	= "INSERT INTO accounts (userId,username,password,email) VALUES ('$id','$user','$password','$email')";
				$sql2 	= "INSERT INTO accountbalance (userId,amount) VALUES ('$id',0)";
	
				if((mysqli_query($con, $sql1)) && (mysqli_query($con, $sql2))){
					$id="";
					$user="";
					$password="";
					$email="";
	
					$success = true;
	
					//header('Location: register.php');
				} else{
					$error = true;
					// $message = "Could not able to execute $sql. " . mysqli_error($con);
					$message = "Server couldn't handle the request";
				}
			}else{
				$error = true;
				$message = "Passwords do not match.";
			}
		/*}*/

		if(!$validEmail){
			$error = true;
			$message = "Email Already exists";
		}

		if(!$validUsername){
			$error = true;
			//$message = "Username Already exists";
		}

	}else{
		$error = true;
		$message = "Error creating an account";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sign up</title>
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">

	




</head>
<body style ="overflow:auto;">
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
					<a class="nav-link" href="https://www.guerrasenterprises.com">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php">Unlock</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="orders.php">Orders</a>
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
						<li class='drpItems'><a class='dropdown-item dropList' href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
						<li class='drpItems'><a class='dropdown-item dropList' href='register.php'><span class='glyphicon glyphicon-pencil'></span> Signup</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<!-- -----------------------END OF NAVBAR------------------------->
	<div class="container text-center">
		<div class="form-signin">
			<img class="mb-4" src="images/logo.png" alt="" width="100" height="100">
			<h1 class="h3 mb-3 font-weight-bold">Welcome</h1>
			<h4 class="h4 mb-4 font-weight-light">Enter your Information</h4>
		
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			
				<label for="inputName" class="sr-only">Name</label>
				<input type="text" id="username" name="username" class="form-control" placeholder="Name" required autofocus>
				<span id="usercheck" class="help-block"></span>
			


			<label for="inputEmail" class="sr-only">Email Address</label>
			<input type="email" id="email" name="email" class="form-control"  placeholder="Email Address" required>
			<span id="emailcheck" class="help-block"></span>

			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control"  placeholder="Password" required>
		
			<label for="confirmPassword" class="sr-only">Confirm Password</label>
			<input type="password" id="cpassword" name="cpassword" class="form-control" style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; margin-bottom: 10px;" placeholder="Confirm Password" required>
		
			<div class="checkbox mb-3">
			</div>
			<button id="registerBtn" name="registerBtn" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

			<?php if($success){?>
				<div class="alert alert-success alert-dismissible" style="margin-top:5%;margin-bottom:5%;">
    			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    			User Successfully Created
  				</div>
				<a href="login.php">Return to Login</a>  
			<?php } ?>

			<?php if($error){?>
				<div class="alert alert-danger alert-dismissible" style="margin-top:5%;margin-bottom:5%;">
    			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    			<?php echo $message ?>
  				</div>
			<?php } ?>
			
			</form>

			<button id="loginBtn" style="display:none" onclick="window.location.replace('index.html')" class="btn btn-lg btn-primary btn-block">Log in</button>
			<p class="mt-5 mb-3 text-muted">&copy; Copyright 2018</p>
		</div>
	</div>
	<script src="scripts/home.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
	


	<script type="text/javascript">
	$(document).ready(function(){
		$('#username').keyup(function() {
			var name = $(this).val();
			$.ajax({
			type: 'post',
			data: {ajax: 1,name: name},
			success: function(response){
				var myArr = JSON.parse(response);
    			console.log(myArr["msg"]);
				console.log(myArr["status"]);

				if((myArr["status"])==true){
					$('#username').removeClass('is-invalid').addClass('is-valid');
					$('#usercheck').hide();
				}else{
					$('#username').removeClass('is-valid').addClass('is-invalid');
					$('#usercheck').show();
					$('#usercheck').html(myArr["msg"]);
				}
				
			}
			});				
		});
		$('#email').keyup(function() {
			var email = $(this).val();
			$.ajax({
			type: 'post',
			data: {ajax: 1,email: email},
			success: function(response){
				var myArr = JSON.parse(response);
    			console.log(myArr["msg"]);
				console.log(myArr["status"]);

				if((myArr["status"])==true){
					$('#email').removeClass('is-invalid').addClass('is-valid');
					$('#emailcheck').hide();
				}else{
					$('#email').removeClass('is-valid').addClass('is-invalid');
					$('#emailcheck').show();
					$('#emailcheck').html(myArr["msg"]);
				}
				
			}
			});				
		});
	});
</script>
</body>
</html>

