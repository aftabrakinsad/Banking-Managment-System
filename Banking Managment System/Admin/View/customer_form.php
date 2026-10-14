<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();

$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$editing = $id > 0;
$c = $editing ? adb()->customer($id) : null;
if ($editing && !$c) { flash('error', 'Customer not found.'); redirect('/Admin/View/customers.php'); }
$errors = [];
$v = ['fname' => '', 'lname' => '', 'uname' => '', 'email' => '', 'nid' => '', 'phone' => '', 'opening' => '0'];
if ($c) { foreach (['fname', 'lname', 'uname', 'email', 'nid', 'phone'] as $k) { $v[$k] = (string)$c[$k]; } }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    foreach ($v as $k => $_) { if (isset($_POST[$k])) { $v[$k] = trim($_POST[$k]); } }
    if ($v['fname'] === '' || $v['lname'] === '') { $errors[] = 'Enter first and last name.'; }
    if (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email address.'; }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $v['phone'])) { $errors[] = 'Enter a valid phone number.'; }
    $hasPic = !empty($_FILES['picture']['name']);

    if ($editing) {
        $newPass = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $newPin = isset($_POST['new_pin']) ? $_POST['new_pin'] : '';
        if ($newPass !== '' && !valid_password($newPass)) { $errors[] = 'New password needs 8+ characters with upper, lower, a number and a symbol.'; }
        if ($newPin !== '' && !preg_match('/^[0-9]{4}$/', $newPin)) { $errors[] = 'PIN must be exactly 4 digits.'; }
        if (!$errors && adb()->customerEmailTaken($v['email'], $id)) { $errors[] = 'That email is already in use.'; }
        $pic = '';
        if (!$errors && $hasPic) {
            $r = save_image_upload($_FILES['picture'], __DIR__ . '/../uploads', 'user_picture/x');
            if ($r[0]) { $pic = $r[1]; } else { $errors[] = $r[1]; }
        }
        if (!$errors) {
            adb()->updateCustomer($id, $v['fname'], $v['lname'], $v['email'], $v['phone']);
            if ($newPass !== '') { adb()->setCustomerPassword($id, password_hash($newPass, PASSWORD_DEFAULT)); }
            if ($newPin !== '') { adb()->setCustomerPin($id, password_hash($newPin, PASSWORD_DEFAULT)); }
            if ($pic !== '') { adb()->setCustomerPicture($id, $pic); }
            log_activity('admin', $admin['uname'], 'updated_customer', $c['uname'] . ($pic !== '' ? ' (picture changed)' : ''));
            flash('success', 'Customer saved.');
            redirect('/Admin/View/customer_form.php?id=' . $id);
        }
    } else {
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $pin = isset($_POST['pin']) ? $_POST['pin'] : '';
        if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $v['uname'])) { $errors[] = 'Username: 3-30 letters, numbers or underscores.'; }
        if (!ctype_digit($v['nid']) || strlen($v['nid']) < 8 || strlen($v['nid']) > 15) { $errors[] = 'NID must be 8-15 digits.'; }
        if (!valid_password($password)) { $errors[] = 'Password needs 8+ characters with upper, lower, a number and a symbol.'; }
        if (!preg_match('/^[0-9]{4}$/', $pin)) { $errors[] = 'PIN must be exactly 4 digits.'; }
        if (!ctype_digit($v['opening']) || (int)$v['opening'] > 10000000) { $errors[] = 'Opening deposit must be a whole number up to 10,000,000.'; }
        if (!$errors && adb()->customerTaken($v['uname'], $v['email'], (int)$v['nid'], 0)) { $errors[] = 'That username, email or NID already belongs to a customer.'; }
        $pic = '';
        if (!$errors && $hasPic) {
            $r = save_image_upload($_FILES['picture'], __DIR__ . '/../uploads', 'user_picture/x');
            if ($r[0]) { $pic = $r[1]; } else { $errors[] = $r[1]; }
        }
        if (!$errors) {
            $acct = adb()->newAccountNumber();
            $ok = adb()->addCustomer($v['fname'], $v['lname'], $v['uname'], $v['email'], (int)$v['nid'], $v['phone'], $acct,
                password_hash($pin, PASSWORD_DEFAULT), password_hash($password, PASSWORD_DEFAULT), $pic, (int)$v['opening']);
            if ($ok) {
                log_activity('admin', $admin['uname'], 'added_customer', $v['uname'] . ' (account ' . $acct . ')');
                flash('success', 'Customer created. Account number: ' . $acct);
                redirect('/Admin/View/customers.php');
            }
            $errors[] = 'Could not create the customer.';
        }
    }
}
$pageTitle = $editing ? 'Update customer' : 'Add customer';
require __DIR__ . '/header.php';
?>
<h1><?php echo $editing ? 'Update customer' : 'Add customer'; ?></h1>
<section class="card narrow">
    <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
    <form method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if ($editing) { ?>
            <dl class="facts"><dt>Username</dt><dd><?php echo h($c['uname']); ?></dd><dt>Account no.</dt><dd><?php echo h($c['accountno']); ?></dd><dt>NID</dt><dd><?php echo h($c['nid']); ?></dd></dl>
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

        <?php if ($editing) { ?>
            <label>Reset password (optional) <input type="password" name="new_password" autocomplete="new-password"></label>
            <label>Reset PIN (optional, 4 digits) <input type="password" name="new_pin" inputmode="numeric" maxlength="4" autocomplete="off"></label>
        <?php } else { ?>
            <label>Initial password <input type="password" name="password" autocomplete="new-password" required></label>
            <label>PIN (4 digits) <input type="password" name="pin" inputmode="numeric" maxlength="4" autocomplete="off" required></label>
            <label>Opening deposit (৳) <input type="number" name="opening" min="0" value="<?php echo h($v['opening']); ?>"></label>
        <?php } ?>
        <button class="btn" type="submit"><?php echo $editing ? 'Save changes' : 'Create customer'; ?></button>
        <a class="btn btn-ghost" href="/Admin/View/customers.php">Cancel</a>
    </form>
</section>
<?php require __DIR__ . '/footer.php'; ?>
