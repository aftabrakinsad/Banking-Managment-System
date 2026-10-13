<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$errors = [];
$v = ['title' => '', 'details' => '', 'assignee' => '', 'due' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = isset($_POST['action']) ? $_POST['action'] : 'add';
    if ($action === 'add') {
        $v['title'] = trim(isset($_POST['title']) ? $_POST['title'] : '');
        $v['details'] = trim(isset($_POST['details']) ? $_POST['details'] : '');
        $v['assignee'] = isset($_POST['assignee']) ? $_POST['assignee'] : '';
        $v['due'] = trim(isset($_POST['due']) ? $_POST['due'] : '');
        $parts = explode('|', $v['assignee'], 2);
        $valid = array_merge(
            array_map(function ($u) { return 'manager|' . $u; }, adb()->managerUsernames()),
            array_map(function ($e) { return 'employee|' . $e['username']; }, adb()->employees())
        );
        if ($v['title'] === '' || strlen($v['title']) > 120) { $errors[] = 'Enter a task title (up to 120 characters).'; }
        if (strlen($v['details']) > 2000) { $errors[] = 'Details are too long.'; }
        if (!in_array($v['assignee'], $valid, true)) { $errors[] = 'Choose who the task is for.'; }
        if ($v['due'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v['due'])) { $errors[] = 'Enter a valid due date.'; }
        if (!$errors) {
            adb()->addTask($v['title'], $v['details'], $parts[0], $parts[1], $v['due']);
            log_activity('admin', $admin['uname'], 'assigned_task', $parts[1] . ': ' . $v['title']);
            flash('success', 'Task assigned to ' . $parts[1] . '.');
            redirect('/Admin/View/tasks.php');
        }
    } else {
        $tid = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
        if ($action === 'done' || $action === 'reopen') { adb()->setTaskStatus($tid, $action === 'done' ? 'done' : 'open'); }
        if ($action === 'delete') { adb()->deleteTask($tid); log_activity('admin', $admin['uname'], 'deleted_task', '#' . $tid); }
        redirect('/Admin/View/tasks.php');
    }
}
$tasks = adb()->tasks();
$managers = adb()->managerUsernames();
$employees = adb()->employees();
$pageTitle = 'Tasks';
require __DIR__ . '/header.php';
?>
<h1>Assign work</h1>
<section class="grid">
    <div class="card">
        <h2>New task</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="add">
            <label>Title <input type="text" name="title" maxlength="120" value="<?php echo h($v['title']); ?>" required></label>
            <label>Details <textarea name="details" maxlength="2000"><?php echo h($v['details']); ?></textarea></label>
            <label>Assign to
                <select name="assignee" required>
                    <option value="">- choose -</option>
                    <optgroup label="Managers">
                        <?php foreach ($managers as $m) { ?><option value="manager|<?php echo h($m); ?>"<?php echo $v['assignee'] === 'manager|' . $m ? ' selected' : ''; ?>><?php echo h($m); ?></option><?php } ?>
                    </optgroup>
                    <optgroup label="Employees">
                        <?php foreach ($employees as $e) { ?><option value="employee|<?php echo h($e['username']); ?>"<?php echo $v['assignee'] === 'employee|' . $e['username'] ? ' selected' : ''; ?>><?php echo h($e['username']); ?></option><?php } ?>
                    </optgroup>
                </select>
            </label>
            <label>Due date (optional) <input type="date" name="due" value="<?php echo h($v['due']); ?>"></label>
            <button class="btn" type="submit">Assign task</button>
        </form>
    </div>
    <div class="card">
        <h2>All tasks (<?php echo count($tasks); ?>)</h2>
        <?php if (!$tasks) { ?><p class="muted">No tasks yet.</p><?php } ?>
        <ul class="list">
        <?php foreach ($tasks as $t) { ?>
            <li>
                <span>
                    <strong<?php echo $t['status'] === 'done' ? ' style="text-decoration:line-through"' : ''; ?>><?php echo h($t['title']); ?></strong><br>
                    <span class="muted small"><?php echo h($t['assignee_role']); ?>: <?php echo h($t['assignee_username']); ?><?php echo $t['due_date'] ? ' · due ' . h($t['due_date']) : ''; ?></span>
                    <?php if ($t['details'] !== '') { ?><br><span class="small"><?php echo h($t['details']); ?></span><?php } ?>
                </span>
                <span class="row-actions">
                    <form method="post"><?php echo csrf_field(); ?><input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                        <button class="btn btn-small btn-ghost" name="action" value="<?php echo $t['status'] === 'done' ? 'reopen' : 'done'; ?>"><?php echo $t['status'] === 'done' ? 'Reopen' : 'Mark done'; ?></button>
                    </form>
                    <form method="post" onsubmit="return confirm('Delete this task?');"><?php echo csrf_field(); ?><input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                        <button class="btn btn-small btn-danger" name="action" value="delete">Delete</button>
                    </form>
                </span>
            </li>
        <?php } ?>
        </ul>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
