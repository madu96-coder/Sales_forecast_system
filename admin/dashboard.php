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

<?php if (!empty($_GET['access_denied'])): ?>
    <p class="alert-box">You do not have access to that page.</p>
<?php endif; ?>

<h2>Admin — Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>

<div class="container">

<div class="card">
    <h3>Total Sales</h3>
    <p>Rs. <?php echo number_format($totalSales ?? 0, 2); ?></p> <!-- take value from db if empty use 0/and number format= make it money-->
</div>

<div class="card">
    <h3>Top Product</h3>
    <p><?php echo htmlspecialchars($bestProduct['product_name'] ?? 'N/A'); ?></p> <!-- show product if missing show N/A-->
</div>

<div class="card">
    <h3>This Month</h3>
    <p>Rs. <?php echo number_format($currentMonth['total'] ?? 0, 2); ?></p> <!-- if empty show 0-->
</div>

<div class="dashboard-graphs">


    <div class="card">
        <a href="../manage_users.php">
            <i class="fa fa-users"></i>
            <p> 👥 Manage Users</p>
        </a>

    </div>

    <div class="card">
        <a href="../manage_category.php" style="text-decoration:none; color:inherit;">
        <i class="fa fa-cogs"></i> <!--icon tag/put icon infront of topic-->
        <p> ⚙️ Manage System</p>
        </a>

    </div>

</div>


</div>

<div class="container menu">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php" class="card">📦 Production plan</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php" class="card">💰 Sales</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php" class="card">📈 Forecast</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php" class="card">📊 View sales</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php" class="card"> ➕Manage Inventory</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php" class="card">📋 Reports</a>
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php" class="card logout-btn">🚪 Logout</a>

</div>




</body>
</html>
