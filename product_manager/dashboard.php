<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['product_manager', 'admin']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Manager</title>

    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css"
          rel="stylesheet">
</head>

<body>

<?php if (!empty($_GET['access_denied'])): ?>

    <p class="alert-box">
        You do not have access to that page.
    </p>

<?php endif; ?>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>📦 Product Panel</h2>

    <a href="../product_manager/dashboard.php">
        🏠 Dashboard
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php">
        🏭 Production Plan
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php">
        📦 View Inventory
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php">
        📈 View Forecast
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php">
        📋 Reports
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php"
       class="logout">

       🚪 Logout

    </a>

</div>

<!-- MAIN -->
<div class="main">

<h2 class="dashboard-title">

    📦 Product Manager — Welcome,
    <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>

</h2>

<!-- =======================================
     TOP BIG CARDS
======================================= -->

<div class="top-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php"
       class="top-card top-purple">

        <h3>PRODUCTION PLAN</h3>

        <p>
            Production overview
        </p>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php"
       class="top-card top-blue">

        <h3>VIEW FORECAST</h3>

        <p>
            Check predictions
        </p>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php"
       class="top-card top-green">

        <h3>VIEW INVENTORY</h3>

        <p>
            View stock levels
        </p>

    </a>

</div>

<!-- =======================================
     ACTION BUTTONS
======================================= -->

<div class="action-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/production_plan.php"
       class="action-card light-purple">

        <div>
            🏭 Production Plan
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php"
       class="action-card light-blue">

        <div>
            📈 Forecast
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/inventory.php"
       class="action-card light-green">

        <div>
            📦 Inventory
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php"
       class="action-card light-orange">

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