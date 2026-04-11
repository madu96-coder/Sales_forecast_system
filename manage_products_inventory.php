<?php
// enable error reporting (debug safe)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include auth + db
include 'includes/auth.php';
include 'includes/config.php';

// restrict access
checkRole(['admin','inventory_manager']);

// get active products only
$result = mysqli_query($conn, "SELECT * FROM product WHERE status='active'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Inventory Products</title>
    <link rel="stylesheet" href="style.css">
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

<table border="1" width="100%"> <!-- table create -->
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?> <!--taking data from db raw by raw-->

<tr>
    <td><?php echo $row['product_id']; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['unit_price']; ?></td>
    <td><?php echo $row['stock']; ?></td>

    <td>
        <!-- EDIT -->
        <a href="edit_product.php?id=<?php echo $row['product_id']; ?>">Edit</a>

        <!-- DELETE (SOFT DELETE) -->
        <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
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