
<?php
include 'includes/auth.php';
include 'includes/config.php';

// only admin allowed
checkRole(['admin']);

// =============================
// ADD USER
// =============================
if(isset($_POST['add_user'])) {

    // sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // check duplicate username
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if(mysqli_num_rows($check) > 0){
        header("Location: manage_users.php?error=exists");
        exit();
    }

    // insert user
    $sql = "INSERT INTO users (username, password, role, status)
            VALUES ('$username', '$password', '$role', 'active')";
    
    mysqli_query($conn, $sql);

    header("Location: manage_users.php?success=1");
    exit();
}


// =============================
// DELETE USER (SOFT DELETE)
// =============================

if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // check role of user
    $check = mysqli_query($conn, "SELECT role FROM users WHERE user_id=$id");
    $user = mysqli_fetch_assoc($check);

    // ❌ prevent deleting admin
    if($user['role'] == 'admin'){
        header("Location: manage_users.php?error=admin");
        exit();
    }

    // ✅ soft delete others
    mysqli_query($conn, "UPDATE users SET status='inactive' WHERE user_id=$id");

    header("Location: manage_users.php?deleted=1");
    exit();
}

// =============================
// FETCH ACTIVE USERS
// =============================
$result = mysqli_query($conn, "SELECT * FROM users WHERE status='active'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/Sales-forecast-system/style.css">
</head>

<body>
<div class="login-box">

    <h2>Manage Users</h2>

    <!-- SUCCESS MESSAGES -->

    <?php if(isset($_GET['success'])): ?>
        <p style="color:green;">User added successfully</p>
    <?php endif; ?>

    <?php if(isset($_GET['deleted'])): ?>
        <p style="color:red;">User deactivated successfully</p>
    <?php endif; ?>

    <?php if(isset($_GET['updated'])): ?>
        <p style="color:green;">User updated successfully</p>
    <?php endif; ?>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
        <p style="color:red;">Username already exists</p>
    <?php endif; ?>

    <?php if(isset($_GET['error']) && $_GET['error']=='admin'): ?>
    <p style="color:red;">Admin user cannot be deleted</p>
     <?php endif; ?>


    <form method="POST" autocomplete="off">

        <input type="text" name="username" placeholder="Username" required autocomplete="off">

        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="sales_manager">Sales Manager</option>
            <option value="product_manager">Product Manager</option>
            <option value="inventory_manager">Inventory Manager</option>
        </select>

        <button type="submit" name="add_user">Add User</button>
    </form>

    <br>

    <a href="inactive_users.php">View Inactive Users</a>

    <br><br>

    <table border="1" width="100%">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="<?php echo ($row['role'] == 'admin') ? 'admin-row' : ''; ?>"> <!-- highlight admin users -->
        
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    

                    <?php if($row['role'] != 'admin'): ?> <!-- prevent delete option for admin users -->
                        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a> 
                           <a href="manage_users.php?delete=<?php echo $row['user_id']; ?>" 
                          onclick="return confirm('Delete this user?')">Delete</a>
                            <?php else: ?>
                                <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
                             <span style="color:gray;">Protected</span>
                                 <?php endif; ?>|

                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="admin/dashboard.php">⬅ Back</a>

</div>

<script>
setTimeout(() => {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.pathname);
    }
}, 500);
</script>

</body>
</html>