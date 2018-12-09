<?php

session_start();

include_once 'db_config.php';

$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password']) ) {
	//die ('Username and/or password does not exist!');
}

if ($stmt = $con->prepare('SELECT userId, password FROM accounts WHERE username = ?')) {

	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute(); 
	$stmt->store_result(); 

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($userId, $password);
		$stmt->fetch();      

		if (password_verify($_POST['password'], $password)) {

			$_SESSION['loggedin']   = TRUE;
			$_SESSION['name']       = $_POST['username'];
			$_SESSION['userId']     = $userId;
            
            //echo 'Welcome ' . $_SESSION['name'] . '!';
			header('Location: index.php');
		} else {
            //echo 'Incorrect username and/or password!';
            //header('Location: login.php');
		}
	} else {
        //echo 'Incorrect username and/or password!';
        //header('Location: login.php');
	}
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

$_POST = array();

?>



<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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
                        <li class='drpItems'><a class='dropdown-item dropList' href='login.php'><span class='glyphicon glyphicon-credit-card'></span> Login</a></li>
						<li class='drpItems'><a class='dropdown-item dropList' href='register.php'><span class='glyphicon glyphicon-credit-card'></span> Signup</a></li>
                    </ul>
                </li>
                </ul>
            </div>

        </nav>
        <!-- -----------------------END OF NAVBAR------------------------->
        <div class="container text-center">
            <div class="form-signin">
                <!-- <img class="mb-4" src="images/logo.png" alt="logo" width="100" height="100"> -->
                <img class="mb-4" src="images/logo.png" alt="logo" width="100" height="100">
                <h1 class="h3 mb-3 font-weight-bold">Welcome</h1>
                <h4 class="h4 mb-4 font-weight-light">Sign in to continue</h4>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="inputEmail" class="sr-only">Username</label>
                <input type="name" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <div class="checkbox mb-3">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="loginBtn">Sign in</button>
                <p class="mt-5 mb-3 text-danger" id="loginStat" style="display:none;">Invalid Username/Password</p>
                </form>
                <!-- Footer -->
                <br>
                <footer class="page-footer font-small blue">
                    <div class="footer-copyright text-muted text-center py-3">© 2018 Copyright:
                        <a href="https://www.fiverr.com/s2/2eeb646318?utm_source=CopyLink_Mobile"> Shakye</a>
                    </div>
                </footer>
            </div>	
        </div>      

        <script src="scripts/home.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
