<?php
include __DIR__ . '/../includes/auth.php';
include __DIR__ . '/../includes/config.php';

checkRole(['inventory_manager', 'admin']);

// =============================
// TOTAL PRODUCTS
// =============================

$totalProductsQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM product
");

$totalProductsData = mysqli_fetch_assoc($totalProductsQuery);

$totalProducts = $totalProductsData['total'];


// =============================
// LOW STOCK PRODUCTS
// =============================

$lowStockQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS low_stock
    FROM inventory
    WHERE stock_quantity <= 100
");

$lowStockData = mysqli_fetch_assoc($lowStockQuery);

$lowStock = $lowStockData['low_stock'];


// =============================
// OUT OF STOCK PRODUCTS
// =============================

$outStockQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS out_stock
    FROM inventory
    WHERE stock_quantity = 0
");

$outStockData = mysqli_fetch_assoc($outStockQuery);

$outStock = $outStockData['out_stock'];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Inventory Manager</title>

    <link href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css?v=1.1"
          rel="stylesheet">

</head>

<body>

<?php if(isset($_SESSION['error'])): ?>

    <p class="alert-box">
        <?php echo $_SESSION['error']; ?>
    </p>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>🧾 Inventory Panel</h2>

    <a href="../inventory_manager/dashboard.php">
        🏠 Dashboard
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php">
        📦 Manage Inventory
    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/stock_level.php">
        📈 Stock Levels
    </a>
    
    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_supplier.php">
         🚚 Manage Supplier
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

    📦 Inventory Manager — Welcome,
    <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>

</h2>

<!-- =======================================
     TOP BIG CARDS
======================================= -->

<div class="top-grid">

    <div class="top-card top-blue">

        <h3>TOTAL PRODUCTS</h3>

        <p>
            <?php echo $totalProducts; ?>
        </p>

    </div>

    <div class="top-card top-orange">

        <h3>LOW STOCK</h3>

        <p>
            <?php echo $lowStock; ?>
        </p>

    </div>

    <div class="top-card top-red">

        <h3>OUT OF STOCK</h3>

        <p>
            <?php echo $outStock; ?>
        </p>

    </div>

</div>

<!-- =======================================
     ACTION BUTTONS
======================================= -->

<div class="action-grid">

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_inventory.php"
       class="action-card light-green">

        <div>
            📦 Manage Inventory
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/stock_level.php"
       class="action-card light-purple">

        <div>
            📈 Stock Levels
        </div>

        <span>›</span>

    </a>

    <a href="<?php echo htmlspecialchars(APP_BASE); ?>/manage_supplier.php"
   class="action-card light-yellow">

    <div>
        🚚 Manage Suppliers
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