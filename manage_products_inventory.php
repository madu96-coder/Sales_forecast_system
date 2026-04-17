<?php
// ================================
// DEBUG (SAFE FOR DEV ONLY)
// ================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================================
// INCLUDE AUTH + DB
// ================================
include 'includes/auth.php';
include 'includes/config.php';

// ================================
// ROLE CONTROL
// ================================
checkRole(['admin','inventory_manager']);

// ================================
// ✅ FIXED QUERY (JOIN INVENTORY)
// ================================
$result = mysqli_query($conn, "
SELECT 
    p.product_id,
    p.product_name,
    p.unit_price,
    COALESCE(i.stock_quantity, 0) AS stock
FROM product p
LEFT JOIN inventory i ON p.product_id = i.product_id
WHERE p.status = 'active'
ORDER BY p.product_id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory Products</title>
    <link rel="stylesheet" href="style.css">

    <!-- STATUS COLORS -->
    <style>
        .low { color:red; font-weight:bold; }
        .medium { color:orange; }
        .good { color:green; font-weight:bold; }
    </style>
</head>

<body>

<div class="login-box">

<h2>Manage Inventory Products</h2>

<!-- SUCCESS MESSAGES -->
<?php if(isset($_GET['updated'])): ?>
    <p style="color:green;">Product updated</p>
<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>
    <p style="color:red;">Product removed (inactive)</p>
<?php endif; ?>

<br>

<table border="1" width="100%">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>
    <td><?= $row['product_id']; ?></td>

    <td><?= htmlspecialchars($row['product_name']); ?></td>

    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>

    <!-- ✅ FIXED STOCK DISPLAY -->
    <td>
        <?php
        $stock = (int)$row['stock'];

        if($stock == 0){
            echo "<span class='low'>Out (0)</span>";
        }
        elseif($stock <= 10){
            echo "<span class='low'>Low ($stock)</span>";
        }
        elseif($stock <= 30){
            echo "<span class='medium'>$stock</span>";
        }
        else{
            echo "<span class='good'>$stock</span>";
        }
        ?>
    </td>

    <td>
        <!-- EDIT -->
        <a href="edit_product.php?id=<?= $row['product_id']; ?>">Edit</a>

        <!-- DELETE -->
        <a href="delete_product.php?id=<?= $row['product_id']; ?>"
           onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<br>
<a href="manage_inventory.php">← Back</a>

</div>

</body>
</html>