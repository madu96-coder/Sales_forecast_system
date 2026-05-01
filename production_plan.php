<?php
include 'includes/auth.php';
include 'includes/config.php';

// ================================
// ROLE CONTROL
// ================================
checkRole(['admin', 'product_manager']);

// ================================
// FETCH MONTHS FOR DROPDOWN
// ================================
$months = mysqli_query($conn, "
SELECT DISTINCT forecast_month
FROM forecast
ORDER BY STR_TO_DATE(forecast_month, '%M %Y')
");

// ================================
// MONTH FILTER LOGIC
// ================================
$monthFilter = "";

if (!empty($_GET['month'])) {
    $month = mysqli_real_escape_string($conn, $_GET['month']);
    $monthFilter = "AND f.forecast_month = '$month'";
}

// ================================
// PREVIOUS MONTH CALCULATION
// ================================
$prevMonthSQL = "";

if (!empty($_GET['month'])) {

    $selectedMonth = $_GET['month']; // e.g. March 2026

    // Convert "March 2026" → date
    $dateObj = DateTime::createFromFormat('F Y', $selectedMonth);

    if ($dateObj) {
        $dateObj->modify('-1 month'); // go to previous month
        $prevMonth = $dateObj->format('Y-m'); // 2026-02

        $prevMonthSQL = "AND DATE_FORMAT(s.sales_date, '%Y-%m') = '$prevMonth'";
    }
}

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
    '" . ($_GET['month'] ?? 'No forecast') . "' AS forecast_month,

    IFNULL(SUM(s.quantity), 0) AS forecast,

    (
        SELECT IFNULL(SUM(i.stock_quantity), 0)
        FROM inventory i
        WHERE i.product_id = p.product_id
    ) AS stock

FROM product p
LEFT JOIN sales s ON s.product_id = p.product_id

WHERE p.status = 'active' $prevMonthSQL

GROUP BY p.product_id, p.product_name
ORDER BY p.product_name
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
<br>
<form method="GET">
    <label>Select Month:</label>
    <select name="month" onchange="this.form.submit()">
        <option value="">All Months</option>

        <?php
        // loop through months and display in dropdown
        while($m = mysqli_fetch_assoc($months)) {
            $value = $m['forecast_month'];
            $selected = (isset($_GET['month']) && $_GET['month'] == $value) ? 'selected' : '';
    
        
        ?>
        <option value="<?= htmlspecialchars($value); ?>" <?= $selected; ?>>
            <?= htmlspecialchars($value); ?>
        </option>
        <?php } ?>
    </select>
</form>

<table border="1" width="100%">
<tr>
    <th>Month</th>
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
    if($forecast == 0 && $stock == 0){
        $status = "No stock & No Forecast";
        $class = "status-danger";
    }
    elseif($needed == 0){
        $status = "Sufficient";
        $class = "status-ok";
    } else{
        $status = "Low Production Needed";
        $class = "status-warning";
    }
?>

<tr>
    <td><?= htmlspecialchars($row['forecast_month']??'No forecast'); ?></td>
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





<a href="<?= htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])) ?>">
    ← Back
</a>

</div>

</body>
</html>