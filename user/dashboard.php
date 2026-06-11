<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireUser();

$noticeModel = new Notice();
$notices = $noticeModel->getForUser($_SESSION['user_email'], $_SESSION['user_type']);
$pageTitle = 'Dashboard — ' . APP_NAME;
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="page-header">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
    <span class="badge badge-success"><?= htmlspecialchars($_SESSION['user_type']) ?></span>
</div>

<h2 style="color:var(--primary); margin-bottom:1rem;">
    Latest Notices for <?= htmlspecialchars($_SESSION['user_type']) ?>s
</h2>

<?php if (empty($notices)): ?>
    <div class="alert alert-info">No notices available at the moment.</div>
<?php else: ?>
    <?php foreach ($notices as $notice): ?>
        <div class="notice-item">
            <h3><?= htmlspecialchars($notice['subject']) ?></h3>
            <div class="meta">
                Posted on <?= htmlspecialchars($notice['date']) ?>
                &nbsp;|&nbsp; By: <?= htmlspecialchars($notice['role']) ?>
                &nbsp;|&nbsp; To: <?= htmlspecialchars($notice['category']) ?>
            </div>
            <p style="margin:.5rem 0; font-size:.9rem; color:var(--muted);">
                <?= htmlspecialchars(substr($notice['detail'], 0, 120)) ?>...
            </p>
            <a href="<?= APP_URL ?>/user/notice.php?id=<?= (int)$notice['ID'] ?>">Read More &rarr;</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
