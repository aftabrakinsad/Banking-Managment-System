<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$errors = [];
$v = ['role' => 'employee', 'first' => '', 'last' => '', 'username' => '', 'email' => '', 'phone' => '', 'salary' => '0'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    foreach ($v as $k => $_) { $v[$k] = trim(isset($_POST[$k]) ? $_POST[$k] : ''); }
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (!in_array($v['role'], ['manager', 'employee'], true)) { $errors[] = 'Choose a role.'; }
    if ($v['first'] === '' || $v['last'] === '') { $errors[] = 'Enter first and last name.'; }
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $v['username'])) { $errors[] = 'Username: 3-30 letters, numbers or underscores.'; }
    elseif (adb()->usernameTaken($v['username'])) { $errors[] = 'That username is already taken.'; }
    if (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email address.'; }
    elseif (adb()->emailInUse($v['email'], '', 0)) { $errors[] = 'That email is already in use.'; }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $v['phone'])) { $errors[] = 'Enter a valid phone number.'; }
    if (!valid_password($password)) { $errors[] = 'Password needs 8+ characters with upper, lower, a number and a symbol.'; }
    if ($v['role'] === 'manager' && !ctype_digit($v['salary'])) { $errors[] = 'Salary must be a whole number.'; }

    if (!$errors) {
        $ok = $v['role'] === 'manager'
            ? adb()->addManager($v['first'], $v['last'], $v['username'], $v['email'], $v['phone'], password_hash($password, PASSWORD_DEFAULT), (int)$v['salary'])
            : adb()->addEmployee($v['first'], $v['last'], $v['username'], $v['email'], $v['phone'], password_hash($password, PASSWORD_DEFAULT));
        if ($ok === false) { $errors[] = 'Could not create the account.'; }
        else {
            log_activity('admin', $admin['uname'], 'added_' . $v['role'], $v['username']);
            flash('success', ucfirst($v['role']) . ' ' . $v['username'] . ' created.');
            redirect('/Admin/View/staff.php');
        }
    }
}
$pageTitle = 'Add staff';
require __DIR__ . '/header.php';
?>
<h1>Add staff member</h1>
<section class="card narrow">
    <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
    <form method="post">
        <?php echo csrf_field(); ?>
        <label>Role
            <select name="role">
                <option value="employee"<?php echo $v['role'] === 'employee' ? ' selected' : ''; ?>>Employee</option>
                <option value="manager"<?php echo $v['role'] === 'manager' ? ' selected' : ''; ?>>Manager</option>
            </select>
        </label>
        <label>First name <input type="text" name="first" value="<?php echo h($v['first']); ?>" required></label>
        <label>Last name <input type="text" name="last" value="<?php echo h($v['last']); ?>" required></label>
        <label>Username <input type="text" name="username" value="<?php echo h($v['username']); ?>" required></label>
        <label>Email <input type="email" name="email" value="<?php echo h($v['email']); ?>" required></label>
        <label>Phone <input type="tel" name="phone" value="<?php echo h($v['phone']); ?>" required></label>
        <label>Salary (managers only) <input type="number" name="salary" min="0" value="<?php echo h($v['salary']); ?>"></label>
        <label>Initial password <input type="password" name="password" autocomplete="new-password" required></label>
        <button class="btn" type="submit">Create account</button>
        <a class="btn btn-ghost" href="/Admin/View/staff.php">Cancel</a>
    </form>
</section>
<?php require __DIR__ . '/footer.php'; ?>
