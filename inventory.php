<?php
// ================================
// AUTH + DB
// ================================
include 'includes/auth.php';
include 'includes/config.php';

// ================================
// ROLE CONTROL
// ================================
checkRole(['inventory_manager', 'product_manager', 'admin']);

/*
|--------------------------------------------------------------------------
| FETCH INVENTORY DATA (FIXED)
|--------------------------------------------------------------------------
| - Join product + inventory
| - Use inventory.stock_quantity (REAL STOCK)
| - Filter ONLY active products
| - Avoid using product.stock
*/
$result = mysqli_query($conn, "
SELECT 
    p.product_name,
    p.unit_price,
    COALESCE(i.stock_quantity, 0) AS stock
FROM product p
LEFT JOIN inventory i ON p.product_id = i.product_id
WHERE p.status = 'active'
ORDER BY p.product_name ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .out { color:#8B0000; font-weight:bold; }
        .low { color:red; font-weight:bold; }
        .medium { color:orange; font-weight:bold; }
        .good { color:green; font-weight:bold; }
    </style>
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
    <!-- PRODUCT -->
    <td><?= htmlspecialchars($row['product_name']); ?></td>

    <!-- PRICE -->
    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>

    <!-- STOCK -->
    <td>
        <?php
        $stock = (int)$row['stock']; // SAFE CAST

        // 🎯 IMPROVED STATUS LOGIC
        if($stock == 0){
            echo "<span class='out'>Out (0)</span>";
        }
        elseif($stock <= 10){
            echo "<span class='low'>Low ($stock)</span>";
        }
        elseif($stock <= 30){
            echo "<span class='medium'>$stock</span>";
        }
        else{
            echo "<span class='good'>$stock</span>";
        }
        ?>
    </td>
</tr>
<?php } ?>

</table>

<br>

<a href="<?= htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">
    ← Back to dashboard
</a>

</div>

</body>
</html>