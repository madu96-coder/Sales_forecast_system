<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/auth.php';
checkRole(['product_manager', 'sales_manager', 'admin']);

$month = []; //store months
$total = []; //store sales values

// get monthly sales total
$result = mysqli_query($conn,"SELECT DATE_FORMAT(sales_date, '%Y-%m') as month,
SUM(quantity * p.unit_price) as total_sales FROM sales s JOIN product p ON s.product_id = p.product_id
GROUP BY month ORDER BY month ASC");

//initialize arrays
$sales = [];
$labels = [];

//fetch data - take data from one raw at one time
while($row = mysqli_fetch_assoc($result)){
    $labels[] = $row['month'];
    $sales[] = $row['total_sales'];  
}

// calculate forecast (last 3 months average)
$forecast = 0;

if(count($sales) >= 3){
    $last3 = array_slice($sales, -3);
    $forecast = array_sum($last3) / 3;
}


?>

<!DOCTYPE html>
<html>
<head>

    <title>Sales Forecast</title>

    <link rel="stylesheet" href="style.css">         

    <script src="http://cdn.jsdelivr.net/npm/chart.js"></script>  <!--add chart library-->

</head>
<body>

<div class="login-box">

<h2> Sales Forecast</h2>

<h3>Next Month Prediction:</h3>

<p style="font-size: 24px; color: green;">
    Rs. <?php echo number_format($forecast, 2); ?>
</p>

<!-- add chart area-->
 <canvas id="salesChart"
    data-labels='<?= json_encode($labels); ?>'
    data-values='<?= json_encode($sales); ?>'>
 </canvas>

</div>
<script src="script.js"></script>



</body>
</html>