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

<h2>Sales — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="container menu">
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php" class="card">💰 Sales entry</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php" class="card">📊 View sales</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php" class="card">📈 Adjust forecast</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">📋 Reports</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card logout-btn">🚪 Logout</a>
</div>

</body>
</html>
