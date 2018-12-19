<!DOCTYPE html>
<html>
<head>
    <title>Configuration</title>
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
                <h3>Edit Services</h3>
                <hr>
            </div>
        </div>
      </div>
      <div class="container">
        <form action="?action=setValue" method ="post">
          <table class="table borderless">
            <tr>
              <td>Service name</td>
              <td><input type="text" id="serviceName" name= "serviceName" required></td>
            </tr>
            <tr>
              <td>Set Price</td>
              <td><input type="number" id="price" name = "price" step="0.01" min=0 required></td>
            </tr>
            <tr><td></td></tr>
            <tr class="text-center">
              <td colspan="2"><input type="submit" class="btn btn-success col-md-4" style="border-radius: 13px; height: 45px;" value="Submit"></td>
            </tr>
          </table>
        </form>
      </div>
			<?php
				session_start();
				if(isset($_GET['action'])=='setValue') {
					setValues();
				}
				function setValues() {
					include_once 'db_config.php';
					$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
					$username = $_SESSION['name'];
					if($username =="admin"){
						$serviceName 	= $_POST["serviceName"];
						$price 			= $_POST["price"];
						$result = mysqli_query($con,"SELECT serviceDescription FROM services WHERE serviceDescription='$serviceName'");
						$row = mysqli_fetch_array($result);

						$amount = $row['serviceDescription']; 

						if($amount != ""){
							$sql 	= "UPDATE services SET amount='$price' WHERE serviceDescription='$serviceName'";
							if(mysqli_query($con, $sql)){
								echo '<div class="alert alert-success alert-dismissible" style="margin-top:5%;margin-bottom:5%;">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								Successfully updated
							</div>';	
							} else{
								echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
							}
						}else{
							echo '<div class="alert alert-danger alert-dismissible" style="margin-top:5%;margin-bottom:5%;">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								Invalid Service name. Please Check Again
							</div>';

						}	
					}
				}
		?>
    </div>
    <script src="scripts/home.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>