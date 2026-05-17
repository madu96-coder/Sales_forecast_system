<?php
include __DIR__ . '/includes/auth.php';
include __DIR__ . '/includes/config.php';

checkRole(['inventory_manager', 'admin']);


// ======================================
// ADD SUPPLIER
// ======================================

if(isset($_POST['add_supplier'])){

    $supplier_name = trim($_POST['supplier_name']);
    $email = trim($_POST['email']);

    if($supplier_name != "" && $email != ""){

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO supplier (supplier_name, email)
             VALUES (?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $supplier_name,
            $email
        );

        mysqli_stmt_execute($stmt);

        $_SESSION['success'] = "Supplier added successfully.";

        header("Location: manage_supplier.php");
        exit;

    } else {

        $_SESSION['error'] = "All fields are required.";

    }
}



// ======================================
// DELETE SUPPLIER
// ======================================

if(isset($_GET['delete'])){

    $supplier_id = (int) $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM supplier
         WHERE supplier_id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $supplier_id
    );

    mysqli_stmt_execute($stmt);

    $_SESSION['success'] = "Supplier deleted successfully.";

    header("Location: manage_supplier.php");
    exit;
}



// ======================================
// FETCH SUPPLIERS
// ======================================

$suppliers = mysqli_query(
    $conn,
    "SELECT *
     FROM supplier
     ORDER BY supplier_id ASC"
);

?>

<!DOCTYPE html>
<html>
    <head>

    <title>Manage Suppliers</title>

    <link rel="stylesheet"
          href="<?php echo APP_BASE; ?>/style.css?v=<?php echo time(); ?>">

</head>



<body>



<!-- ======================================
     MAIN CONTENT
====================================== -->

<div class="main supplier-page">

    <h2 class="dashboard-title">

        🚚 Manage Suppliers

    </h2>



    <!-- SUCCESS MESSAGE -->

    <?php if(isset($_SESSION['success'])): ?>

        <p class="success-box">

            <?php echo $_SESSION['success']; ?>

        </p>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>



    <!-- ERROR MESSAGE -->

    <?php if(isset($_SESSION['error'])): ?>

        <p class="alert-box">

            <?php echo $_SESSION['error']; ?>

        </p>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>



    <!-- ======================================
         ADD SUPPLIER FORM
    ====================================== -->

    <div class="form-card">

        <form method="POST">

            <input type="text"
                   name="supplier_name"
                   placeholder="Enter Supplier Name"
                   required>

            <input type="email"
                   name="email"
                   placeholder="Enter Supplier Email"
                   required>

            <button type="submit"
                    name="add_supplier">

                ➕ Add Supplier

            </button>

        </form>

    </div>



    <!-- ======================================
         SUPPLIER TABLE
    ====================================== -->

    <div class="table-card">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Supplier Name</th>
                    <th>Email</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($suppliers)): ?>

                <tr>

                    <td>
                        <?php echo $row['supplier_id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['supplier_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>

                    <td>

                        <a href="?delete=<?php echo $row['supplier_id']; ?>"
                           onclick="return confirm('Delete this supplier?')">

                            ❌ Delete

                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>


    <!-- BACK BUTTON -->

    <div class="back-btn">

        <a href="<?php echo htmlspecialchars(APP_BASE . '/' . role_dashboard_path($_SESSION['role'])) ?>">

            ← Back

        </a>

    </div>

</div>

</body>

</html>