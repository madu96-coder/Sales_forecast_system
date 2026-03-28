<?php
include "config.php";

session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>📊 Reports Dashboard</h2>

    <!-- 📦 INVENTORY REPORT -->
    <div style="margin:20px 0;">
        <a href="inventory_report.php" style="text-decoration:none;">
            <div style="padding:15px; background:#f3f3f3; border-radius:10px;">
                📦 Inventory Report
            </div>
        </a>
    </div>

    <!-- FUTURE REPORTS (PLACEHOLDER) -->
    <div style="margin:20px 0; opacity:0.5;">
        📈 Sales Report
    </div>

    <div style="margin:20px 0; opacity:0.5;">
        🤖 Forecast Report 
    </div>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>