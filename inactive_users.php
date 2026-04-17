<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin']);

//  RESTORE USER
if(isset($_GET['restore'])){
    $id = $_GET['restore'];

    $sql = "UPDATE users SET status='active' WHERE user_id='$id'";
    
    if(mysqli_query($conn, $sql)){
        header("Location: inactive_users.php?restored=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

//  GET INACTIVE USERS
$result = mysqli_query($conn, "SELECT * FROM users WHERE status='inactive'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inactive Users</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h2>Inactive Users</h2>

    <!-- SUCCESS MESSAGE -->
    <?php if(isset($_GET['restored'])): ?>
        <p style="color:green;">User restored successfully</p>
    <?php endif; ?>

    <table border="1" width="100%">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <a href="inactive_users.php?restore=<?php echo $row['user_id']; ?>"
                       onclick="return confirm('Restore this user?')">
                        Restore
                    </a>
                </td>
            </tr>
        <?php } ?>

    </table>

    <br>
    <a href="manage_users.php">← Back to Manage Users</a>

</div>

</body>
</html>