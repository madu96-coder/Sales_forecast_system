<?php
include("config.php");

// get product id
$product_id = $_GET['product_id'];

// get price from database
$sql = "SELECT unit_price FROM product WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

// return price
echo $row['unit_price'];
?>