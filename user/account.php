<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireUser();

$userModel = new User();
$user = $userModel->findById($_SESSION['user_id']);
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    if ($name === '' || $email === '') {
        $error = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif ($password !== '' && strlen($password) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $updated = $userModel->update($_SESSION['user_id'], $name, $email, $password);
        if ($updated) {
            $_SESSION['user_name']  = $name;
            $_SESSION['user_email'] = $email;
            $success = 'Account updated successfully.';
            $user = $userModel->findById($_SESSION['user_id']);
        } else {
            $error = 'No changes were made.';
        }
    }
}

$pageTitle = 'My Account — ' . APP_NAME;
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="page-header">
    <h1>My Account</h1>
</div>

<div class="card" style="max-width:520px;">
    <?php if ($error):   ?><div class="alert alert-danger"><?=  htmlspecialchars($error)   ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['u_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['u_email']) ?>" required>
        </div>
        <div class="form-group">
            <label>New Password <small style="color:var(--muted)">(leave blank to keep current)</small></label>
            <input type="password" name="password" minlength="6">
        </div>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm">
        </div>
        <button type="submit" class="btn btn-primary">Update Account</button>
        <a href="<?= APP_URL ?>/user/dashboard.php" class="btn" style="background:var(--border); color:var(--text); margin-left:.5rem;">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
