<?php
include __DIR__ . '/includes/auth.php';
checkRole(['admin', 'sales_manager', 'product_manager', 'inventory_manager']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <!-- FIX CSS -->
    <link rel="stylesheet" href="<?php echo APP_BASE; ?>/style.css">
</head>

<body>

<div class="login-box">

    <h2>📊 Reports</h2>

    <!-- INVENTORY -->
    <?php if (in_array($_SESSION['role'], ['inventory_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="<?php echo APP_BASE; ?>/inventory_report.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📦 Inventory report
            </div>
        </a>
    </div>
    <?php endif; ?>

    <!-- SALES -->
    <?php if (in_array($_SESSION['role'], ['sales_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="<?php echo APP_BASE; ?>/sales_report.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📈 Sales report
            </div>
        </a>
    </div>
    <?php endif; ?>

    <!-- PRODUCTION -->
    <?php if (in_array($_SESSION['role'], ['product_manager', 'admin'], true)): ?>
    <div style="margin:20px 0;">
        <a href="<?php echo APP_BASE; ?>/production_report.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📋 Production plan report
            </div>
        </a>
    </div>
    <?php endif; ?>

    <br>

    <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">
        ⬅ Back to dashboard
    </a>

</div>

</body>
</html>