<?php

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








/*send

function sendEmail ($recipient, $hash) {
    $to = $recipient;
    $subject = "Reset Your Password | ProjectGuerra";
    $message = '

        Did you just forget your password ?
        No worries! It is just too easy to get a new one.
        Please click this link to reset your password.
        https://projectguerra.000webhostapp.com/unlock/reset-password.php?email='.$to.'&hash='.$hash.'

        '; 

        $headers = 'From:noreply@projectguerra.000webhostapp.com' . "\r\n"; 
        mail($to, $subject, $message, $headers);        
}*/


/*
$to = 'dilina.desilva@gmail.com';
$hash = '123456';

$sender = 'noreply@projectguerra.000webhostapp.com';
$recipient = 'dilina.desilva@gmail.com';

$subject = "Reset Your Password";
$message = "

        Did you just forget your password ?
        No worries! It is just too easy to get a new one.
        Please click this link to reset your password.
        https://projectguerra.000webhostapp.com/unlock/reset-password.php?email='.$to.'&hash='.$hash.'

        ";


$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}*/

?>



<html>
<head>
    <title>Forgot Your Password</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="email" id="email" name="email"/>
        <button type="submit">SUBMIT</button>
    </form>
</body>
</html>
