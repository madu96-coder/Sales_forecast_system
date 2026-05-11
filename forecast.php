<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/auth.php';

/*
|--------------------------------------------------------------------------
| ROLE ACCESS
|--------------------------------------------------------------------------
*/

checkRole(['product_manager', 'sales_manager', 'admin']);

/*
|--------------------------------------------------------------------------
| TOTAL MONTHLY SALES DATA
|--------------------------------------------------------------------------
*/

$labels = [];
$sales = [];

$totalSalesQuery = mysqli_query($conn, "

    SELECT 
        DATE_FORMAT(sales_date, '%Y-%m') AS month,
        SUM(quantity * p.unit_price) AS total_sales

    FROM sales s

    JOIN product p
        ON s.product_id = p.product_id

    GROUP BY month

    ORDER BY month ASC

");

while($row = mysqli_fetch_assoc($totalSalesQuery)){

    $labels[] = $row['month'];
    $sales[] = $row['total_sales'];
}

/*
|--------------------------------------------------------------------------
| OVERALL FORECAST USING MOVING AVERAGE
|--------------------------------------------------------------------------
*/

$forecast = 0;

if(count($sales) >= 3){

    $last3 = array_slice($sales, -3);

    $forecast = array_sum($last3) / 3;
}

/*
|--------------------------------------------------------------------------
| GET NEXT FORECAST MONTH
|--------------------------------------------------------------------------
*/

$nextForecastMonth = '';

if(!empty($labels)){

    $latestMonth = end($labels);

    $nextForecastMonth = date(
        'Y-m',
        strtotime($latestMonth . '-01 +1 month')
    );
}

/*
|--------------------------------------------------------------------------
| PRODUCT-WISE SALES DATA
|--------------------------------------------------------------------------
*/

$productForecastQuery = mysqli_query($conn, "

    SELECT 
        p.product_id,
        p.product_name,
        DATE_FORMAT(s.sales_date, '%Y-%m') AS sales_month,
        SUM(s.quantity * p.unit_price) AS monthly_sales

    FROM sales s

    JOIN product p
        ON s.product_id = p.product_id

    GROUP BY 
        p.product_id,
        sales_month

    ORDER BY 
        p.product_name,
        sales_month ASC

");

/*
|--------------------------------------------------------------------------
| ORGANIZE PRODUCT SALES DATA
|--------------------------------------------------------------------------
*/

$productData = [];

while($row = mysqli_fetch_assoc($productForecastQuery)){

    $productId = $row['product_id'];

    if(!isset($productData[$productId])){

        $productData[$productId] = [
            'product_id' => $productId,
            'product_name' => $row['product_name'],
            'sales' => []
        ];
    }

    $productData[$productId]['sales'][] = $row['monthly_sales'];
}

/*
|--------------------------------------------------------------------------
| CALCULATE PRODUCT FORECASTS
|--------------------------------------------------------------------------
*/

$productForecasts = [];

foreach($productData as $product){

    $salesHistory = $product['sales'];

    $productForecast = 0;

    if(count($salesHistory) >= 3){

        $last3Months = array_slice($salesHistory, -3);

        $productForecast = array_sum($last3Months) / 3;

    } else {

        $productForecast = array_sum($salesHistory);
    }

    /*
    |--------------------------------------------------------------------------
    | GET CURRENT STOCK
    |--------------------------------------------------------------------------
    */

    $productId = $product['product_id'];

    $stockQuery = mysqli_query($conn, "

        SELECT stock_quantity

        FROM inventory

        WHERE product_id = '$productId'

        LIMIT 1

    ");

    $stockRow = mysqli_fetch_assoc($stockQuery);

    $currentStock = $stockRow['stock_quantity'] ?? 0;

    /*
    |--------------------------------------------------------------------------
    | STORE FINAL DATA
    |--------------------------------------------------------------------------
    */

    $productForecasts[] = [

        'product_name' => $product['product_name'],

        'forecast' => $productForecast,

        'current_stock' => $currentStock
    ];
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Sales Forecast</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<div class="login-box">

    <!-- ===================================================== -->
    <!-- DASHBOARD TITLE -->
    <!-- ===================================================== -->

    <h2>Sales Forecast Dashboard</h2>

    <hr>

    <!-- ===================================================== -->
    <!-- FORECAST CARD -->
    <!-- ===================================================== -->

    <div class="forecast-card">

        <h3>Overall Business Forecast</h3>

        <p>

            Rs. <?php echo number_format($forecast, 2); ?>

        </p>

        <small>

            Forecast Month :
            <?php echo $nextForecastMonth; ?>

        </small>

    </div>

    <!-- ===================================================== -->
    <!-- SALES TREND CHART -->
    <!-- ===================================================== -->

    <canvas id="salesChart"
        style="max-height: 450px;"
        data-labels='<?= json_encode($labels); ?>'
        data-values='<?= json_encode($sales); ?>'>
    </canvas>

    <br>
    <hr>

    <!-- ===================================================== -->
    <!-- PRODUCT-WISE FORECAST TABLE -->
    <!-- ===================================================== -->

    <h3>Product-wise Forecast</h3>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <tr>

            <th>Product Name</th>

            <th>Forecast Month</th>

            <th>Predicted Sales (Rs.)</th>

            <th>Current Stock</th>

        </tr>

        <?php foreach($productForecasts as $product): ?>

        <tr>

            <td>

                <?php echo htmlspecialchars($product['product_name']); ?>

            </td>

            <td>

                <?php echo $nextForecastMonth; ?>

            </td>

            <td style="color: green; font-weight: bold;">

                Rs. <?php echo number_format($product['forecast'], 2); ?>

            </td>

            <td>

                <?php echo number_format($product['current_stock']); ?>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

    <br>

    <!-- ===================================================== -->
    <!-- BACK BUTTON -->
    <!-- ===================================================== -->

    <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])); ?>">

        Back to dashboard

    </a>

</div>

<script src="script.js"></script>

</body>

</html>