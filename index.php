<?php
require_once __DIR__ . '/includes/bootstrap.php';

// Redirect if already logged in
if (Auth::isUserLoggedIn()) {
    header('Location: ' . APP_URL . '/user/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        $userModel = new User();
        $user = $userModel->login($email, $password);

        if ($user) {
            Auth::loginUser($user);
            header('Location: ' . APP_URL . '/user/dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials or account not yet approved.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <h1><?= APP_NAME ?></h1>
        <p>Sign in to your account</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="<?= APP_URL ?>/user/register.php">Register here</a>
        </div>
    </div>
</div>
</body>
</html>
