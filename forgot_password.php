<?php

session_start();

$userLogin;

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$userLogin = true;
} else {
	$userLogin = false;
}

include_once 'db_config.php';

$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$email = "";

if(isset($_GET['email'])) {
    $email=$_GET['email'];

    $query1 ="SELECT email from accounts WHERE email='".$email."'";
    $result = mysqli_query($con,$query1);
    $no = mysqli_num_rows($result);

    if($no==0){
        echo "Email id is not registered";
        die();
    }else if($no==1){
        $token=getRandomString(20);
        $query2="INSERT INTO tokens (email,token) VALUES ('".$email."','".$token."')";
        if(mysqli_query($con,$query2)){
            mailresetlink($email,$token);
        };
    }
}

function getRandomString($length) {
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
    $validCharNumber = strlen($validCharacters);
    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
    return $result;
}


function mailresetlink($to,$token){
    $subject = "Reset Your Password";
    $uri = 'https://'. $_SERVER['HTTP_HOST'] ;
    $message = '
    <html>
    <head>
    <title>Forgot Password For unlock.guerraenterprises.com</title>
    </head>
        <body>
        <p>Click on the given link to reset your password <a href="'.$uri.'/reset.php?token='.$token.'">Reset Password</a></p>
        </body>
    </html>
    ';

    /*
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= 'From: Admin<webmaster@example.com>' . "\r\n";
    $headers .= 'Cc: Admin@example.com' . "\r\n";
    */

    $headers = 'From:noreply@projectguerra.000webhostapp.com' . "\r\n";

    if(mail($to,$subject,$message,$headers)){
	    echo "We have sent the password reset link to your  email id <b>".$to."</b>"; 
    }else{
        echo "Error: Message not accepted";
    }

}

?>



<html>
<head>
    <title>Forgot Your Password</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Home</title>
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
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
					<li class='drpItems'><a class='dropdown-item dropList' href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
					<li class='drpItems'><a class='dropdown-item dropList' href='register.php'><span class='glyphicon glyphicon-pencil'></span> Signup</a></li>
				<?php } ?>
		        </ul>
		      </li>
		    </ul>
	  	</div>

	</nav>
	<!-- -----------------------END OF NAVBAR------------------------->
    <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="email" id="email" name="email"/>
        <button type="submit">SUBMIT</button>
    </form> -->

    <br><br>
    <div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Reset Password</h3>
                <hr>
            </div>
        </div>
    </div>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table borderless">
                <tr>
                    <td>Enter your e-mail address</td>
                    <td><input type="email" id="email" name="email" required/></td>
                </tr>
                <tr><td></td></tr>
                <tr class="text-center">
                <td colspan="2"><input type="submit" class="btn btn-success col-md-4" style="border-radius: 13px; height: 45px;" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
    </div>

    <script src="scripts/home.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
