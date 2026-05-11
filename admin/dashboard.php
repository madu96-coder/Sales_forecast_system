<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['admin']);

include __DIR__ . '/../dashboard_stats.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin dashboard</title>

    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css"
          rel="stylesheet">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>📊 Sales Forecast</h2>

    <a href="#">🏠 Dashboard</a>
    <a href="../sales.php">💰 Sales</a>
    <a href="../production_plan.php">📦 Production</a>
    <a href="../manage_inventory.php">📦 Inventory</a>
    <a href="../reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php"
       class="logout">

       🚪 Logout

    </a>

</div>

<!-- MAIN -->
<div class="main">

<?php if (!empty($_GET['access_denied'])): ?>

    <p class="alert-box">
        You do not have access to that page.
    </p>

<?php endif; ?>

<h2 class="dashboard-title">

    👑 Admin — Welcome,
    <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>

</h2>

<!-- =======================================
     TOP BIG CARDS
======================================= -->

<div class="top-grid">

    <div class="top-card top-blue">

        <h3>TOTAL SALES</h3>

        <p>
            Rs. <?php echo number_format($totalSales ?? 0, 2); ?>
        </p>

    </div>

    <div class="top-card top-purple">

        <h3>TOP PRODUCT</h3>

        <p>
            <?php echo htmlspecialchars($bestProduct['product_name'] ?? 'N/A'); ?>
        </p>

    </div>

    <div class="top-card top-green">

        <h3>THIS MONTH</h3>

        <p>
            Rs. <?php echo number_format($currentMonth['total'] ?? 0, 2); ?>
        </p>

    </div>

</div>

<!-- =======================================
     ACTION BUTTONS
======================================= -->

<div class="action-grid">

    <a href="../manage_users.php"
       class="action-card light-blue">

        <div>
            👥 Manage Users
        </div>

        <span>›</span>

    </a>

    <a href="../manage_category.php"
       class="action-card light-orange">

        <div>
            ⚙️ Manage System
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php"
       class="action-card light-red">

        <div>
            📈 View Forecast
        </div>

        <span>›</span>

    </a>

</div>

<!-- =======================================
     MAIN MENU
======================================= -->

<div class="action-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php"
       class="action-card light-blue">

        <div>
            📦 Production Plan
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php"
       class="action-card light-green">

        <div>
            🛒 Add New Sales
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php"
       class="action-card light-purple">

        <div>
            📊 View Sales History
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php"
       class="action-card light-orange">

        <div>
            📦 Manage Inventory
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php"
       class="action-card light-cyan">

        <div>
            📋 Reports
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php"
       class="action-card light-red">

        <div>
            🚪 Logout
        </div>

        <span>›</span>

    </a>

</div>

</div>

</body>

</html>
