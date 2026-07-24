<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (Auth::isUserLoggedIn()) {
    header('Location: ' . APP_URL . '/user/dashboard.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = trim($_POST['name']      ?? '');
    $email     = trim($_POST['email']     ?? '');
    $password  = trim($_POST['password']  ?? '');
    $confirm   = trim($_POST['confirm']   ?? '');
    $userType  = trim($_POST['user_type'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $userType === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (!in_array($userType, ['Student', 'Teacher'], true)) {
        $error = 'Invalid user type selected.';
    } else {
        $userModel = new User();
        $registered = $userModel->register($name, $email, $password, $userType);

        if ($registered) {
            $success = 'Registration submitted! Please wait for admin approval before logging in.';
        } else {
            $error = 'This email address is already registered.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">

    <div class="brand">
    <h1>Faculty Directory</h1>
    <p class="brand-subtitle">University Notice Board System</p>
    <p>Create your account</p>
</div>



        <?php if ($error):   ?><div class="alert alert-danger"><?=  htmlspecialchars($error)   ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="user_type">I am a</label>
                <select id="user_type" name="user_type" required>
                    <option value="">Select role...</option>
                    <option value="Student"  <?= (($_POST['user_type'] ?? '') === 'Student')  ? 'selected' : '' ?>>Student</option>
                    <option value="Teacher"  <?= (($_POST['user_type'] ?? '') === 'Teacher')  ? 'selected' : '' ?>>Teacher</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Register</button>
        </form>
        <?php endif; ?>

        <div class="auth-footer">
            Already have an account? <a href="<?= APP_URL ?>/index.php">Sign in</a>
        </div>
    </div>
</div>
</body>
</html>
