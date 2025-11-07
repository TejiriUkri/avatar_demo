<?php
// Better error handling
try {
    require_once 'config/config.php';
    require_once 'config/pdo_db.php';
    require_once 'Models/User.php';
} catch (Exception $e) {
    die('Configuration error: ' . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styled.css" />
</head>
<body>
    <main class="login-container" role="main" aria-labelledby="loginHeading">
        <h2 id="loginHeading">Login</h2>
        <form action="process_login.php" method="POST" novalidate>
            <?php
            if(isset($_SESSION['invalid'])){ echo $_SESSION['invalid'];}
            ?>
            <!-- CSRF protection token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>" />

            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="email" name="email" required aria-required="true" autocomplete="username" />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required aria-required="true" autocomplete="current-password" />
            </div>
            <p style="text-align: right; margin-top: 10px;">
                <a href="forgot_password">Forgot your password?</a>
            </p>
            <button type="submit" class="btn">Login</button>
        </form>
<p style="text-align: center; margin-top: 15px;">Not a member? <a href="setup">Sign up here</a></p>
    </main>
</body>
</html>
