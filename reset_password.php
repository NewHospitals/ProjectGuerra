<?php

session_start();
    
$token=$_GET['token'];
echo $_GET['token'];

include_once 'db_config.php';
$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

/*
$email = '';
$password = '';*/

if(!isset($_POST['password'])){
    $token=$_GET['token'];
    $query="SELECT email FROM tokens WHERE token='".$token."'";
    $result=mysqli_query($con,$query);
    while($row=mysqli_fetch_array($result)){
        $email=$row['email'];
    }

    if($email!=''){
        $_SESSION['email']=$email;
    }
}else{ 
    //die("Invalid link or Password already changed");
}



if(isset($_POST['password']) && isset($_SESSION['email'])){
    echo "in -----------> in";
    $email=$_SESSION['email'];

    $x 		= ($_POST["password"]);
    $password = password_hash($x, PASSWORD_DEFAULT);
    
    $query2="UPDATE accounts set password='".$password."' WHERE email='".$email."'";
    $result2=mysqli_query($con,$query2);
    if($result2){
        //mysqli_query("UPDATE tokens set used=1 where token='".$token."'");
        mysqli_query("DELETE FROM tokens WHERE token='".$token."'");
        echo "Your password is changed successfully";
    }else{
        echo "An error occurred";
    }
}

?>


<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <form method="post">
        <input type="password" id="password" placeholder="password" name="password"/>
        <!--<input type="password" id="cpassword" placeholder="confirm password" name="cpassword"/>-->
        <input type="submit" value="SUBMIT"/>
    </form>
</body>
</html>
