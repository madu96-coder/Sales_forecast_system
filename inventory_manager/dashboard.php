
<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['inventory_manager', 'admin']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Manager</title>
    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css" rel="stylesheet">
</head>
<body>

<?php if(isset($_SESSION['error'])): ?>
    <p class="alert-box"><?php echo $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- INVENTORY SIDEBAR -->
<div class="sidebar">
    <h2>📦 Inventory Panel</h2>

    <a href="../inventory_manager/dashboard.php">🏠 Dashboard</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php">➕ Manage Inventory</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/stock_level.php">📦 Stock Levels</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="logout">🚪 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<h2>📦 Inventory — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php" class="card">
        <h3>Manage Inventory</h3>
        <p>Add / update stock</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/stock_level.php" class="card">
        <h3>Stock Levels</h3>
        <p>View stock data</p>
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">
        <h3>Reports</h3>
        <p>Inventory reports</p>
    </a>

</div>

<div class="grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card">
        <h3>Logout</h3>
        <p>Exit system</p>
    </a>

</div>

</div>

</body>
</html>