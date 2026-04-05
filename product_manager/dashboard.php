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

<h2>Products &amp; forecast — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="container menu">
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/products.php" class="card">📦 Products</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php" class="card">🏭 production plan</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php" class="card">📈 Forecast</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php" class="card">📦 Inventory view</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">📋 Reports</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card logout-btn">🚪 Logout</a>
</div>

</body>
</html>
