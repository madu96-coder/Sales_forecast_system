<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin','inventory_manager']);

// get inactive products
$result = mysqli_query($conn,"SELECT * FROM product WHERE status='inactive'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inactive Products</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

<h2>Inactive Products (Trash)</h2>

<?php if(isset($_GET['restored'])): ?>
    <p style="color:green;">Product restored successfully</p>
<?php endif; ?>

<br>

<table border="1" width="100%">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>
    <td><?php echo $row['product_id']; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['unit_price']; ?></td>

    <td>
        <!-- RESTORE BUTTON -->
        <a href="restore_product.php?id=<?php echo $row['product_id']; ?>">
            Restore
        </a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<br>
<a href="products.php">← Back</a>

</div>

</body>
</html>