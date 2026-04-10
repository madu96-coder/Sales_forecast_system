<?php 
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin','inventory_manager']);

// get product id
$id = $_GET['id'] ?? null;

if(!$id){
    die("Invalid Product ID");
}

// fetch product data
$result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $id");
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("product not found");
}

//update logic
if(isset($_POST['update'] )){
    $name = $_POST['name'];
    $price = $_POST['price'];
         
    //validation part
    if(empty($name) || empty($price)){
        echo "Please fill all fields";
    } else{

    $sql = "UPDATE product
    SET product_name='$name', unit_price='$price'
    WHERE product_id=$id";
    }

    if(mysqli_query($conn, $sql)){
        header("Location: products.php?updated=1");
        exit();
    }else{
        echo "Error: " .mysqli_error($conn);
    }



}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="login-box">
            <h2>Edit Product</h2>

            <form method="POST">

            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo $product['product_name'];?> " required>

            <label>Price</label>
            <input type="number" name="price" value="<?php echo $product['unit_price']?>" required>

            <button type="submit" name="update">Update</button>
            </form>

            <br>
            <a href="products.php">← Back </a>

        </div>
    </body>
</html>