<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['inventory_manager', 'admin']);

if(isset($_POST['submit'])){

    $product_id = $_POST['product_id'];
    $stock = (int) $_POST['stock']; // safety

    // NEW PRODUCT adding logic
    if($product_id == "new"){

        $name = $_POST['new_name'];
        $price = $_POST['new_price'];
        $category = $_POST['new_category'] ?? null; 

        // validation
        if(empty($name) || empty($price) || empty($category)){
            echo "Please fill all fields (name, price, category)";
            exit();
        }

        // insert new product into product table
        $sql1 = "INSERT INTO product (product_name, unit_price, category_id)
                 VALUES ('$name', '$price', '$category')";

        if(!mysqli_query($conn, $sql1)){
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        //  insert stock into inventory table
        $product_id_new = mysqli_insert_id($conn);

        mysqli_query($conn, "INSERT INTO inventory (product_id, stock_quantity) 
                             VALUES ($product_id_new, $stock)");

    } 
    // EXISTING PRODUCT adding logic
    else {

        //  CHECK if inventory record exists
        $check = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id = $product_id");

        if(mysqli_num_rows($check) > 0){

            // update inventory table 
            $sql2 = "UPDATE inventory 
                     SET stock_quantity = stock_quantity + $stock 
                     WHERE product_id = $product_id";

        } else {

            //  if no record, create one
            $sql2 = "INSERT INTO inventory (product_id, stock_quantity) 
                     VALUES ($product_id, $stock)";
        }

        if(!mysqli_query($conn, $sql2)){
            echo "Error: " . mysqli_error($conn);
            exit();
        }
    }

    header("Location: add_stock.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>Add Stock</h2>

    <!-- success message -->
    <?php if(isset($_GET['success'])): ?>
        <p style="color:green; margin-bottom:10px;">
            ✅ Stock updated successfully
        </p>
    <?php endif; ?>

    <form method="POST">

        <!-- Product Dropdown -->
        <label>Select Product</label>
        <select name="product_id" id="productSelect" required>
            <option value="">Select Product</option>

            <?php
            $result = mysqli_query($conn, "SELECT * FROM product");

            if (!$result) {
                die("Query Failed: " . mysqli_error($conn));
            }

            while($row = mysqli_fetch_assoc($result)){
                echo "<option value='{$row['product_id']}'>
                        {$row['product_name']}
                      </option>";
            }
            ?>

            <option value="new">+ Add New Product</option>
        </select>

        <!-- NEW PRODUCT FIELDS -->
        <div id="newProductFields" style="display:none; margin-top:10px;">

            <label>New Product Name</label>
            <input type="text" name="new_name" id="new_name">

            <label>Unit Price</label>
            <input type="number" name="new_price" id="new_price">

            <label>Category</label>
            <select name="new_category" id="new_category">
                <option value="">Select Category</option>

                <?php
                $cat = mysqli_query($conn, "SELECT * FROM category");

                while($c = mysqli_fetch_assoc($cat)){
                    echo "<option value='{$c['category_id']}'>
                          {$c['category_name']}
                          </option>";
                }
                ?>
            </select>

        </div>

        <!-- STOCK -->
        <label>Add Quantity</label>
        <input type="number" name="stock" placeholder="Enter quantity" required>

        <button type="submit" name="submit">Add Stock</button>

    </form>

    <br>
    <a href="manage_inventory.php">← Back</a>

</div>

<script src="js/add_stock.js"></script>

</body>
</html>