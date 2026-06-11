<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireAdmin();

$userModel = new User();
$success   = '';

// Accept a request
if (isset($_GET['accept'])) {
    $id = filter_input(INPUT_GET, 'accept', FILTER_VALIDATE_INT);
    if ($id && $userModel->updateStatus($id, 'Accepted')) {
        $success = 'User approved successfully.';
    }
}

// Reject a request
if (isset($_GET['reject'])) {
    $id = filter_input(INPUT_GET, 'reject', FILTER_VALIDATE_INT);
    if ($id && $userModel->updateStatus($id, 'Rejected')) {
        $success = 'User rejected.';
    }
}

$pending   = $userModel->getPendingRequests();
$pageTitle = 'Registration Requests — Admin';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
    <h1>Registration Requests</h1>
    <span class="badge badge-warning"><?= count($pending) ?> Pending</span>
</div>

<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (empty($pending)): ?>
    <div class="alert alert-info">No pending registration requests.</div>
<?php else: ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($pending as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['u_name']) ?></td>
                        <td><?= htmlspecialchars($u['u_email']) ?></td>
                        <td><?= htmlspecialchars($u['u_type']) ?></td>
                        <td><span class="badge badge-warning"><?= htmlspecialchars($u['status']) ?></span></td>
                        <td>
                            <a href="?accept=<?= (int)$u['u_id'] ?>" class="btn btn-success btn-sm">✓ Approve</a>
                            <a href="?reject=<?= (int)$u['u_id'] ?>" class="btn btn-danger btn-sm">✗ Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
