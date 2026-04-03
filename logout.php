<?php  

session_start(); //start session

//destroy session (logout)
session_destroy();

//redirect to login page
header("Location: login.php");
exit();

?>