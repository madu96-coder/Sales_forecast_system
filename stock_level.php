<?php
// ================================
// AUTH + DB
// ================================
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['inventory_manager', 'admin','product_manager']);

// ================================
// SEARCH INPUT
// ================================
$search = "";

if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// ================================
// STOCK QUERY
// - Uses inventory table
// - Filters ONLY active products
// ================================
$sql = "
SELECT 
    p.product_name,
    p.unit_price,
    COALESCE(i.stock_quantity, 0) AS stock
FROM product p
LEFT JOIN inventory i ON p.product_id = i.product_id
WHERE p.status = 'active'
";

// APPLY SEARCH IF EXISTS
if(!empty($search)){
    $sql .= " AND p.product_name LIKE '%$search%'";
}

// ORDER
$sql .= " ORDER BY p.product_name ASC";

// RUN QUERY
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock levels</title>
    <link rel="stylesheet" href="style.css">

    <style>

        /* STATUS COLORS */
        .status-out {
            color:#8B0000;
            font-weight:bold;
        }

        .status-critical {
            color:red;
            font-weight:bold;
        }

        .status-low {
            color:orange;
            font-weight:bold;
        }

        .status-medium {
            color:#007BFF;
            font-weight:bold;
        }

        .status-good {
            color:green;
            font-weight:bold;
        }

        /* STOCK BAR */
        .stock-bar-container{
            width:100px;
            background:#ddd;
            border-radius:5px;
            overflow:hidden;
        }

        .stock-bar{
            height:20px;
            color:white;
            text-align:center;
            line-height:20px;
            font-size:12px;
            font-weight:bold;
        }

    </style>
</head>

<body>

<div class="login-box">

    <h2>📦 Stock levels</h2>

    <table border="1" width="100%" cellpadding="10">

        <tr style="background:#007bff; color:white;">
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Stock %</th>
            <th>Status</th>
        </tr>

        <tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<?php
    $stock = (int)$row['stock'];

    // STOCK PERCENTAGE
    $percentage = min($stock, 100);

    // BAR COLOR
    if($percentage >= 80){
        $barColor = "green";
    }
    elseif($percentage >= 40){
        $barColor = "orange";
    }
    else{
        $barColor = "red";
    }
?>

<tr>

    <!-- PRODUCT -->
    <td><?= htmlspecialchars($row['product_name']); ?></td>

    <!-- PRICE -->
    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>

    <!-- STOCK -->
    <td><?= $stock; ?></td>

    <!-- STOCK PERCENTAGE -->
    <td>

        <div class="stock-bar-container">

            <div class="stock-bar"
                 style="
                    width:<?= $percentage; ?>%;
                    background:<?= $barColor; ?>;
                 ">

                <?= $percentage; ?>%

            </div>

        </div>

    </td>

    <!-- STATUS -->
    <td>

        <?php

        // STATUS LOGIC
        if($stock == 0){
            echo "<span class='status-out'>❌ Out of Stock</span>";
        }
        elseif($stock <= 10){
            echo "<span class='status-critical'>🔴 Critical ($stock)</span>";
        }
        elseif($stock <= 30){
            echo "<span class='status-low'>⚠️ Low ($stock)</span>";
        }
        elseif($stock <= 100){
            echo "<span class='status-medium'>🔵 Medium ($stock)</span>";
        }
        else{
            echo "<span class='status-good'>✅ Good ($stock)</span>";
        }

        ?>

    </td>

</tr>

<?php } ?>

        </tbody>

    </table>

    <br>

    <!-- BACK BUTTON -->
    <a href="<?= htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">
        ← Back to dashboard
    </a>

</div>

</body>
</html>