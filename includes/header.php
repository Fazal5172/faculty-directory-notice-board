<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/contact-widget.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>
<nav class="navbar">
    <div class="nav-brand"><?= APP_NAME ?></div>
    <div class="nav-links">
        <?php if (!empty($_SESSION['user_name'])): ?>
            <span style="color:rgba(255,255,255,.75); font-size:.9rem; margin-right:.5rem;">
                <?= htmlspecialchars($_SESSION['user_name']) ?>
            </span>
        <?php endif; ?>
        <a href="<?= APP_URL ?>/user/dashboard.php">Home</a>
        <a href="<?= APP_URL ?>/user/account.php">My Account</a>
        <a href="<?= APP_URL ?>/user/logout.php">Logout</a>
    </div>
</nav>
<div class="container">
