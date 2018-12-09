<?php

session_start();

$userLogin;

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$userLogin = true;
	//echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
} else {
	$userLogin = false;
	//echo "Please log in first to see this page.";
	//header('Location: login.php');
}

if(isset($_POST['btnSubmit'])){
	serviceExecute($userLogin);
}


function serviceExecute($userLogin) {

	include_once 'db_config.php';

	$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

	if ( mysqli_connect_errno() ) {
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}


	if($userLogin){

		$serviceValue 	= $_POST["service"];
		$imei 			= $_POST["imeiNo"];

		$userId			= $_SESSION["userId"];

		$result = mysqli_query($con,"SELECT amount FROM services WHERE serviceValue='$serviceValue'");
		$row = mysqli_fetch_array($result);
		//echo $row['name'];

		$amount = $row['amount']; 
		$orderId = 'O'.uniqid();

		if ( (!empty($serviceValue)) && (!empty($imei)) )  {

			$sql 	= "INSERT INTO orders (orderId,userId,IMEI,serviceId,amount) VALUES ('$orderId','$userId','$imei','$serviceValue','$amount')";
		
			if(mysqli_query($con, $sql)){
				echo "Records inserted successfully.";
				$serviceValue="";
				$imei="";
		
				//header('Location: register.php');
			} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
			}
		
		}
	
	}else{
		header('Location: login.php');
	}
}



?>







<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Home</title>
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
</head>
<body style="background-image: url('images/bg.jpg');background-repeat: no-repeat;background-size: cover;">
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
				<?php if(($userLogin)){ ?>
					<li class="drpItems"><a class="dropdown-item dropList" href="#"><span class="glyphicon glyphicon-credit-card"></span> Wallet</a></li>
		          	<li class="drpItems"><a class="dropdown-item dropList" href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
		          	<li class="drpItems"><a class="dropdown-item dropList" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>	
				<?php } ?>

				<?php if(!($userLogin)){ ?>
					<li class='drpItems'><a class='dropdown-item dropList' href='login.php'><span class='glyphicon glyphicon-credit-card'></span> Login</a></li>
					<li class='drpItems'><a class='dropdown-item dropList' href='register.php'><span class='glyphicon glyphicon-credit-card'></span> Signup</a></li>
				<?php } ?>
		        </ul>
		      </li>
		    </ul>
	  	</div>

	</nav>
	<!-- -----------------------END OF NAVBAR------------------------->

	<div class="jumbotron d-flex align-items-center backgroundImg" style="height: 100%; padding: 0;">
		<!-- <img src="images/back.jpg" id="backgroundImg"> -->
		<div class="container text-center">
			<div class="typewriter">
			  <h1 id="txtChange">Check & unlock your phone.</h1>
			  <br><br>
			</div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		  		<select name="service" id="service" onchange="check();">
					<option value="0" selected="selected">PLEASE CHOOSE CHECKER</option>
					<optgroup label="iPHONE SERVICES">
						<option value="27">1.60$ - iPHONE GSX COMPLETE INFO - PICTURES</option>
						<option value="102">0.20$ - iPHONE CARRIER S1</option>
						<option value="101">0.20$ - iPHONE CARRIER S2</option>
						<option value="110">0.15$ - iPHONE COUNTRY &amp; MPN</option>
						<option value="8">0.08$ - iPHONE SIM-LOCK</option>
						<option value="109">0.20$ - APPLE iCLOUD HINT</option>
						<option value="30">0.10$ - APPLE BASIC INFO</option>
						<option value="12">0.07$ - IMEI ⇄ SN CONVERT</option>
						<option value="203">0.02$ - BRAND &amp; MODEL INFO</option>
						<option value="26">0.01$ - APPLE SERIAL INFO</option>
					</optgroup>
					<optgroup label="STATUS SERVICES">
						<option value="3">0.03$ - iCLOUD ON/OFF</option>
						<option value="4">0.12$ - iCLOUD CLEAN/LOST</option>
						<option value="6">0.12$ - WW BLACKLIST STATUS - PRO</option>
						<option value="106">7.00$ - T-MOBILE USA UNBARRING L/S</option>
						<option value="21">0.15$ - SPRINT USA STATUS - PRO</option>
						<option value="11">0.05$ - SPRINT USA STATUS - SIMPLE</option>
						<option value="16">0.10$ - T-MOBILE USA STATUS - PRO</option>
						<option value="10">0.05$ - T-MOBILE USA STATUS - SIMPLE</option>
						<option value="9">0.05$ - VERIZON USA CLEAN/STOLEN</option>
						<option value="33">0.05$ - METROPCS USA CLEAN/STOLEN</option>
						<option value="20">0.00$ - KOREA CLEAN/STOLEN</option>
						<option value="31">0.00$ - AUSTRALIA CLEAN/STOLEN</option>
						<option value="28">0.00$ - KDDI JAPAN CLEAN/STOLEN</option>
						<option value="32">0.00$ - SOFTBANK JAPAN CLEAN/STOLEN</option>
						<option value="206">0.02$ - XIAOMI MI LOCK STATUS</option>
					</optgroup>
					<optgroup label="GENERIC SERVICES">
						<option value="19">0.10$ - LG INFO</option>
						<option value="7">0.50$ - NOKIA FW</option>
						<option value="24">0.10$ - ZTE INFO</option>
						<option value="5">0.20$ - SONY INFO</option>
						<option value="23">0.10$ - ACER INFO</option>
						<option value="2">0.20$ - NOKIA INFO</option>
						<option value="15">0.20$ - HUAWEI INFO</option>
						<option value="22">0.10$ - LENOVO INFO</option>
						<option value="1">0.20$ - SAMSUNG INFO</option>
						<option value="13">0.10$ - MOTOROLA INFO</option>
					</optgroup>
					<optgroup label="UNLOCK SERVICES">
						<option value="113">6.0$ - EMEA SERVICE UNLOCK</option>
						<option value="100">1.00$ - AT&amp;T USA CLEAN UNLOCK</option>
						<option value="107">2.00$ - BOUYGUES FRANCE UNLOCK</option>
						<option value="108">10.0$ - HUTCHISON SWEDEN UNLOCK</option>
						<option value="114">3.00$ - LG INTERNATIONAL UNLOCK</option>
						<option value="115">2.00$ - HTC INTERNATIONAL UNLOCK</option>
						<option value="116">1.60$ - ZTE INTERNATIONAL UNLOCK</option>
					</optgroup>
				</select>
				<br><br>
				<input class= "text-center" id="imeiNo" type="text" name="imeiNo" placeholder="Enter IMEI">
				<br><br><br>
                <input name="btnSubmit" type="submit" class="btn btn-success col-md-4" style="border-radius: 13px; height: 45px;" value="Submit">
		  	</form>
		</div>
	</div>

	<script src="scripts/home.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>