<?php
include 'includes/auth.php';
checkRole(['product_manager', 'admin']);

// when form submitted
if(isset($_POST['submit'])){

    // get form data
    $name = $_POST['product_name'];   // product name
    $price = $_POST['unit_price'];    // price
    $category = $_POST['category_id']; // category

    //get stock from form
    $stock = $_POST['stock'];

  
    //  check if product already exists
          $check = mysqli_query($conn, "SELECT * FROM product WHERE product_name = '$name'");
          $row = mysqli_fetch_assoc($check);

        if($row){
              //  product exists → UPDATE stock

                 $newStock = $row['stock'] + $stock;

             $sql = "UPDATE product 
                  SET stock = $newStock 
                    WHERE product_name = '$name'";

}        else {
            //  new product → INSERT

              $sql = "INSERT INTO product (product_name, unit_price, category_id, stock)
                    VALUES ('$name', '$price', '$category', '$stock')";
}

                //  execute query
                  if(mysqli_query($conn, $sql)){
                      header("Location: products.php");
}                 else {
                    echo "Error: " . mysqli_error($conn);
}



 

    // execute query
    if(mysqli_query($conn, $sql)){
        header("Location: products.php"); // redirect after success
    } else {
        echo "Error: " . mysqli_error($conn);
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

    <form method="POST">

        <!-- Product Name -->
        <label>Product Name</label>
        <input type="text" name="product_name" id="product_name" required>

        
        <!-- Category -->
        <label>Category</label>
        <select name="category_id" id="category" required> <!--used by js-->
            <option value="">Select Category</option>

            <?php
            $cat = mysqli_query($conn,"SELECT * FROM category");

            while($c = mysqli_fetch_assoc($cat)){
            ?>
                <option value="<?php echo $c['category_id']; ?>">
                    <?php echo $c['category_name']; ?>
                </option>
            <?php } ?>

        </select>
        <!--product dropdown-->
        <label>Product</label>
        <select name="product_id" id="product" required>
            <option value="">Select Product</option>
        </select>

     

        <!-- Unit Price -->
        <label>Unit Price</label>
        <input type="number" name="unit_price" id="unit_price" readonly>

        <!--quantity-->

        <label>Quantity</label>
        <input type="number" name="stock" placeholder="Enter quantity" required>

        <!-- Submit -->
        <button type="submit" name="submit">Add Product</button>

    </form>

    <br>

    <a href="products.php">← Back</a>

</div>

<script src="script.js"></script>


</body>
</html>