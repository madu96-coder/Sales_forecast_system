<?php
include __DIR__ . '/includes/auth.php';
include __DIR__ . '/includes/config.php';

checkRole(['admin', 'inventory_manager']);

// Fetch inventory
$result = mysqli_query($conn, "
SELECT 
    p.product_name,
    p.unit_price,
    COALESCE(i.stock_quantity, 0) AS stock
FROM product p
LEFT JOIN inventory i ON p.product_id = i.product_id
ORDER BY p.product_name ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <link rel="stylesheet" href="<?php echo APP_BASE; ?>/style.css">
</head>

<body>

<div class="login-box">

<h2>📦 Inventory Report</h2>

<button class="no-print" onclick="window.print()">🖨 Print</button>
<!-- when generate report it doesnt show any shadow or hidden element -->

<table border="1" width="100%" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Stock</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>
    <td><?= $row['stock']; ?></td>
</tr>
<?php } ?>

</table>

<br>

<a href="<?php echo APP_BASE; ?>/reports.php" class="no-print">⬅ Back</a> <!-- when generate report it doesnt show any shadow or hidden element --  >

</div>

</body>
</html>