<?php
require_once __DIR__ . '/includes/config.php'; 
// 🔥 Central DB connection

// ========================================
// TOTAL SALES (ALL TIME)
// ========================================
$totalQuery = mysqli_query($conn, "
    SELECT SUM(s.quantity * p.unit_price) as total
    FROM sales s
    JOIN product p ON s.product_id = p.product_id
");

$totalData = mysqli_fetch_assoc($totalQuery);

//  avoid NULL showing
$totalSales = $totalData['total'] ?? 0;



// ========================================
// TOP / BEST SELLING PRODUCT
// ========================================

$bestQuery = mysqli_query($conn, "
    SELECT p.product_name, 
           COALESCE(SUM(s.quantity), 0) as total_sold
    FROM sales s
    JOIN product p ON s.product_id = p.product_id
    GROUP BY s.product_id
    ORDER BY total_sold DESC
    LIMIT 1
");

$bestProduct = mysqli_fetch_assoc($bestQuery);



// ========================================
// CURRENT MONTH SALES
// ========================================

$monthQuery = mysqli_query($conn, "
    SELECT 
        SUM(s.quantity * p.unit_price) as total
    FROM sales s
    JOIN product p ON s.product_id = p.product_id
    WHERE MONTH(s.sales_date) = MONTH(CURRENT_DATE())
      AND YEAR(s.sales_date) = YEAR(CURRENT_DATE())
");

$currentMonth = mysqli_fetch_assoc($monthQuery);

// ✅ fallback safety
$currentMonth['total'] = $currentMonth['total'] ?? 0;

?>