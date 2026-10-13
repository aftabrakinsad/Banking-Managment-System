<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();

$role = isset($_GET['role']) && $_GET['role'] === 'employee' ? 'employee' : 'manager';
$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$person = $role === 'manager' ? adb()->manager($id) : adb()->employee($id);
if (!$person) { flash('error', 'Staff member not found.'); redirect('/Admin/View/staff.php'); }
$username = $person['username'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'remove') {
        $gone = $role === 'manager' ? adb()->removeManager($id) : adb()->removeEmployee($id);
        log_activity('admin', $admin['uname'], 'removed_' . $role, (string)$gone);
        flash('success', ucfirst($role) . ' ' . $gone . ' removed.');
        redirect('/Admin/View/staff.php');
    }
    if ($action === 'role') {
        $to = $role === 'manager' ? 'employee' : 'manager';
        $res = adb()->changeRole($id, $to);
        if ($res[0]) {
            log_activity('admin', $admin['uname'], 'changed_role', $res[2] . ': ' . $role . ' to ' . $to);
            flash('success', $res[1]);
            redirect('/Admin/View/staff.php');
        }
        $errors[] = $res[1];
    }
    if ($action === 'save') {
        $first = trim(isset($_POST['first']) ? $_POST['first'] : '');
        $last = trim(isset($_POST['last']) ? $_POST['last'] : '');
        $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
        $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
        if ($first === '' || $last === '') { $errors[] = 'Enter first and last name.'; }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email address.'; }
        elseif (adb()->emailInUse($email, $role, $id)) { $errors[] = 'That email is already in use.'; }
        if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) { $errors[] = 'Enter a valid phone number.'; }
        if ($role === 'manager') {
            $salary = isset($_POST['salary']) ? trim($_POST['salary']) : '';
            $status = isset($_POST['status']) && $_POST['status'] === 'inactive' ? 'inactive' : 'active';
            if (!ctype_digit($salary)) { $errors[] = 'Salary must be a whole number.'; }
        } else {
            $mgr = isset($_POST['manager']) ? $_POST['manager'] : '';
            if ($mgr !== '' && !in_array($mgr, adb()->managerUsernames(), true)) { $errors[] = 'Choose a valid manager.'; }
        }
        if (!$errors) {
            $role === 'manager' ? adb()->updateManager($id, $first, $last, $email, $phone, (int)$salary, $status)
                                : adb()->updateEmployee($id, $first, $last, $email, $phone, $mgr);
            log_activity('admin', $admin['uname'], 'updated_' . $role, $username);
            flash('success', 'Saved.');
            redirect('/Admin/View/staff_edit.php?role=' . $role . '&id=' . $id);
        }
    }
}

$pageTitle = 'Manage ' . $username;
require __DIR__ . '/header.php';
$first = $role === 'manager' ? $person['firstname'] : $person['fname'];
$last = $role === 'manager' ? $person['lastname'] : $person['lname'];
$tasks = array_filter(adb()->tasks(), function ($t) use ($role, $username) { return $t['assignee_role'] === $role && $t['assignee_username'] === $username && $t['status'] === 'open'; });
?>
<h1><?php echo h(trim($first . ' ' . $last)); ?> <span class="muted small">(<?php echo h($role); ?> · <?php echo h($username); ?>)</span></h1>
<?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>

<section class="grid">
    <div class="card">
        <h2>Details</h2>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="save">
            <label>First name <input type="text" name="first" value="<?php echo h($first); ?>" required></label>
            <label>Last name <input type="text" name="last" value="<?php echo h($last); ?>" required></label>
            <label>Email <input type="email" name="email" value="<?php echo h($person['email']); ?>" required></label>
            <label>Phone <input type="tel" name="phone" value="<?php echo h($person['phone']); ?>" required></label>
            <?php if ($role === 'manager') { ?>
                <label>Salary <input type="number" name="salary" min="0" value="<?php echo h($person['salary']); ?>"></label>
                <label>Status
                    <select name="status">
                        <option value="active"<?php echo $person['activeStatus'] !== 'inactive' ? ' selected' : ''; ?>>Active</option>
                        <option value="inactive"<?php echo $person['activeStatus'] === 'inactive' ? ' selected' : ''; ?>>Inactive</option>
                    </select>
                </label>
            <?php } else { ?>
                <label>Reports to (manager)
                    <select name="manager">
                        <option value="">- none -</option>
                        <?php foreach (adb()->managerUsernames() as $mu) { ?>
                            <option value="<?php echo h($mu); ?>"<?php echo $person['manager'] === $mu ? ' selected' : ''; ?>><?php echo h($mu); ?></option>
                        <?php } ?>
                    </select>
                </label>
            <?php } ?>
            <button class="btn" type="submit">Save changes</button>
            <a class="btn btn-ghost" href="/Admin/View/staff.php">Back to staff</a>
        </form>
    </div>

    <div>
        <div class="card">
            <h2>Role</h2>
            <p class="muted">Currently a <strong><?php echo h($role); ?></strong>. Moving them keeps their login and reassigns open tasks.</p>
            <form method="post" onsubmit="return confirm('Change this person\'s role?');">
                <?php echo csrf_field(); ?><input type="hidden" name="action" value="role">
                <button class="btn btn-ghost" type="submit">Make <?php echo $role === 'manager' ? 'an employee' : 'a manager'; ?></button>
            </form>
        </div>
        <div class="card">
            <h2>Open tasks (<?php echo count($tasks); ?>)</h2>
            <?php if (!$tasks) { ?><p class="muted">Nothing assigned.</p><?php } ?>
            <ul class="list"><?php foreach ($tasks as $t) { ?><li><span><?php echo h($t['title']); ?></span><span class="muted small"><?php echo h($t['due_date']); ?></span></li><?php } ?></ul>
            <a class="btn btn-ghost" href="/Admin/View/tasks.php">Assign work</a>
        </div>
        <div class="card">
            <h2>Remove</h2>
            <p class="muted">Deletes their login and any open tasks. This cannot be undone.</p>
            <form method="post" onsubmit="return confirm('Remove <?php echo h($username); ?> permanently?');">
                <?php echo csrf_field(); ?><input type="hidden" name="action" value="remove">
                <button class="btn btn-danger" type="submit">Remove <?php echo h($role); ?></button>
            </form>
        </div>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
