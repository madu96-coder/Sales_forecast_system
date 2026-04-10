<?php
// ==============================
// INCLUDE REQUIRED FILES
// ==============================
include 'includes/auth.php';
include 'includes/config.php';

// ONLY ADMIN CAN ACCESS
checkRole(['admin']);


// ==============================
// RESTORE CATEGORY LOGIC
// ==============================
// If user clicks "Restore"
if(isset($_GET['restore'])){

    // get category id from URL
    $id = $_GET['restore'];

    // update category status back to active
    $sql = "UPDATE category SET status='active' WHERE category_id = $id";

    // execute query
    if(mysqli_query($conn, $sql)){
        // redirect with success message
        header("Location: inactive_categories.php?restored=1");
        exit();
    } else {
        // show error if something goes wrong
        echo "Error: " . mysqli_error($conn);
    }
}


// ==============================
// FETCH INACTIVE CATEGORIES
// ==============================
// only show categories marked as inactive
$result = mysqli_query($conn, "SELECT * FROM category WHERE status='inactive'");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Inactive Categories</title>

    <!-- link your CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <!-- PAGE TITLE -->
    <h2>Inactive Categories</h2>


    <!-- ==============================
         SUCCESS MESSAGE
    ============================== -->
    <?php if(isset($_GET['restored'])): ?>
        <p style="color:green;">Category restored successfully</p>
    <?php endif; ?>


    <!-- ==============================
         CATEGORY TABLE
    ============================== -->
    <table border="1" width="100%" cellpadding="10">

        <!-- TABLE HEADER -->
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>

        <?php
        // loop through each inactive category
        while($row = mysqli_fetch_assoc($result)){
        ?>
            <tr>

                <!-- CATEGORY ID -->
                <td><?php echo $row['category_id']; ?></td>

                <!-- CATEGORY NAME -->
                <td><?php echo $row['category_name']; ?></td>

                <!-- RESTORE BUTTON -->
                <td>
                    <a href="inactive_categories.php?restore=<?php echo $row['category_id']; ?>"
                       onclick="return confirm('Restore this category?')"
                       style="color:green;">
                       Restore
                    </a>
                </td>

            </tr>
        <?php } ?>

    </table>


    <br>
    

    <!-- BACK BUTTON -->
    <a href="manage_category.php">← Back to Manage Categories</a>

</div>


<!-- ==============================
     CLEAN URL (REMOVE ?restored=1)
============================== -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.pathname);
    }
</script>

</body>
</html>