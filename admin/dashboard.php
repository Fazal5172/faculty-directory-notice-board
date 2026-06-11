<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireAdmin();

$userModel   = new User();
$noticeModel = new Notice();

$allUsers    = $userModel->getAll();
$allNotices  = $noticeModel->getAll();
$pending     = $userModel->getPendingRequests();

$totalUsers   = count($allUsers);
$totalNotices = count($allNotices);
$totalPending = count($pending);

$pageTitle = 'Dashboard — Admin';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
    <h1>Admin Dashboard</h1>
</div>

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-bottom:2rem;">
    <div class="card" style="text-align:center; padding:1.5rem;">
        <div style="font-size:2.2rem; font-weight:700; color:var(--primary);"><?= $totalUsers ?></div>
        <div style="color:var(--muted); font-size:.9rem;">Total Users</div>
    </div>
    <div class="card" style="text-align:center; padding:1.5rem;">
        <div style="font-size:2.2rem; font-weight:700; color:var(--secondary);"><?= $totalNotices ?></div>
        <div style="color:var(--muted); font-size:.9rem;">Total Notices</div>
    </div>
    <div class="card" style="text-align:center; padding:1.5rem;">
        <div style="font-size:2.2rem; font-weight:700; color:var(--accent);"><?= $totalPending ?></div>
        <div style="color:var(--muted); font-size:.9rem;">Pending Requests</div>
    </div>
</div>

<!-- Recent Notices -->
<div class="card">
    <div class="page-header" style="margin-bottom:1rem;">
        <h2 style="margin:0;">Recent Notices</h2>
        <a href="<?= APP_URL ?>/admin/notices.php" class="btn btn-primary btn-sm">Manage All</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Subject</th><th>Visibility</th><th>Date</th><th>Publisher</th></tr></thead>
            <tbody>
            <?php foreach (array_slice($allNotices, 0, 5) as $n): ?>
                <tr>
                    <td><?= htmlspecialchars($n['subject']) ?></td>
                    <td><?= htmlspecialchars($n['category']) ?></td>
                    <td><?= htmlspecialchars($n['date']) ?></td>
                    <td><?= htmlspecialchars($n['user']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
