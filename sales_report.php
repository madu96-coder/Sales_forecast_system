<?php
include __DIR__ . '/includes/auth.php';
include __DIR__ . '/includes/config.php';

checkRole(['admin', 'sales_manager']);

$result = mysqli_query($conn, "
SELECT 
    p.product_name,
    s.quantity,
    (s.quantity * p.unit_price) AS total_price,
    s.sales_date
FROM sales s
INNER JOIN product p ON s.product_id = p.product_id
ORDER BY s.sales_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <link rel="stylesheet" href="<?php echo APP_BASE; ?>/style.css">
</head>

<body>

<div class="login-box">

<h2>📈 Sales Report</h2>

<button class="no-print" onclick="window.print()">🖨 Print</button>

<table border="1" width="100%" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td><?= $row['quantity']; ?></td>
    <td>Rs. <?= number_format($row['total_price'], 2); ?></td>
    <td><?= $row['sales_date']; ?></td>
</tr>
<?php } ?>

</table>

<br>

<a href="<?php echo APP_BASE; ?>/reports.php" class="no-print">⬅ Back</a>

</div>

</body>
</html>