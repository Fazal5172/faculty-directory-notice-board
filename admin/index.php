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
    
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
<div class="auth-wrapper-admin" style="background:#1a3c5e;">
<div class="top-backtouser">
    <a href="<?= APP_URL ?>/index.php">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Teacher / Student Login
    </a>
</div>
    <div class="auth-card">


    <div class="brand">
    <h1>Faculty Directory</h1>
    <p class="brand-subtitle">University Notice Board System</p>
    <p class="login-subtitle">
        <i class="fas fa-lock"></i> Administrator Sign In
    </p>
</div>



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

<!-- Demo Credentials -->

<div class="demo-box">

<div class="demo-title">
<i class="fa-solid fa-flask"></i>
DEMO CREDENTIALS
</div>


<!-- Teacher -->

<div class="demo-card">




<div class="credential">

<span id="teacher-email">
admin@university.edu
</span>

<button class="copy-btn"
onclick="copyText('teacher-email',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>

<div class="credential">

<span id="teacher-pass">
adminpassword
</span>

<button class="copy-btn"
onclick="copyText('teacher-pass',this)">
<i class="fa-regular fa-copy"></i>
</button>

</div>

</div>
</div>
<script src="<?= APP_URL ?>/assets/js/auth.js"></script>
</body>
</body>
</html>
