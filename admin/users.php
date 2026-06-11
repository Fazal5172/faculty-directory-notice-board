<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireAdmin();

$userModel = new User();
$error = $success = '';

// Handle DELETE
if (isset($_GET['delete'])) {
    $id = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
    if ($id && $userModel->delete($id)) {
        $success = 'User deleted.';
    }
}

// Handle ADD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $name     = trim($_POST['name']      ?? '');
    $email    = trim($_POST['email']     ?? '');
    $password = trim($_POST['password']  ?? '');
    $type     = trim($_POST['user_type'] ?? '');
    $status   = trim($_POST['status']    ?? '');

    if (!$name || !$email || !$password || !$type || !$status) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        $created = $userModel->adminCreate($name, $email, $password, $type, $status);
        if ($created) {
            $success = 'User added.';
        } else {
            $error = 'Email already exists.';
        }
    }
}

$users = $userModel->getAll();
$pageTitle = 'Manage Users — Admin';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
    <h1>Manage Users</h1>
    <button onclick="document.getElementById('addForm').style.display='block'; this.style.display='none';"
            class="btn btn-primary btn-sm">+ Add User</button>
</div>

<?php if ($error):   ?><div class="alert alert-danger"><?=  htmlspecialchars($error)   ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<!-- Add User Form -->
<div id="addForm" style="display:none;" class="card">
    <h2>Add New User</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required minlength="6">
            </div>
            <div class="form-group">
                <label>User Type</label>
                <select name="user_type" required>
                    <option value="">Select...</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Accepted">Accepted</option>
                    <option value="Pending">Pending</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save User</button>
        <button type="button" class="btn" style="background:var(--border);color:var(--text);"
                onclick="document.getElementById('addForm').style.display='none';">Cancel</button>
    </form>
</div>

<!-- Users Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['u_name']) ?></td>
                    <td><?= htmlspecialchars($u['u_email']) ?></td>
                    <td><?= htmlspecialchars($u['u_type']) ?></td>
                    <td>
                        <?php
                        $badgeClass = match($u['status']) {
                            'Accepted' => 'badge-success',
                            'Rejected' => 'badge-danger',
                            default    => 'badge-warning',
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($u['status']) ?></span>
                    </td>
                    <td>
                        <a href="<?= APP_URL ?>/admin/requests.php?accept=<?= (int)$u['u_id'] ?>" class="btn btn-success btn-sm">Accept</a>
                        <a href="<?= APP_URL ?>/admin/requests.php?reject=<?= (int)$u['u_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                        <a href="?delete=<?= (int)$u['u_id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
