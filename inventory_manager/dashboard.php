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



<h2>Inventory — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="container menu">
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php" class="card">➕ Manage Inventory</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/stock_level.php" class="card">📦 Stock levels</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">📋 Report</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card logout-btn">🚪 Logout</a>
</div>

</body>
</html>
