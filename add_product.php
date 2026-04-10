<?php
// ================================
// AUTH + DB CONNECTION
// ================================
include 'includes/auth.php';
include 'includes/config.php';

// only allow inventory manager & admin
checkRole(['inventory_manager', 'admin']);


// ================================
// HANDLE FORM SUBMISSION
// ================================
if(isset($_POST['submit'])){

    // sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['unit_price'];
    $category = $_POST['category_id'];
    $stock = $_POST['stock'];

    // basic validation
    if(empty($name) || empty($price) || empty($category) || empty($stock)){
        header("Location: add_product.php?error=empty");
        exit();
    }

    // ================================
    // CHECK IF PRODUCT EXISTS (ACTIVE ONLY)
    // ================================
    $check = mysqli_query($conn, "
        SELECT * FROM product 
        WHERE product_name = '$name' 
        AND status = 'active'
    ");

    $row = mysqli_fetch_assoc($check);

    if($row){
        // ===================================
        // PRODUCT EXISTS → UPDATE STOCK ONLY
        // ===================================
        $product_id = $row['product_id'];
        $newStock = $row['stock'] + $stock;

        $sql = "
            UPDATE product 
            SET stock = '$newStock' 
            WHERE product_id = $product_id
        ";

    } else {
        // ===================================
        // NEW PRODUCT → INSERT
        // ===================================
        $sql = "
            INSERT INTO product 
            (product_name, unit_price, category_id, stock, status)
            VALUES 
            ('$name', '$price', '$category', '$stock', 'active')
        ";
    }

    // ================================
    // EXECUTE QUERY
    // ================================
    if(mysqli_query($conn, $sql)){
        header("Location: products.php?added=1");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>Add Product</h2>

    <!-- SUCCESS / ERROR MESSAGES -->
    <?php if(isset($_GET['added'])): ?>
        <p style="color:green;">✅ Product added successfully</p>
    <?php endif; ?>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
        <p style="color:red;">⚠ Please fill all fields</p>
    <?php endif; ?>


    <!-- ADD PRODUCT FORM -->
    <form method="POST">

        <!-- Product Name -->
        <label>Product Name</label>
        <input type="text" name="product_name" placeholder="Enter product name" required>

        <!-- Category -->
        <label>Category</label>
        <select name="category_id" required>
            <option value="">Select Category</option>

            <?php
            $cat = mysqli_query($conn,"SELECT * FROM category WHERE status='active'");

            while($c = mysqli_fetch_assoc($cat)){
            ?>
                <option value="<?php echo $c['category_id']; ?>">
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>

        </select>

        <!-- Unit Price -->
        <label>Unit Price</label>
        <input type="number" name="unit_price" step="0.01" placeholder="Enter price" required>

        <!-- Quantity -->
        <label>Quantity</label>
        <input type="number" name="stock" placeholder="Enter quantity" required>

        <!-- Submit -->
        <button type="submit" name="submit">Add Product</button>

    </form>

    <br>

    <a href="products.php">← Back</a>

</div>

</body>
</html>