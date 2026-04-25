<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/roles.php';

$error = '';

if (!empty($_GET['access_denied'])) {
    $error = 'That page is not available for your account. Sign in below.';
}

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username ='$username' AND password ='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = (int) $user['id'];
        $role = normalize_user_role($user['role'] ?? '');
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $user['username'];

        $dash = role_dashboard_path($role);
        if ($dash === 'login.php') {
            $error = 'Invalid role for this account. Contact an administrator.';
        } else {
            header('Location: ' . APP_BASE . '/' . $dash); // app base use to show correct project path (file name can be changed without error)
            exit();
        }
    } else {
        $error = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — Sales Forecast System</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars(APP_BASE); ?>/style.css">
</head>

<body class="login-page">

    <?php if (!empty($error)): ?> <!-- htmlspecialchars = use to protect website from breaking/safely display user input in html -->
        <div class="login-page__alert alert-box" role="alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="login-page__shell">
        <div class="login-container">
            <header class="login-brand">
                <div class="login-brand__mark" aria-hidden="true"></div>
                <h1 class="login-brand__title">Sales Forecast System</h1>
                <p class="login-brand__tagline">Analytics &amp; inventory — sign in to continue</p>
            </header>

            <form class="login-form" method="post" autocomplete="on">
                <h2 class="login-form__heading">Sign in</h2>

                <div class="login-field">
                    <label class="login-field__label" for="login-username">Username</label>
                    <input class="login-field__input" id="login-username" type="text" name="username" placeholder="Enter your username" required autocomplete="on">
                </div>

                <div class="login-field">
                    <label class="login-field__label" for="login-password">Password</label>
                    <input class="login-field__input" id="login-password" type="password" name="password" placeholder="Enter your password" required autocomplete="on">
                </div>

                <button class="login-submit" type="submit" name="login" value="1">Sign in</button>
            </form>
        </div>
    </div>
</body>
</html>
