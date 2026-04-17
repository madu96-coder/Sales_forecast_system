<?php
include 'includes/auth.php';
include 'includes/config.php';

// ================================
// ROLE CONTROL
// ================================
checkRole(['admin', 'product_manager']);

/*
|
| 
|
| - Avoid double counting
| - Use subqueries for forecast + stock
| - Filter ONLY active products
*/
$query = mysqli_query($conn, "
SELECT 
    p.product_id,
    p.product_name,

    -- TOTAL FORECAST (SAFE)
    (
        SELECT IFNULL(SUM(f.forecast_value), 0)
        FROM forecast f
        WHERE f.product_id = p.product_id
    ) AS forecast,

    -- CURRENT STOCK (SAFE)
    (
        SELECT IFNULL(SUM(i.stock_quantity), 0)
        FROM inventory i
        WHERE i.product_id = p.product_id
    ) AS stock

FROM product p
WHERE p.status = 'active'
ORDER BY p.product_name ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .status-ok { color: green; font-weight: bold; }
        .status-warning { color: orange; font-weight: bold; }
        .status-danger { color: red; font-weight: bold; }

        table { border-collapse: collapse; }
        th {
            background: #0f4c5c;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="login-box">

<h2>Production Plan</h2>

<table border="1" width="100%">
<tr>
    <th>Product</th>
    <th>Forecast</th>
    <th>Stock</th>
    <th>Production Needed</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($query)) { 

    // ================================
    // CALCULATION
    // ================================
    $forecast = (int)$row['forecast'];
    $stock = (int)$row['stock'];

    $needed = max(0, $forecast - $stock);

    // ================================
    // STATUS LOGIC
    // ================================
    if($needed == 0){
        $status = "Sufficient";
        $class = "status-ok";
    } elseif($needed <= 20){
        $status = "Low Production Needed";
        $class = "status-warning";
    } else {
        $status = "High Production Needed";
        $class = "status-danger";
    }
?>

<tr>
    <td><?= htmlspecialchars($row['product_name']); ?></td>

    <td><?= $forecast; ?></td>

    <td><?= $stock; ?></td>

    <td class="<?= $class; ?>">
        <?= $needed; ?>
    </td>

    <td class="<?= $class; ?>">
        <?= $status; ?>
    </td>
</tr>

<?php } ?>

</table>

<br>

<!-- PRINT REPORT -->
<button onclick="window.print()" 
style="padding:10px 20px; background:#0f4c5c; color:white; border:none; border-radius:5px;">
    🖨️ Generate Report
</button>

<br><br>

<a href="<?= htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])) ?>">
    ← Back
</a>

</div>

</body>
</html>