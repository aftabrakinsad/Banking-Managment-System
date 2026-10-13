<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $current = isset($_POST['current']) ? $_POST['current'] : '';

    if ($action === 'password') {
        $new = isset($_POST['new']) ? $_POST['new'] : '';
        $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : '';
        if (!verify_secret($current, $me['password'])) { $errors[] = 'Current password is incorrect.'; }
        elseif (!valid_password($new)) { $errors[] = 'New password needs 8+ characters with upper, lower, a number and a symbol.'; }
        elseif ($new !== $confirm) { $errors[] = 'New passwords do not match.'; }
        else { udb()->setPassword((int)$me['user_id'], password_hash($new, PASSWORD_DEFAULT)); log_activity('customer', $me['uname'], 'password_changed'); flash('success', 'Password changed.'); redirect('security.php'); }
    } elseif ($action === 'pin') {
        $new = isset($_POST['new_pin']) ? $_POST['new_pin'] : '';
        if (!verify_secret($current, $me['pin'])) { $errors[] = 'Current PIN is incorrect.'; }
        elseif (!preg_match('/^[0-9]{4}$/', $new)) { $errors[] = 'PIN must be exactly 4 digits.'; }
        else { udb()->setPin((int)$me['user_id'], password_hash($new, PASSWORD_DEFAULT)); log_activity('customer', $me['uname'], 'pin_changed'); flash('success', 'PIN changed.'); redirect('security.php'); }
    }
}
$title = 'Security';
require __DIR__ . '/layout_top.php';
?>
<h1>Security</h1>
<?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
<section class="grid">
    <div class="card">
        <h2>Change password</h2>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="password">
            <label>Current password <input type="password" name="current" required autocomplete="current-password"></label>
            <label>New password <input type="password" name="new" required autocomplete="new-password"></label>
            <label>Confirm new password <input type="password" name="confirm" required autocomplete="new-password"></label>
            <button class="btn" type="submit">Update password</button>
        </form>
    </div>
    <div class="card">
        <h2>Change PIN</h2>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="pin">
            <label>Current PIN <input type="password" name="current" inputmode="numeric" autocomplete="off" required></label>
            <label>New 4-digit PIN <input type="password" name="new_pin" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" autocomplete="off" required></label>
            <button class="btn" type="submit">Update PIN</button>
        </form>
    </div>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
