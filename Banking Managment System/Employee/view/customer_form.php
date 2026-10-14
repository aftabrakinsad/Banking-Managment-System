<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();

$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$editing = $id > 0;
$c = $editing ? crepo()->find($id) : null;
if ($editing && !$c) { flash('error', 'Customer not found.'); redirect('/Employee/view/customers.php'); }
$errors = [];
$v = ['fname' => '', 'lname' => '', 'uname' => '', 'email' => '', 'nid' => '', 'phone' => '', 'opening' => '0'];
if ($c) { foreach (['fname', 'lname', 'uname', 'email', 'nid', 'phone'] as $k) { $v[$k] = (string)$c[$k]; } }
$uploadBase = __DIR__ . '/../../Admin/uploads';   // customer pictures are shared with the admin portal

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    foreach ($v as $k => $_) { if (isset($_POST[$k])) { $v[$k] = trim($_POST[$k]); } }
    if ($v['fname'] === '' || $v['lname'] === '') { $errors[] = 'Enter first and last name.'; }
    if (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email address.'; }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $v['phone'])) { $errors[] = 'Enter a valid phone number.'; }
    $hasPic = !empty($_FILES['picture']['name']);

    if ($editing) {
        if (!$errors && crepo()->emailTaken($v['email'], $id)) { $errors[] = 'That email is already in use.'; }
        $pic = '';
        if (!$errors && $hasPic) {
            $r = save_image_upload($_FILES['picture'], $uploadBase, 'user_picture/x');
            if ($r[0]) { $pic = $r[1]; } else { $errors[] = $r[1]; }
        }
        if (!$errors) {
            crepo()->update($id, $v['fname'], $v['lname'], $v['email'], $v['phone']);
            if ($pic !== '') { crepo()->setPicture($id, $pic); }
            log_activity('employee', $employee['username'], 'updated_customer', $c['uname'] . ($pic !== '' ? ' (picture changed)' : ''));
            flash('success', 'Customer saved.');
            redirect('/Employee/view/customer_form.php?id=' . $id);
        }
    } else {
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $pin = isset($_POST['pin']) ? $_POST['pin'] : '';
        if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $v['uname'])) { $errors[] = 'Username: 3-30 letters, numbers or underscores.'; }
        if (!ctype_digit($v['nid']) || strlen($v['nid']) < 8 || strlen($v['nid']) > 15) { $errors[] = 'NID must be 8-15 digits.'; }
        if (!valid_password($password)) { $errors[] = 'Password needs 8+ characters with upper, lower, a number and a symbol.'; }
        if (!preg_match('/^[0-9]{4}$/', $pin)) { $errors[] = 'PIN must be exactly 4 digits.'; }
        if (!ctype_digit($v['opening']) || (int)$v['opening'] > 1000000) { $errors[] = 'Opening deposit must be a whole number up to 1,000,000.'; }
        if (!$errors && crepo()->taken($v['uname'], $v['email'], (int)$v['nid'], 0)) { $errors[] = 'That username, email or NID already belongs to a customer.'; }
        $pic = '';
        if (!$errors && $hasPic) {
            $r = save_image_upload($_FILES['picture'], $uploadBase, 'user_picture/x');
            if ($r[0]) { $pic = $r[1]; } else { $errors[] = $r[1]; }
        }
        if (!$errors) {
            $acct = crepo()->newAccountNumber();
            $ok = crepo()->add($v['fname'], $v['lname'], $v['uname'], $v['email'], (int)$v['nid'], $v['phone'], $acct,
                password_hash($pin, PASSWORD_DEFAULT), password_hash($password, PASSWORD_DEFAULT), $pic, (int)$v['opening']);
            if ($ok) {
                log_activity('employee', $employee['username'], 'opened_account', $v['uname'] . ' (account ' . $acct . ')');
                flash('success', 'Account opened. Account number: ' . $acct);
                redirect('/Employee/view/customers.php');
            }
            $errors[] = 'Could not open the account.';
        }
    }
}
$pageTitle = $editing ? 'Update customer' : 'Open an account';
require __DIR__ . '/header.php';
?>
<h1><?php echo $editing ? 'Update customer' : 'Open an account'; ?></h1>
<section class="card narrow">
    <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
    <form method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if ($editing) { ?>
            <dl class="facts"><dt>Username</dt><dd><?php echo h($c['uname']); ?></dd><dt>Account no.</dt><dd><?php echo h($c['accountno']); ?></dd>
                <dt>Balance</dt><dd>৳ <?php echo money(crepo()->balance((int)$c['accountno'])); ?></dd></dl>
        <?php } ?>
        <label>First name <input type="text" name="fname" value="<?php echo h($v['fname']); ?>" required></label>
        <label>Last name <input type="text" name="lname" value="<?php echo h($v['lname']); ?>" required></label>
        <?php if (!$editing) { ?>
            <label>Username <input type="text" name="uname" value="<?php echo h($v['uname']); ?>" required></label>
            <label>NID <input type="text" name="nid" inputmode="numeric" value="<?php echo h($v['nid']); ?>" required></label>
        <?php } ?>
        <label>Email <input type="email" name="email" value="<?php echo h($v['email']); ?>" required></label>
        <label>Phone <input type="tel" name="phone" value="<?php echo h($v['phone']); ?>" required></label>

        <label>Profile picture
            <?php if ($editing && $c['picture'] !== '') { ?><img class="avatar-lg" src="/Admin/uploads/<?php echo h($c['picture']); ?>" alt="Current picture" onerror="this.style.display='none'"><?php } ?>
            <input type="file" name="picture" accept="image/jpeg,image/png,image/webp">
            <span class="muted small">JPG, PNG or WEBP, up to 2 MB.<?php echo $editing ? ' Leave empty to keep the current picture.' : ''; ?></span>
        </label>

        <?php if (!$editing) { ?>
            <label>Initial password <input type="password" name="password" autocomplete="new-password" required></label>
            <label>PIN (4 digits) <input type="password" name="pin" inputmode="numeric" maxlength="4" autocomplete="off" required></label>
            <label>Opening deposit (৳) <input type="number" name="opening" min="0" max="1000000" value="<?php echo h($v['opening']); ?>"></label>
        <?php } else { ?>
            <p class="muted small">Password and PIN resets are handled by the administrator, or by the customer from their Security page.</p>
        <?php } ?>
        <button class="btn" type="submit"><?php echo $editing ? 'Save changes' : 'Open account'; ?></button>
        <a class="btn btn-ghost" href="../view/customers.php">Cancel</a>
    </form>
</section>
<?php @include("../view/footer.php"); ?>
