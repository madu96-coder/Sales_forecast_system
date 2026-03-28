<?php
//start session to store user data
session_start();
include("config.php"); //include database connection
$error = ""; //store error message

//check login button

if (isset($_POST['login'])) {

// get from data
$username = $_POST['username'];
$password = $_POST['password'];

//check user in databse
$query = "SELECT * FROM users WHERE username ='$username' AND password ='$password'";
$result = mysqli_query($conn,$query);

//check if user exist
if(mysqli_num_rows($result) > 0){

//store username in session
$_SESSION['user'] = $username;
 

// redirect to dashboard
header("Location: dashboard.php");

}else{
    $error = "Invalid username or password!"; //show error if login fails
}


} 
?>

<!DOCTYPE html>
<html>
    <head>

    <title>Login</title>

    <!-- connect css-->

    <link rel="stylesheet" href="http://localhost/Sales_forecast_system/style.css">
    </head>
    
    <body>
        <!-- ERROR MESSAGE HERE -->
           <?php if(!empty($error)): ?>
               <div class="alert-box">
                    <?php echo $error; ?>
             </div>
                    <?php endif; ?>

    
        
    <div class="login-container">
        <h2>Sales Forecast System</h2>

<!--login from-->
<form method="POST">
    <h2>Login</h2>

    <!-- input for username -->
     Username <input type="text" name="username" placeholder="Username" required><br><br>

     <!--input password-->
     Password <input type="password" name="password" placeholder="Password" required ><br><br>

     <!-- login button-->
      <button name="login">Login</button>



</form>
<?php 
if(isset($error)){
    echo "<p class='error'>$error</p>";
}
?>
    </div>
    </body>
    </html>
