<?php
require_once __DIR__ . '/../includes/bootstrap.php';
Auth::requireAdmin();

$noticeModel = new Notice();
$userModel   = new User();
$error = $success = '';

// Handle DELETE
if (isset($_GET['delete'])) {
    $id = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
    if ($id && $noticeModel->delete($id)) {
        $success = 'Notice deleted.';
    }
}

// Handle ADD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $subject  = trim($_POST['subject']  ?? '');
    $detail   = trim($_POST['detail']   ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($subject === '' || $detail === '' || $category === '' || $category === '0') {
        $error = 'All fields are required.';
    } else {
        $noticeModel->create(
            $subject, $detail, $category,
            $_SESSION['admin_name'], $_SESSION['admin_role']
        );
        $success = 'Notice published successfully.';
    }
}

// Handle EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id       = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $subject  = trim($_POST['subject']  ?? '');
    $detail   = trim($_POST['detail']   ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($id && $subject && $detail && $category) {
        $noticeModel->update($id, $subject, $detail, $category);
        $success = 'Notice updated.';
    }
}

$notices      = $noticeModel->getAll();
$acceptedUsers = $userModel->getAll();
$editNotice   = null;

if (isset($_GET['edit'])) {
    $editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
    if ($editId) {
        $editNotice = $noticeModel->findById($editId);
    }
}

$pageTitle = 'Manage Notices — Admin';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
    <h1><?= $editNotice ? 'Edit Notice' : 'Manage Notices' ?></h1>
    <?php if (!$editNotice): ?>
        <button onclick="document.getElementById('addForm').style.display='block'; this.style.display='none';"
                class="btn btn-primary btn-sm">+ Add Notice</button>
    <?php endif; ?>
</div>

<?php if ($error):   ?><div class="alert alert-danger"><?=  htmlspecialchars($error)   ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<!-- Add Form -->
<?php if (!$editNotice): ?>
<div id="addForm" style="display:none;" class="card">
    <h2>Publish New Notice</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" required>
        </div>
        <div class="form-group">
            <label>Detail</label>
            <textarea name="detail" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label>Send To</label>
            <select name="category" required>
                <option value="0">Select audience...</option>
                <option value="All Students">All Students</option>
                <option value="All Teachers">All Teachers</option>
                <?php foreach ($acceptedUsers as $u): ?>
                    <?php if ($u['status'] === 'Accepted'): ?>
                    <option value="<?= htmlspecialchars($u['u_email']) ?>">
                        <?= htmlspecialchars($u['u_type'] . ': ' . $u['u_name'] . ' (' . $u['u_email'] . ')') ?>
                    </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Publish</button>
        <button type="button" class="btn" style="background:var(--border);color:var(--text);"
                onclick="document.getElementById('addForm').style.display='none';">Cancel</button>
    </form>
</div>
<?php endif; ?>

<!-- Edit Form -->
<?php if ($editNotice): ?>
<div class="card">
    <h2>Edit Notice</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= (int)$editNotice['ID'] ?>">
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($editNotice['subject']) ?>" required>
        </div>
        <div class="form-group">
            <label>Detail</label>
            <textarea name="detail" rows="4" required><?= htmlspecialchars($editNotice['detail']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Send To</label>
            <select name="category" required>
                <option value="All Students"   <?= $editNotice['category'] === 'All Students'  ? 'selected' : '' ?>>All Students</option>
                <option value="All Teachers"   <?= $editNotice['category'] === 'All Teachers'  ? 'selected' : '' ?>>All Teachers</option>
                <?php foreach ($acceptedUsers as $u): ?>
                    <?php if ($u['status'] === 'Accepted'): ?>
                    <option value="<?= htmlspecialchars($u['u_email']) ?>"
                        <?= $editNotice['category'] === $u['u_email'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['u_type'] . ': ' . $u['u_name']) ?>
                    </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= APP_URL ?>/admin/notices.php" class="btn" style="background:var(--border);color:var(--text);">Cancel</a>
    </form>
</div>
<?php endif; ?>

<!-- Notices Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Subject</th><th>Visibility</th><th>Date</th><th>Publisher</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($notices as $n): ?>
                <tr>
                    <td><?= (int)$n['ID'] ?></td>
                    <td><?= htmlspecialchars($n['subject']) ?></td>
                    <td><?= htmlspecialchars($n['category']) ?></td>
                    <td><?= htmlspecialchars($n['date']) ?></td>
                    <td><?= htmlspecialchars($n['user']) ?></td>
                    <td>
                        <a href="?edit=<?= (int)$n['ID'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?delete=<?= (int)$n['ID'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this notice?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
