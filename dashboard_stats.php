<?php
include("config.php");


// TOTAL SALES

$totalQuery = mysqli_query($conn, "
SELECT SUM(s.quantity * p.unit_price) as total
FROM sales s
JOIN product p ON s.product_id = p.product_id
");

$totalData = mysqli_fetch_assoc($totalQuery);
$totalSales = $totalData['total'] ?? 0;



// BEST SELLING PRODUCT

$bestQuery = mysqli_query($conn, "
SELECT p.product_name, SUM(s.quantity) as total_qty
FROM sales s
JOIN product p ON s.product_id = p.product_id
GROUP BY s.product_id
ORDER BY total_qty DESC
LIMIT 1
");

$bestProduct = mysqli_fetch_assoc($bestQuery);



// CURRENT MONTH SALES

$monthQuery = mysqli_query($conn, "
SELECT DATE_FORMAT(s.sales_date, '%Y-%m') as month,
SUM(s.quantity * p.unit_price) as total
FROM sales s
JOIN product p ON s.product_id = p.product_id
GROUP BY month
ORDER BY month DESC
LIMIT 1
");

$currentMonth = mysqli_fetch_assoc($monthQuery);
?>