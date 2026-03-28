<?php
include "config.php"; // DB connection

session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
// search feature
$search = "";

if(isset($_GET['search'] ) && $_GET['search'] != "" ){
    $search = mysqli_real_escape_string($conn, $_GET['search'] );


// filter query (replace old query)
$sql = "SELECT product_name, unit_price, stock FROM product WHERE product_name LIKE '%$search%'
ORDER BY product_name ASC";

}else { $sql = "SELECT product_name, unit_price, stock FROM product ORDER BY product_name ASC";

}
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>📦 Inventory Report</h2>

    <form  method="GET" style="margin-bottom: 15px">
        <input type="text" id="searchInput" name="search" placeholder="search product..."  value="<?= isset($_GET['search'] ) ? $_GET['search'] : ''?> "
             style="padding:8px; width: 60%;">

             <!-- CLEAN DROPDOWN -->
    <div id="suggestions" style="
        position:absolute;
        top:45px;
        left:0;
        width:100%;
        background:white;
        border:1px solid #ccc;
        border-top:none;
        border-radius:0 0 5px 5px;
        max-height:200px;
        overflow-y:auto;
        z-index:1000;
    "></div>

             <!--search button-->

        <button type="submit">🔍 Search </button>

        <!--reset button-->
        <a href="inventory_report.php">
            <button type="button">Reset</button>
        </a>
        <!-- suggestion box-->
         <div id="suggestion" style="position:absolute; top=:40px; width:60%; background:white; border:1px solid #ccc; z-index:1000;">

         </div>
    </form>



    <table border="1" width="100%" cellpadding="10">
        <tr style="background:#007bff; color:white;">
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
        </tr>

        <tbody id="tableBody">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <!-- product name -->
    <td><?= $row['product_name']; ?></td>

    <!-- price -->
    <td>Rs. <?= number_format($row['unit_price'], 2); ?></td>

    <!-- stock -->
    <td><?= $row['stock']; ?></td>

    <!-- status -->
    <td>
        <?php
        $stock = (int)$row['stock']; // convert to number

        if($stock == 0){
            echo "<span style='color:red;'>Out of Stock</span>";
        }
        elseif($stock <= 10){
            echo "<span style='color:orange;'>Low Stock</span>";
        }
        else{
            echo "<span style='color:green;'>In Stock</span>";
        }
        ?>
    </td>
</tr>

<?php } ?>

</tbody>
       

    </table>

    <br>
    <a href="reports.php">⬅ Back to Reports</a>

</div>
<script src="live_search.js"></script>

</body>
</html>