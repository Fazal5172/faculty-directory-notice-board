<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin — ' . APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/contact-widget.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .navbar { background: #0d2137; }
        .sidebar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .sidebar a {
            display: inline-block;
            padding: .5rem 1.1rem;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: .88rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: background .2s;
        }
        .sidebar a:hover, .sidebar a.active { background: var(--primary); color: var(--white); }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-brand"><?= APP_NAME ?> &mdash; Admin</div>
    <div class="nav-links">
        <span style="color:rgba(255,255,255,.7); font-size:.9rem;">
            <?= htmlspecialchars($_SESSION['admin_name'] ?? '') ?>
        </span>
        <a href="<?= APP_URL ?>/admin/logout.php">Logout</a>
    </div>
</nav>
<div class="container">
    <div class="sidebar">
        <a href="<?= APP_URL ?>/admin/dashboard.php">Dashboard</a>
        <a href="<?= APP_URL ?>/admin/notices.php">Notices</a>
        <a href="<?= APP_URL ?>/admin/users.php">Users</a>
        <a href="<?= APP_URL ?>/admin/requests.php">Requests</a>
    </div>
