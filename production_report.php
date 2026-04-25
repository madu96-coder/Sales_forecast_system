<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/config.php';

checkRole(['admin', 'product_manager']);

/*
|
| FETCH PRODUCTION DATA
|
| - Forecast demand
| - Current inventory stock
| - Calculate production needed
*/
$result = mysqli_query($conn, "
SELECT 
    p.product_name,
    COALESCE(SUM(f.forecast_value), 0) AS forecast_qty,
    COALESCE(i.stock_quantity, 0) AS current_stock,
    (COALESCE(SUM(f.forecast_value), 0) - COALESCE(i.stock_quantity, 0)) AS production_needed
FROM product p
LEFT JOIN forecast f ON p.product_id = f.product_id
LEFT JOIN inventory i ON p.product_id = i.product_id
GROUP BY p.product_id
ORDER BY p.product_name ASC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Production Report</title>

    <!-- SAFE CSS PATH -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css">
</head>

<body>

<div class="login-box">

<h2>📋 Production Report</h2>

<button class="no-print" onclick="window.print()">🖨 Print</button>
<!-- when generate report it doesnt show any shadow or hidden element -->
<br><br>

<table border="1" width="100%" cellpadding="10">

<tr>
    <th>Product</th>
    <th>Forecast</th>
    <th>Stock</th>
    <th>Production Needed</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td><?= $row['forecast_qty']; ?></td>
    <td><?= $row['current_stock']; ?></td>
    <td>
        <?php 
        $needed = (int)$row['production_needed'];

        if($needed <= 0){
            echo "<span style='color:green;'>Sufficient</span>";
        } else {
            echo "<span style='color:red;'>$needed</span>";
        }
        ?>
    </td>
</tr>
<?php } ?>

</table>

<br>

<a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php " class="no-print">⬅ Back</a> <!-- when generate report it doesnt show any shadow or hidden element -->

</div>

</body>
</html>