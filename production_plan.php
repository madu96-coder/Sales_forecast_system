<?php
include 'includes/auth.php';
include 'includes/config.php';

/*
|--------------------------------------------------------------------------
| ROLE CONTROL
|--------------------------------------------------------------------------
*/

checkRole(['admin', 'product_manager']);

/*
|--------------------------------------------------------------------------
| FETCH MONTHS FOR DROPDOWN
|--------------------------------------------------------------------------
*/

$monthsResult = mysqli_query($conn, "

    SELECT DISTINCT forecast_month
    FROM forecast
    ORDER BY STR_TO_DATE(forecast_month, '%M %Y') DESC

");

$monthOptions = [];

while ($m = mysqli_fetch_assoc($monthsResult)) {

    $monthOptions[] = $m['forecast_month'];
}

/*
|--------------------------------------------------------------------------
| SELECTED MONTH
|--------------------------------------------------------------------------
*/

$selectedMonth = '';

if (!empty($_GET['month'])) {

    $selectedMonth = $_GET['month'];

} elseif (!empty($monthOptions)) {

    $selectedMonth = $monthOptions[0];
}

/*
|--------------------------------------------------------------------------
| PREVIOUS MONTH CALCULATION
|--------------------------------------------------------------------------
*/

$prevMonthSQL = "";

if (!empty($selectedMonth)) {

    $dateObj = DateTime::createFromFormat('F Y', $selectedMonth);

    if ($dateObj) {

        $dateObj->modify('-1 month');

        $prevMonth = $dateObj->format('Y-m');

        $prevMonthSQL = "
            AND DATE_FORMAT(s.sales_date, '%Y-%m') = '$prevMonth'
        ";
    }
}

$displayMonth = $selectedMonth ?: 'No forecast';

/*
|--------------------------------------------------------------------------
| MAIN QUERY
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "

SELECT 
    p.product_id,
    p.product_name,

    '" . mysqli_real_escape_string($conn, $displayMonth) . "' AS forecast_month,

    IFNULL(SUM(s.quantity), 0) AS forecast,

    (
        SELECT IFNULL(SUM(i.stock_quantity), 0)
        FROM inventory i
        WHERE i.product_id = p.product_id
    ) AS stock

FROM product p

LEFT JOIN sales s 
    ON s.product_id = p.product_id 
    $prevMonthSQL

WHERE p.status = 'active'

GROUP BY 
    p.product_id,
    p.product_name

ORDER BY p.product_name

");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Production Plan</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .status-ok {
            color: green;
            font-weight: bold;
        }

        .status-warning {
            color: orange;
            font-weight: bold;
        }

        .status-danger {
            color: red;
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background: #0f4c5c;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
        }

        .override-input {

            width: 100px;

            padding: 8px;

            border-radius: 8px;

            border: 1px solid #ccc;

            text-align: center;

            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>Production Plan</h2>

    <br>

    <!-- ===================================================== -->
    <!-- MONTH DROPDOWN -->
    <!-- ===================================================== -->

    <form method="GET">

        <label>Select Month:</label>

        <select name="month" onchange="this.form.submit()">

            <?php
            foreach ($monthOptions as $value) {

                $selected = ($selectedMonth === $value)
                    ? 'selected'
                    : '';
            ?>

            <option 
                value="<?= htmlspecialchars($value); ?>"
                <?= $selected; ?>
            >

                <?= htmlspecialchars($value); ?>

            </option>

            <?php } ?>

        </select>

    </form>

    <br>

    <!-- ===================================================== -->
    <!-- TABLE -->
    <!-- ===================================================== -->

    <table border="1" width="100%">

    <tr>

        <th>Month</th>

        <th>Product</th>

        <th>Forecast</th>

        <th>Stock</th>

        <th>Production Needed</th>

        <th>Manual Override</th>

        <th>Status</th>

    </tr>

    <?php while($row = mysqli_fetch_assoc($query)) {

        /*
        |--------------------------------------------------------------------------
        | CALCULATIONS
        |--------------------------------------------------------------------------
        */

        $forecast = (int)$row['forecast'];

        $stock = (int)$row['stock'];

        $needed = max(0, $forecast - $stock);

        /*
        |--------------------------------------------------------------------------
        | STATUS LOGIC
        |--------------------------------------------------------------------------
        */

        if($forecast == 0 && $stock == 0){

            $status = "No stock & No Forecast";

            $class = "status-danger";

        }
        elseif($needed == 0){

            $status = "Sufficient";

            $class = "status-ok";

        } else{

            $status = "Production Needed";

            $class = "status-warning";
        }

    ?>

    <tr>

        <!-- MONTH -->
        <td>

            <?= htmlspecialchars($row['forecast_month']); ?>

        </td>

        <!-- PRODUCT -->
        <td>

            <?= htmlspecialchars($row['product_name']); ?>

        </td>

        <!-- FORECAST -->
        <td>

            <?= $forecast; ?>

        </td>

        <!-- STOCK -->
        <td>

            <?= $stock; ?>

        </td>

        <!-- PRODUCTION NEEDED -->
        <td class="<?= $class; ?> production-cell">

            <?= $needed; ?>

        </td>

        <!-- MANUAL OVERRIDE -->
        <td>

            <input
                type="number"
                class="override-input"
                value="<?= $needed; ?>"
                min="0"
                placeholder="Override"
            >

        </td>

        <!-- STATUS -->
        <td class="<?= $class; ?> status-cell">

            <?= $status; ?>

        </td>

    </tr>

    <?php } ?>

    </table>

    <br>

    <!-- ===================================================== -->
    <!-- BACK BUTTON -->
    <!-- ===================================================== -->

    <a href="<?= htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])) ?>">

        ← Back

    </a>

</div>

<!-- ===================================================== -->
<!-- LIVE MANUAL OVERRIDE SCRIPT -->
<!-- ===================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const overrideInputs = document.querySelectorAll(".override-input");

    overrideInputs.forEach(function(input) {

        input.addEventListener("input", function() {

            const row = input.closest("tr");

            const productionCell = row.querySelector(".production-cell");

            const statusCell = row.querySelector(".status-cell");

            let overrideValue = parseInt(input.value) || 0;

            /*
            =========================================
            UPDATE PRODUCTION VALUE
            =========================================
            */

            productionCell.innerText = overrideValue;

            /*
            =========================================
            UPDATE STATUS
            =========================================
            */

            if (overrideValue <= 0) {

                statusCell.innerText = "Sufficient";

                statusCell.className = "status-cell status-ok";

                productionCell.className = "production-cell status-ok";

            } else {

                statusCell.innerText = "Production Needed";

                statusCell.className = "status-cell status-warning";

                productionCell.className = "production-cell status-warning";
            }

        });

    });

});

</script>

</body>

</html>