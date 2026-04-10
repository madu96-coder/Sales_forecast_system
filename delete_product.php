<?php

include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin','inventory_manager']);

$id = $_GET['id'] ?? null;

if(!$id){
    die("Invalid ID");
}

//check if product used in sales

$check = mysqli_query($conn, "SELECT *FROM sales WHERE product_id = $id");

//soft delete only
$sql = "UPDATE product SET status='inactive' WHERE product_id=$id";



if(mysqli_query($conn, $sql)){
    header("Location: products.php?deleted=1");
    exit();
}else{
    echo "Error deleting: " . mysqli_error($conn);
}
?>