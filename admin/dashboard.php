<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['admin']);

include __DIR__ . '/../dashboard_stats.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin dashboard</title>
    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <h2>📊 Sales Forecast</h2>

    <a href="#">🏠 Dashboard</a>
    <a href="../sales.php">💰 Sales</a>
    <a href="../production_plan.php">📦 Production</a>
    <a href="../manage_inventory.php">📦 Inventory</a>
    <a href="../reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="logout">🚪 Logout</a>
</div>

<div class="main">

<?php if (!empty($_GET['access_denied'])): ?>
    <p class="alert-box">You do not have access to that page.</p>
<?php endif; ?>

<h2>Admin — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<!-- TOP CARDS -->
<div class="grid">

    <div class="card">
        <h3>Total Sales</h3>
        <p>Rs. <?php echo number_format($totalSales ?? 0, 2); ?></p>
    </div>

    <div class="card">
        <h3>Top Product</h3>
        <p><?php echo htmlspecialchars($bestProduct['product_name'] ?? 'N/A'); ?></p>
    </div>

    <div class="card">
        <h3>This Month</h3>
        <p>Rs. <?php echo number_format($currentMonth['total'] ?? 0, 2); ?></p>
    </div>

</div>

<!-- ACTION CARDS -->
<div class="grid">

    <div class="card">
        <a href="../manage_users.php">👥 Manage Users</a>
    </div>

    <div class="card">
        <a href="../manage_category.php">⚙️ Manage System</a>
    </div>

    <div class="card">
        <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php">📈 Forecast</a>
    </div>

</div>

<!-- MENU CARDS -->
<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php" class="card">📦 Production plan</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php" class="card">💰 Sales</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php" class="card">📊 View sales</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php" class="card">➕ Inventory</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">📋 Reports</a>

</div>

</div>

</body>

</html>
