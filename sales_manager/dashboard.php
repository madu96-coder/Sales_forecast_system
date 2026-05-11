<?php
include __DIR__ . '/../includes/auth.php';
checkRole(['sales_manager', 'admin']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sales Manager</title>

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

    <h2>💹 Sales Panel</h2>

    <a href="#">🏠 Dashboard</a>
    <a href="../sales.php">💰 Sales</a>
    <a href="../view_sales.php">📊 View Sales History</a>
    <a href="../forecast.php">📈 View Forecast</a>
    <a href="../reports.php">📋 Reports</a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/logout.php"
       class="logout">

       🚪 Logout

    </a>

</div>

<!-- MAIN -->
<div class="main">

<h2 class="dashboard-title">

    💰 Sales Manager — Welcome,
    <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>

</h2>

<!-- =======================================
     TOP BIG CARDS
======================================= -->

<div class="top-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php"
       class="top-card top-green">

        <h3>SALES</h3>

        <p>
            Add new sales
        </p>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php"
       class="top-card top-blue">

        <h3>VIEW SALES HISTORY</h3>

        <p>
            Check sales records
        </p>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php"
       class="top-card top-purple">

        <h3>VIEW FORECAST</h3>

        <p>
            Check predictions
        </p>

    </a>

</div>

<!-- =======================================
     ACTION BUTTONS
======================================= -->

<div class="action-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/reports.php"
       class="action-card light-orange">

        <div>
            📋 Reports
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/sales.php"
       class="action-card light-green">

        <div>
            💰 Add Sales
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/view_sales.php"
       class="action-card light-blue">

        <div>
            📊 Sales History
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/forecast.php"
       class="action-card light-purple">

        <div>
            📈 Forecast
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