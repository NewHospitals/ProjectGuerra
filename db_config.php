<?php
define("HOST", "localhost");           
define("USER", "guerra_user");              
define("PASSWORD", "123456");  
define("DATABASE", "projectguerra");     
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);   

$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>