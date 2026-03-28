<?php
include("config.php"); // connect to database


session_start(); //start session

//check if user is logged in
if(!isset($_SESSION['user'] )){
    header("Location: login.php"); //redirect if not logged in
    exit();
}

//get all products from database
$result = mysqli_query($conn,"SELECT * FROM product");
?>

<!DOCTYPE html>
<head>
    <title>Products</title>

    <!--link external css-->
    <link rel="stylesheet" href="style.css">

</head>

<body>
    
<div class="login-box"><!--container for styling-->


<!--page title-->
<h2>Products</h2>

<!--add product button-->
<a href="add_product.php"> Add New Product</a>
<br><br>



<!--product table-->

<table border="1" width="100%">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Action</th> <!--new column-->
    </tr>

    <?php

    //loop through each product
    while($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <!-- display product-->
             <td><?php echo $row['product_id']; ?></td>
             <td><?php echo $row['product_name'];?> </td>
             <td><?php echo $row ['unit_price'];?> </td>

             <!--action buttons-->
             <td>
                <!--edit product-->
                <a href="edit_product.php?id=<?php echo $row['product_id']; ?> ">Edit</a>

                <!--delete product-->
                <a href="delete_product.php?id=<?php echo $row['product_id']; ?> "
                onclick="return confirm('Are you sure?')">Delete</a>
             </td>
        </tr>
        <?php 
    } ?>
    

</table>
<br>

<!--back button-->
<a href="dashboard.php">  Back to Dashboard</a>

</div>
</body>
</html>