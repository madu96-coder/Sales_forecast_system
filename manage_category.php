<?php
include 'includes/auth.php';
include 'includes/config.php';

checkRole(['admin']);

//add category

if (isset($_POST['add_category'])){
    $name = $_POST['category_name'];


    if(!empty($name)){
        $sql ="INSERT INTO category (category_name) VALUES ('$name')";
        mysqli_query($conn,$sql);
        header("Location: manage_category.php?success=1");
        exit();
    }
}
// soft delete category

if(isset($_GET['delete'] )){
    $id = $_GET['delete'];

    $sql = "UPDATE category SET status = 'inactive' WHERE category_id = $id AND status = 'active'";

    if(mysqli_query($conn, $sql)){
        header("Location: manage_category.php?deleted=1");
        exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}

// update category
if(isset($_POST['update_category'] )){
    $id = $_POST['category_id'];
    $name = $_POST['category_name'];

    if(!empty($name)){
        $sql = "UPDATE category SET category_name='$name' WHERE category_id=$id";
        mysqli_query($conn, $sql);

        header("Location: manage_category.php?updated=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Categories</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="login-box">
            <h2>Manage Categories</h2>

            <!-- success message-->
             <?php if(isset($_GET['success'] )): ?>
                <p style="color:green;">Category added successfully</p>
                <?php endif; ?>

                <?php if(isset($_GET['deleted'])): ?>
                    <p style="color:red;">Category removed (inactive)</p>
                    <?php endif; ?>

                    <?php if(isset($_GET['updated'])): ?>
                        <p style="color:blue">Category updated</p>
                        <?php endif; ?>

                <!--add category form-->
                <form method="POST">
                    <label >Category Name</label>
                    <input type="text" name="category_name" required>
                    
                    <button type="submit" name="add_category"> Add Category</button>
                </form>
                <hr>

                <!--category list-->
                <h3>Existing Category</h3>

                <table border="1" width="100%" cellpadding="10">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>

                    <?php //only show active categories
                    $result = mysqli_query($conn, "SELECT * FROM category WHERE status = 'active'");

                    while($row = mysqli_fetch_assoc($result) ){
                        ?>
                        <tr>
                            <td><?php echo $row['category_id']; ?></td>
                            <td>
                                <form method="POST" style="display:flex; gap:10px;">
                                    <input type="hidden" name="category_id" value="<?php echo $row['category_id']; ?>">

                                    <input type="text" name="category_name" value="<?php echo $row['category_name']; ?>">

                                    <button type="submit" name="update_category">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="manage_category.php?delete=<?php echo $row['category_id']; ?>" 
                                onclick="return confirm('Delete this category?')" style="color:red;">
                                Delete
                                    
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
                <br>
                <a href="inactive_categories.php" style="color:orange;">
                    View Removed Categories
                </a>

               

                <br>
                <a href="admin/dashboard.php">← Back </a>

        </div>
    </body>
</html>