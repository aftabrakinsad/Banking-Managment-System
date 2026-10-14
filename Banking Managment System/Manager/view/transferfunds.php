<?php
require_once __DIR__ . '/../control/bootstrap.php';
$manager = require_manager();
$errors = [];
$v = ['account' => '', 'amount' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $v['account'] = trim(isset($_POST['account']) ? $_POST['account'] : '');
    $v['amount'] = trim(isset($_POST['amount']) ? $_POST['amount'] : '');
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    if (!ctype_digit($v['account']) || strlen($v['account']) > 9) { $errors[] = 'Enter a valid receiver account number.'; }
    if (!ctype_digit($v['amount']) || (int)$v['amount'] < 1 || (int)$v['amount'] > 10000000) { $errors[] = 'Amount must be a whole number between 1 and 10,000,000.'; }
    if (!verify_secret($pass, $manager['pass'])) { $errors[] = 'Your password is incorrect.'; }
    if (!$errors) {
        $res = mrepo()->transfer($manager['username'], (int)$v['account'], (int)$v['amount']);
        if ($res[0]) {
            log_activity('manager', $manager['username'], 'fund_transfer', $v['amount'] . ' to account ' . $v['account']);
            flash('success', $res[1]);
            redirect('/Manager/view/transferfunds.php');
        }
        $errors[] = $res[1];
    }
}
$pageTitle = 'Transfer funds';
require __DIR__ . '/header.php';
$me = mrepo()->find($manager['username']);
?>
<h1>Transfer funds</h1>
<p class="muted">Move internal funds to another manager's account.</p>
<section class="grid">
    <div class="card">
        <h2>Your funds</h2>
        <dl class="facts wide">
            <dt>Account no.</dt><dd><?php echo $me['accountno'] ? h($me['accountno']) : '<span class="muted">Not set up yet</span>'; ?></dd>
            <dt>Available</dt><dd>৳ <?php echo money($me['fund']); ?></dd>
        </dl>
    </div>
    <div class="card">
        <h2>New transfer</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>Receiver account number <input type="text" name="account" inputmode="numeric" pattern="[0-9]{1,9}" value="<?php echo h($v['account']); ?>" required></label>
            <label>Amount (৳) <input type="number" name="amount" min="1" max="10000000" step="1" value="<?php echo h($v['amount']); ?>" required></label>
            <label>Your password <input type="password" name="pass" autocomplete="current-password" required></label>
            <button class="btn" type="submit">Send funds</button>
        </form>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
