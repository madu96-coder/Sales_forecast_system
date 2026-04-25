<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['sales_manager', 'admin']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Manager</title>
    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css" rel="stylesheet">
</head>
<body>

<?php if (!empty($_GET['access_denied'])): ?>
    <p class="alert-box">You do not have access to that page.</p>
<?php endif; ?>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>📊 Sales Forecast</h2>

    <a href=>🏠 Dashboard</a>
    <a href="../sales.php">💰 Sales</a>
    <a href="../view_sales.php">📊 View Sales</a>
    <a href="../forecast.php"> 📈Adjust forecast</a>
    <a href="../reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="logout">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h2>💰 Sales — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<!-- TOP ACTION CARDS -->
<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php" class="card">
        <h3>Sales Entry</h3>
        <p>Add new sales</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php" class="card">
        <h3>View Sales</h3>
        <p>Check sales records</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php" class="card">
        <h3>Adjust Forecast</h3>
        <p>Update predictions</p>
    </a>

</div>

<!-- SECOND ROW -->
<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">
        <h3>Reports</h3>
        <p>Generate reports</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card">
        <h3>Logout</h3>
        <p>Exit system</p>
    </a>

</div>

</div>

</body>
</html>