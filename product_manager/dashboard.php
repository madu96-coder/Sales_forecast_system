
<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['product_manager', 'admin']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Manager</title>
    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css" rel="stylesheet">
</head>
<body>

<?php if (!empty($_GET['access_denied'])): ?>
    <p class="alert-box">You do not have access to that page.</p>
<?php endif; ?>

<!-- PRODUCT MANAGER SIDEBAR -->
<div class="sidebar">
    <h2>📦 Product Panel</h2>

    <a href="../product_manager/dashboard.php">🏠 Dashboard</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php">🏭 Production Plan</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php">📦View Inventory</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php">📈View Forecast</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="logout">🚪 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<h2>📦 Products & Forecast — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<!-- GRID LAYOUT -->
<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php" class="card">
        <h3>Production Plan</h3>
        <p>Manage production</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php" class="card">
        <h3>Forecast View</h3>
        <p>Check predictions</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php" class="card">
        <h3>Inventory View</h3>
        <p>View stock levels</p>
    </a>

</div>

<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">
        <h3>Reports</h3>
        <p>View reports</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card">
        <h3>Logout</h3>
        <p>Exit system</p>
    </a>

</div>

</div>

</body>
</html>