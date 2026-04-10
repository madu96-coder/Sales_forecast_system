<?php
// ONLY database connection (no auth here)
include 'includes/config.php';

// check if product_id is provided
if(isset($_GET['product_id']) && !empty($_GET['product_id'])){

    // convert to integer for safety
    $product_id = (int) $_GET['product_id'];

    // query database
    $sql = "SELECT unit_price FROM product WHERE product_id = $product_id";

    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        // return price
        echo $row['unit_price'];
    } else {
        echo ""; // no product found
    }

} else {
    echo ""; // no id provided
}
?>