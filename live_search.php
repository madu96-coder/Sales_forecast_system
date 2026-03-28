<?php
include "config.php";

$search = "";

if(isset($_GET['q'])){
    $search = mysqli_real_escape_string($conn, $_GET['q']);
}

$sql = "SELECT product_name, unit_price, stock 
        FROM product 
        WHERE product_name LIKE '%$search%' 
        ORDER BY product_name ASC";

$result = mysqli_query($conn, $sql);

//  STORE OUTPUT
$suggestions = "";
$table = "";

while($row = mysqli_fetch_assoc($result)){

    $stock = (int)$row['stock'];

    if($stock == 0){
        $status = "<span style='color:red;'>Out of Stock</span>";
    } elseif($stock <= 10){
        $status = "<span style='color:orange;'>Low Stock</span>";
    } else {
        $status = "<span style='color:green;'>In Stock</span>";
    }

    //  suggestions list
    $suggestions .= "<div class='item'>".$row['product_name']."</div>";

    //  table rows
    $table .= "<tr>
        <td>".$row['product_name']."</td>
        <td>Rs. ".number_format($row['unit_price'],2)."</td>
        <td>".$row['stock']."</td>
        <td>".$status."</td>
    </tr>";
}

//  RETURN JSON
echo json_encode([
    "suggestions" => $suggestions,
    "table" => $table
]);