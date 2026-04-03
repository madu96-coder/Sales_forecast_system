<?php
include 'includes/auth.php';
checkRole(['sales_manager', 'admin']);

// get all sales
$result = mysqli_query($conn,"
    SELECT s.*, p.product_name, p.unit_price 
    FROM sales s
    JOIN product p ON s.product_id = p.product_id
");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sales List</title>

        <link rel="stylesheet" href="./style.css">
    </head>

    <body>
        
<h2 class="title">Sales List</h2>
<div class="table-container">

<table class="modern-table">
<tr>
    <th>ID</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Date</th>
    <th>Total</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
    $total = $row['quantity'] * $row['unit_price'];  //get total logic
?>
<tr>
    <td><?php echo $row['sales_id']; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['sales_date']; ?></td>

    <!--new-->
    <td><?php echo $total; ?></td>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>
