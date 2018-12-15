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
        <title>Wallet</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Sign up</title>
        <!-- Bootstrap Stylesheet -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
        <!-- Custom Stylesheet -->
        <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
    </head>
    <body>
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
					<li class="drpItems"><a class="dropdown-item dropList" href="wallet.php"><span class="glyphicon glyphicon-credit-card"></span> Wallet</a></li>
		          	<li class="drpItems"><a class="dropdown-item dropList" href="account.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
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
        <br><br>
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Your wallet</h3>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div style="background-color:white; width: 50%; position: relative; left: 25%;">
                        <br>
                        <h5>Balance : </h5>
                        <br>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Add funds</h3>
                        <hr>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="HMNTC78P7Z4F6">
                            <input type="hidden" name="on0" value="Amount">Amount
                            <select name="os0">
                            <option value="Option 1">Option 1 $10.00 USD</option>
                            <option value="Option 2">Option 2 $25.00 USD</option>
                            <option value="Option 3">Option 3 $50.00 USD</option>
                            <option value="Option 4">Option 4 $100.00 USD</option>
                            </select> 
                            <br><br>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/home.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    </body>
</html>