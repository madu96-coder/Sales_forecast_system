<?php 

//connect to mysql database
$conn = mysqli_connect("localhost","root","","sales_forecast");

// check if connection failed
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());

}

// if successful, connection is ready to use
?>