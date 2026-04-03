<?php
include 'includes/auth.php';
checkRole(['admin', 'sales_manager', 'product_manager', 'inventory_manager']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>📊 Reports</h2>

    <?php if (in_array($_SESSION['role'], ['inventory_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="inventory_report.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📦 Inventory report
            </div>
        </a>
    </div>
    <?php endif; ?>

    <?php if (in_array($_SESSION['role'], ['sales_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="view_sales.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📈 Sales list
            </div>
        </a>
    </div>
    <?php endif; ?>

    <?php if (in_array($_SESSION['role'], ['product_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="forecast.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                🤖 Forecast
            </div>
        </a>
    </div>
    <?php endif; ?>

    <br>
    <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">⬅ Back to dashboard</a>

</div>

</body>
</html>