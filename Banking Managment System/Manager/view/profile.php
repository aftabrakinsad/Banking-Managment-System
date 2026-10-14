<?php
require_once __DIR__ . '/../control/bootstrap.php';
$manager = require_manager();
$uname = $manager['username'];
$errors = []; $pwErrors = [];
$v = ['email' => $manager['email'], 'phone' => $manager['phone'], 'address' => $manager['presentaddress']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if ($action === 'contact') {
        foreach ($v as $k => $_) { $v[$k] = trim(isset($_POST[$k]) ? $_POST[$k] : ''); }
        if (!filter_var($v['email'], FILTER_VALIDATE_EMAIL) || strlen($v['email']) > 100) { $errors[] = 'Enter a valid email address.'; }
        elseif (mrepo()->emailTaken($v['email'], $uname)) { $errors[] = 'That email is already in use.'; }
        if (!preg_match('/^\+?[0-9\-]{7,17}$/', $v['phone'])) { $errors[] = 'Enter a valid phone number.'; }
        if (strlen($v['address']) < 3 || strlen($v['address']) > 250) { $errors[] = 'Enter your address.'; }
        if (!$errors) {
            mrepo()->updateContact($uname, $v['email'], $v['phone'], $v['address']);
            log_activity('manager', $uname, 'updated_profile');
            flash('success', 'Profile updated.');
            redirect('/Manager/view/profile.php');
        }
    } elseif ($action === 'password') {
        $cur = isset($_POST['current']) ? $_POST['current'] : '';
        $new = isset($_POST['new']) ? $_POST['new'] : '';
        $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : '';
        if (!verify_secret($cur, $manager['pass'])) { $pwErrors[] = 'Your current password is incorrect.'; }
        elseif (!valid_password($new)) { $pwErrors[] = 'New password needs 8+ characters with upper, lower, a number and a symbol.'; }
        elseif ($new !== $confirm) { $pwErrors[] = 'The new passwords do not match.'; }
        else {
            mrepo()->setPasswordHash($uname, password_hash($new, PASSWORD_DEFAULT));
            log_activity('manager', $uname, 'password_changed');
            flash('success', 'Password changed.');
            redirect('/Manager/view/profile.php');
        }
    }
}
$pageTitle = 'Profile and security';
require __DIR__ . '/header.php';
?>
<h1>Profile and security</h1>
<section class="grid">
    <div class="card">
        <h2>Contact details</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="contact">
            <label>Email <input type="email" name="email" value="<?php echo h($v['email']); ?>" required></label>
            <label>Phone <input type="tel" name="phone" value="<?php echo h($v['phone']); ?>" required></label>
            <label>Address <input type="text" name="address" value="<?php echo h($v['address']); ?>" required></label>
            <button class="btn" type="submit">Save changes</button>
        </form>
        <p class="muted small">Your username, name, salary and status are set by the administrator.</p>
    </div>
    <div class="card">
        <h2>Change password</h2>
        <?php foreach ($pwErrors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?><input type="hidden" name="action" value="password">
            <label>Current password <input type="password" name="current" autocomplete="current-password" required></label>
            <label>New password <input type="password" name="new" autocomplete="new-password" required></label>
            <label>Confirm new password <input type="password" name="confirm" autocomplete="new-password" required></label>
            <button class="btn" type="submit">Update password</button>
        </form>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
