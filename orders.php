<?php
session_start();
include_once 'db_config.php';
$userLogin;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$userLogin = true;
} else {
	$userLogin = false;
}
if(!$userLogin){
    header("Location:login.php");
}else{
    $user = '';
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Orders</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Sign up</title>
        <!-- Bootstrap Stylesheet -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="stylesheets/glyphicon.css">
        <!-- Custom Stylesheet -->
        <link rel="stylesheet" type="text/css" href="stylesheets/style.css">

        <style>
            body{
                overflow:scroll;
            }
        </style>
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
                    <a class="nav-link" href="https://guerrasenterprises.com/">Home <span class="sr-only">(current)</span></a>
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
                    <?php if(isset($_SESSION['name'])){
						echo $_SESSION['name'];
					}else{
						echo "User";
					} 
					?>
                      <span class="glyphicon glyphicon-user" ></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="drpItems"><a class="dropdown-item dropList" href="wallet.php"><span class="glyphicon glyphicon-credit-card"></span> Wallet</a></li>
                      <li class="drpItems"><a class="dropdown-item dropList" href="account.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                      <li class="drpItems"><a class="dropdown-item dropList" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
    
        </nav>
        <!-- -----------------------END OF NAVBAR------------------------->
        <div class="container">
            <br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Your Orders</h3>
                        <hr>
                    </div>
                </div>
            </div>
            <!-- Order Table -->
            <div class="container">
                <div class="row">
                    <table class="table borderless">
                        <tr>
                            <th><span class="labels">Date</th>
                            <th><span class="labels">IMEI</th>
                            <th><span class="labels">Service</th>
                            <th><span class="labels">Amount</th>
                            <th><span class="labels">Status</th>
                        </tr>

    <?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }


        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page; 

        $total_pages_sql = "SELECT COUNT(*) from orders WHERE userId='".$user."'";
        $result = mysqli_query($con,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if (isset($_SESSION['loggedin']) && $_SESSION['userId']) {
            $user = $_SESSION['userId'];
            //$query ="SELECT IMEI,serviceId,amount from orders WHERE userId='".$user."'";
            $query ="SELECT timestamp,IMEI,(SELECT serviceDescription FROM services WHERE serviceValue = orders.serviceId) AS serviceName,amount,orderStatus,orderSummary FROM orders WHERE userId='".$user."'LIMIT $offset, $no_of_records_per_page";
            $result = mysqli_query($con,$query);

            $orders = array();
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    //echo "id: " . $row["IMEI"]. " - Name: " . $row["serviceId"]. " " . $row["amount"]. "<br>";
                    //$orders[] = array('IMEI' => $row['IMEI'], 'serviceId' => $row['serviceId'], 'amount' => $row['amount'] );
                
                    echo'<tbody>';
                        echo'<tr>';
                                echo'<td>'. $row['timestamp']."</td>"; 
                                echo'<td>'. $row['IMEI']."</td>";
                                echo'<td>'. $row['serviceName'].'</td>';
                                echo'<td>'. $row['amount'].'</td>';
                                echo'<td>'. $row['orderStatus'].'</td>';
                                echo '<tr><td colspan=5 class="text-center">'. $row['orderSummary'].'</td></tr>';
                        echo'<tr>';
                    echo'</tbody>';
                
                
                }
            } else {
                echo "0 results";
            }    
        }


    ?>                
                    </table>
                    <br>
                </div>
            </div>
            <div class="container text-center">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><span class="glyphicon glyphicon-chevron-left"></span>Previous</a>
                </li>
                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>;">Next<span class="glyphicon glyphicon-chevron-right"></span></a>
                </li>
            </ul>
        </div>
        </div>
        <br><br>
        <script src="scripts/home.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>