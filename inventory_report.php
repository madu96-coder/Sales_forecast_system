<?php
include 'includes/auth.php';
checkRole(['inventory_manager', 'admin']);

// search feature
$search = "";

if(isset($_GET['search'] ) && $_GET['search'] != "" ){
    $search = mysqli_real_escape_string($conn, $_GET['search'] );


// filter query (replace old query)
$sql = "SELECT product_name, unit_price, stock FROM product WHERE product_name LIKE '%$search%'
ORDER BY product_name ASC";

}else { $sql = "SELECT product_name, unit_price, stock FROM product ORDER BY product_name ASC";

}
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>📦 Inventory Report</h2>

    <table border="1" width="100%" cellpadding="10">
        <tr style="background:#007bff; color:white;">
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
        </tr>

        <tbody id="tableBody">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <!-- product name -->
    <td><?= $row['product_name']; ?></td>

    <!-- price -->
    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>

    <!-- stock -->
    <td><?= $row['stock']; ?></td>

    <!-- status -->
    <td>
        <?php
        $stock = (int)$row['stock']; // convert to number

        if($stock == 0){
            echo "<span style='color:red;'>Out of Stock</span>";
        }
        elseif($stock <= 10){
            echo "<span style='color:orange;'>Low Stock</span>";
        }
        else{
            echo "<span style='color:green;'>In Stock</span>";
        }
        ?>
    </td>
</tr>

<?php } ?>

</tbody>
       

    </table>

    <br>
    <a href="reports.php">⬅ Back to Reports</a>

</div>


</body>
</html>