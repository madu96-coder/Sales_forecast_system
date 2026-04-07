<?php
include 'includes/auth.php';
checkRole(['sales_manager', 'admin']);

if (isset($_POST['submit'])) {

    $product_id = $_POST['product_id'];
    $quantity   = $_POST['quantity'];
    $date       = $_POST['sales_date'];

    //  validation
    if(empty($product_id) || empty($quantity) || empty($date)){
        echo "<script>alert('❌ Please fill all fields'); window.history.back();</script>";
        exit;
    }

    //  get stock
    $stockResult = mysqli_query($conn, "SELECT stock FROM product WHERE product_id = $product_id");
    $stockRow = mysqli_fetch_assoc($stockResult);
    $currentStock = $stockRow['stock'] ?? 0;

    //  stock check
    if($quantity > $currentStock){
        echo "<script>alert('❌ Not enough stock'); window.history.back();</script>";
        exit;
    }

    //  insert query
    $sql = "INSERT INTO sales (product_id, quantity, sales_date)
            VALUES ('$product_id', '$quantity', '$date')";

    //  execute
    if(mysqli_query($conn, $sql)){

        // update stock
        $newStock = $currentStock - $quantity;
        mysqli_query($conn, "UPDATE product SET stock = $newStock WHERE product_id = $product_id");

        echo "<script>alert('✅ Sales added successfully');</script>";

    } else {

        //  ONLY error place
        echo "<pre>SQL ERROR:\n" . mysqli_error($conn) . "\n\nQUERY:\n" . $sql . "</pre>";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales</title>

    <script src="script.js"></script>

    <!-- link external CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <!-- page title -->
    <h2>Sales Entry</h2>

    <!-- sales form -->
    <form method="POST">

        <!-- category dropdown -->
        <label>Category</label>
        <select id="category" name="category_id" required>
            <option value="">Select Category</option>

            <?php
            // fetch categories from database
            $cat = mysqli_query($conn,"SELECT * FROM category");

            // loop through categories
            while($c = mysqli_fetch_assoc($cat)){
            ?>
                <!-- display category -->
                <option value="<?php echo $c['category_id']; ?>">
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>

        </select>

        <!-- product dropdown (filtered by category using JS) -->
        <label>Product</label>
        <select id="product" name="product_id" required>
            <option value="">Select Product</option>
        </select>

        <!-- unit price auto filled from product selection-->
         <label>Unit Price</label>
         <input type="text" id="unit_price" readonly>

  

        <!-- quantity input -->
        <label>Quantity</label>
        <input type="number" name="quantity" required>

        <!-- sales date input -->
        <label>Date</label>
        <input type="date" name="sales_date" required>

        <!-- submit button -->
        <button type="submit" name="submit">Save Sale</button>

    </form>
    <br>
    <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">Back to dashboard</a>

</div>

<!-- link external JavaScript file -->
<script src="script.js"></script>

</body>
</html>