<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin','inventory_manager']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">
    <h2>Manage Inventory</h2>

    <!-- Add Stock -->
    <div class="card">
        <a href="add_stock.php">
            <p>➕ Add Stock</p>
        </a>
    </div>

    <!-- View Products -->
    <div class="card">
        <a href="manage_products_inventory.php">
            <p>📦 Manage Products</p>
        </a>
    </div>

    <!--view inventory-->
    <div class="card">
        <a href="view_inventory.php">
            <p>📋  View Inventory</p>
        </a>

    </div>

    <br>
    <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])) ?>">← Back    </a>
    
</div>

</body>
</html>