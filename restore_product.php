<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin','inventory_manager']);

$id = $_GET['id'] ?? null;

if(!$id){
    die("Invalid ID");
}

// restore product
$sql = "UPDATE product SET status='active' WHERE product_id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: inactive_products.php?restored=1");
    exit();
}else{
    echo "Error: " . mysqli_error($conn);
}
?>