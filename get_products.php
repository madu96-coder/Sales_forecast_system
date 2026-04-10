<?php
include 'includes/auth.php';
checkRole(['sales_manager', 'admin']);

// get category id from ajax
$category_id = $_GET['category_id'];

// fetch products under selected category
$result = mysqli_query($conn,"SELECT * FROM product WHERE category_id='$category_id'");

// loop products and send as option
while($row = mysqli_fetch_assoc($result)){
    echo "<option value='".$row['product_id']."' data-price='".$row['unit_price']."'>"
    .$row['product_name']."</option>";
}
?>