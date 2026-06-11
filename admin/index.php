<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (Auth::isAdminLoggedIn()) {
    header('Location: ' . APP_URL . '/admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        $adminModel = new Admin();
        $admin = $adminModel->login($email, $password);

        if ($admin) {
            Auth::loginAdmin($admin);
            header('Location: ' . APP_URL . '/admin/dashboard.php');
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-wrapper" style="background:#1a3c5e;">
    <div class="auth-card">
        <h1><?= APP_NAME ?></h1>
        <p>Administrator Sign In</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Admin Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Sign In as Admin</button>
        </form>
    </div>
</div>
</body>
</html>
