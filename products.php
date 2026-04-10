<?php
include 'includes/auth.php';
include 'includes/config.php';

// restrict roles
checkRole(['product_manager', 'admin','inventory_manager']);

// get ONLY active products
$result = mysqli_query($conn,"SELECT * FROM product WHERE status='active'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
<div class="login-box">

<h2>Products</h2>

<!-- LINK TO INACTIVE PRODUCTS PAGE -->
<a href="inactive_products.php">View Inactive Products</a>
<br><br>

<!-- SUCCESS / ERROR MESSAGES -->

<?php if(isset($_GET['updated'])): ?>
    <p style="color:green;">Product updated successfully</p>
<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>
    <p style="color:red;">Product removed (inactive)</p>
<?php endif; ?>

<?php if(isset($_GET['error']) && $_GET['error'] == 'used'): ?>
    <p style="color:orange;">Cannot delete: product has sales</p>
<?php endif; ?>

<br><br>

<!-- PRODUCT TABLE -->
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
        <!-- EDIT -->
        <a href="edit_product.php?id=<?php echo $row['product_id']; ?>">Edit</a>

        <!-- DELETE -->
        <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
        onclick="return confirm('Are you sure you want to delete this product?')">
        Delete
        </a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<br>

<!-- BACK BUTTON -->
<a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">
    Back to dashboard
</a>

</div>

<!-- CLEAN URL AFTER MESSAGE -->
<script>
setTimeout(() => {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.pathname);
    }
}, 500);
</script>

</body>
</html>