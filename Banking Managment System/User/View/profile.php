<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $fname = trim(isset($_POST['fname']) ? $_POST['fname'] : '');
    $lname = trim(isset($_POST['lname']) ? $_POST['lname'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');

    if ($fname === '' || strlen($fname) > 100 || $lname === '' || strlen($lname) > 100) { $errors[] = 'Enter your first and last name.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) { $errors[] = 'Enter a valid email address.'; }
    elseif (udb()->emailTaken($email, (int)$me['user_id'])) { $errors[] = 'That email is already in use.'; }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) { $errors[] = 'Enter a valid phone number (digits, optional leading +).'; }

    if (!$errors) {
        udb()->updateProfile((int)$me['user_id'], $fname, $lname, $email, $phone);
        flash('success', 'Profile updated.');
        redirect('profile.php');
    }
    $me = array_merge($me, ['fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone]);
}
$title = 'Profile';
require __DIR__ . '/layout_top.php';
?>
<h1>Your profile</h1>
<section class="card narrow">
    <dl class="facts">
        <dt>Username</dt><dd><?php echo h($me['uname']); ?></dd>
        <dt>Account no.</dt><dd><?php echo h($me['accountno']); ?></dd>
        <dt>NID</dt><dd><?php echo h($me['nid']); ?></dd>
    </dl>
    <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
    <form method="post">
        <?php echo csrf_field(); ?>
        <label>First name <input type="text" name="fname" required value="<?php echo h($me['fname']); ?>"></label>
        <label>Last name <input type="text" name="lname" required value="<?php echo h($me['lname']); ?>"></label>
        <label>Email <input type="email" name="email" required value="<?php echo h($me['email']); ?>"></label>
        <label>Phone <input type="tel" name="phone" required value="<?php echo h($me['phone']); ?>"></label>
        <button class="btn" type="submit">Save changes</button>
    </form>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
