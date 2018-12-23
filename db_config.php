<?php

define("HOST", "localhost");           
define("USER", "root");              
define("PASSWORD", "");  
define("DATABASE", "guerra");     
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);       
$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}      
?>