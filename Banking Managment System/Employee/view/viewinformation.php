<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$conn = crepo()->conn;

$st = $conn->prepare("SELECT r.fname, r.lname, r.Username, r.Email, r.NID, r.Phone, r.gender, r.picture, r.cv, r.applied_at, e.manager
                      FROM registrationofemployee r LEFT JOIN employee e ON e.Username = r.Username WHERE r.Username = ?");
$st->bind_param('s', $employee['username']);
$st->execute();
$me = $st->get_result()->fetch_assoc();
$st->close();
if (!$me) { $me = ['fname' => '', 'lname' => '', 'Username' => $employee['username'], 'Email' => $employee['email'], 'NID' => '', 'Phone' => '', 'gender' => '', 'picture' => '', 'cv' => '', 'applied_at' => '', 'manager' => null]; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $fname = trim(isset($_POST['fname']) ? $_POST['fname'] : '');
    $lname = trim(isset($_POST['lname']) ? $_POST['lname'] : '');
    $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
    if ($fname === '' || $lname === '' || strlen($fname) > 100 || strlen($lname) > 100) { $errors[] = 'Enter your first and last name.'; }
    if (!preg_match('/^\+?[0-9\-]{7,17}$/', $phone)) { $errors[] = 'Enter a valid phone number.'; }
    if (!$errors) {
        $u = $conn->prepare("UPDATE registrationofemployee SET fname = ?, lname = ?, Phone = ? WHERE Username = ?");
        $u->bind_param('ssss', $fname, $lname, $phone, $employee['username']); $u->execute(); $u->close();
        $u = $conn->prepare("UPDATE employee SET FirsName = ?, LastName = ?, Phone = ? WHERE Username = ?");
        $u->bind_param('ssss', $fname, $lname, $phone, $employee['username']); $u->execute(); $u->close();
        log_activity('employee', $employee['username'], 'updated_profile');
        flash('success', 'Profile updated.');
        redirect('/Employee/view/viewinformation.php');
    }
    $me['fname'] = $fname; $me['lname'] = $lname; $me['Phone'] = $phone;
}
$pageTitle = 'My profile';
require __DIR__ . '/header.php';
?>
<h1>My profile</h1>
<section class="grid">
    <div class="card">
        <h2>Details</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>First name <input type="text" name="fname" value="<?php echo h($me['fname']); ?>" required></label>
            <label>Last name <input type="text" name="lname" value="<?php echo h($me['lname']); ?>" required></label>
            <label>Phone <input type="tel" name="phone" value="<?php echo h($me['Phone']); ?>" required></label>
            <button class="btn" type="submit">Save changes</button>
        </form>
    </div>
    <div class="card">
        <h2>Account</h2>
        <dl class="facts wide">
            <dt>Username</dt><dd><?php echo h($me['Username']); ?></dd>
            <dt>Email</dt><dd><?php echo h($me['Email']); ?></dd>
            <dt>NID</dt><dd><?php echo $me['NID'] !== '' ? h($me['NID']) : '<span class="muted">-</span>'; ?></dd>
            <dt>Gender</dt><dd><?php echo $me['gender'] ? h($me['gender']) : '<span class="muted">-</span>'; ?></dd>
            <dt>Reports to</dt><dd><?php echo $me['manager'] ? h($me['manager']) : '<span class="muted">Not assigned yet</span>'; ?></dd>
        </dl>
        <p class="muted small">Your email, role and manager are set by the administrator.</p>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
