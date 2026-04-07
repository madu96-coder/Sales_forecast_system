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

<?php if (!empty($_GET['access_denied'])): ?>
    <p class="alert-box">You do not have access to that page.</p>
<?php endif; ?>

<h2>Inventory — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="container menu">
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/add_stock.php" class="card">➕ Add Stock</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php" class="card">📦 Stock levels</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory_report.php" class="card">📋 Inventory report</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card logout-btn">🚪 Logout</a>
</div>

</body>
</html>
