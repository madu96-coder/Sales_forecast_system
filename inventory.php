<?php
include 'includes/auth.php';//auth-control user roles

include 'includes/config.php'; //db connect

//only inventory manger + admin allowed
checkRole(['inventory_manager', 'product_manager', 'admin']);

// get products
$result = mysqli_query($conn, "SELECT * FROM product");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">

<h2>📦 Inventory</h2>

<table border="1" width="100%" cellpadding="10">

<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Stock</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $row['product_name']; ?></td>
    <td>Rs. <?= $row['unit_price']; ?></td>

    <!--add stock into inventory-->
    <td>
        <?php
         // get stock safely
             $stock = $row['stock'] ?? 0;

          //  LOW STOCK (<=10)
            if($stock <= 10){
              echo "<span style='color:red; font-weight:bold;'>Low ($stock)</span>";
}
            //  MEDIUM STOCK (11–30)
              elseif($stock <= 30){
               echo "<span style='color:orange;'>$stock</span>";
}
             //  GOOD STOCK (>30)
            else{
                 echo "<span style='color:green;'>$stock</span>";
}
?>





    </td>
    
</tr>
<?php } ?>

</table>
<br>
<a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">Back to dashboard</a>

</div>

</body>
</html>