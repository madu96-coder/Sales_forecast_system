<?php
include 'includes/auth.php';
include 'includes/config.php';

// only admin allowed
checkRole(['admin']);

// ===============================
//  SECURE ID (prevent issues)
// ===============================
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = (int)$_GET['id']; // safer

// ===============================
// FETCH USER DATA
// ===============================
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$id'");
$user = mysqli_fetch_assoc($result);

// ===============================
// UPDATE USER
// ===============================
if(isset($_POST['update'])){   

    // sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // ===============================
    // CHECK DUPLICATE USERNAME
    // ===============================
    $check = mysqli_query($conn, 
        "SELECT * FROM users WHERE username='$username' AND user_id != '$id'"
    );

    if(mysqli_num_rows($check) > 0){
        $error = "Username already taken!";
    } else {

        // ===============================
        // REMOVE PASSWORD HASHING
        // ===============================
        if(!empty($_POST['password'])){

        
        
              //plain text password
        
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $sql = "UPDATE users 
                    SET username='$username', password='$password', role='$role'
                    WHERE user_id='$id'";
        } else {

            // ===============================
            // NO PASSWORD CHANGE
            // ===============================
            $sql = "UPDATE users 
                    SET username='$username', role='$role'
                    WHERE user_id='$id'";
        }

        // ===============================
        // EXECUTE UPDATE
        // ===============================
        if(mysqli_query($conn, $sql)){
            header("Location: manage_users.php?updated=1");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>Edit User</h2>

    <!-- SHOW ERROR -->
    <?php if(isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

        <label>New Password</label>
        <input type="password" name="password">

        <label>Role</label>
        <select name="role" required>
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
            <option value="sales_manager" <?php if($user['role']=='sales_manager') echo 'selected'; ?>>Sales Manager</option>
            <option value="production_manager" <?php if($user['role']=='production_manager') echo 'selected'; ?>>Production Manager</option>
            <option value="inventory_manager" <?php if($user['role']=='inventory_manager') echo 'selected'; ?>>Inventory Manager</option>
        </select>

        <br><br>
        <button type="submit" name="update">Update User</button>

    </form>

    <br>
    <a href="manage_users.php">⬅ Back</a>

</div>

</body>
</html>