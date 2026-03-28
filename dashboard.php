<?php 
session_start(); // Start session

//check if user is logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php"); //redirect if not logged in
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <!-- connect css here -->
     <link rel="stylesheet" href="style.css">
</head>
<body>

<!--display logged user-->
<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<!--include stats-->
<?php include("dashboard_stats.php"); ?>


<!-- cards container-->
 <!-- stats display section-->

<div class="container">
<!--total sales-->


<div class="card">
    <h3>Total Sales</h3>
    <p>Rs. <?php echo number_format($totalSales ?? 0, 2); ?></p>


</div>

<!--best product-->

<div class="card">
    <h3>Top Product</h3>
    <p><?php echo $top_product['product_name'] ?? "N/A"; ?></p>

</div>
<!--current month-->
<div class="card">
    <h3>This Month</h3>
    <p>Rs. <?php echo number_format($this_month['total'] ?? 0, 2 ); ?></p>

</div>
         <!--GRAPH SECTION (RIGHT SIDE CONTENT) -->
<div class="dashboard-graphs">

    <!-- sales chart -->
    <div class="graph-box">
        <h3>📊 Monthly Sales</h3>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- stock chart -->
    <div class="graph-box">
        <h3>📦 Top Products</h3>
        <canvas id="productChart"></canvas>
    </div>

</div>

</div>

<!-- links-->
 <div class="container menu">

<a href="products.php" class="card">📦 Products</a>
    <a href="sales.php" class="card">💰 Sales</a>
    <a href="forecast.php" class="card">📈 Forecast</a>
    <a href="view_sales.php" class="card">📊 View Sales</a>
    <a href="inventory.php" class="card">📦 Inventory</a>
    <a href="reports.php" class="card"> 📊 Reports</a>

    <!-- ONLY ONE logout button -->
    <a href="logout.php" class="card logout-btn">🚪 Logout</a>

 </div>

 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script src="dashboard.js"></script>


 </body>
 </html>

