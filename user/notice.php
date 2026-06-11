<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireUser();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: ' . APP_URL . '/user/dashboard.php');
    exit;
}

$noticeModel = new Notice();
$notice = $noticeModel->findById($id);

if (!$notice) {
    header('Location: ' . APP_URL . '/user/dashboard.php');
    exit;
}

$pageTitle = htmlspecialchars($notice['subject']) . ' — ' . APP_NAME;
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="card">
    <a href="<?= APP_URL ?>/user/dashboard.php" style="font-size:.88rem; color:var(--primary);">&larr; Back to Dashboard</a>
    <h1 style="font-size:1.4rem; color:var(--primary); margin:1rem 0 .3rem;">
        <?= htmlspecialchars($notice['subject']) ?>
    </h1>
    <p style="color:var(--muted); font-size:.85rem; margin-bottom:1.2rem;">
        Published on <?= htmlspecialchars($notice['date']) ?>
        &nbsp;|&nbsp; By: <?= htmlspecialchars($notice['role']) ?>
        &nbsp;|&nbsp; Visibility: <?= htmlspecialchars($notice['category']) ?>
    </p>
    <hr style="border:none; border-top:1px solid var(--border); margin-bottom:1.2rem;">
    <p style="line-height:1.7;"><?= nl2br(htmlspecialchars($notice['detail'])) ?></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
