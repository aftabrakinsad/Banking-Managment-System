<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$errors = [];
$v = ['account' => '', 'type' => 'deposit', 'amount' => ''];
$lookup = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $v['account'] = trim(isset($_POST['account']) ? $_POST['account'] : '');
    $v['type'] = isset($_POST['type']) && $_POST['type'] === 'withdraw' ? 'withdraw' : 'deposit';
    $v['amount'] = trim(isset($_POST['amount']) ? $_POST['amount'] : '');
    if (!ctype_digit($v['account']) || strlen($v['account']) > 9) { $errors[] = 'Enter a valid account number.'; }
    if (!ctype_digit($v['amount']) || (int)$v['amount'] < 1 || (int)$v['amount'] > 1000000) { $errors[] = 'Amount must be a whole number between 1 and 1,000,000.'; }
    if (!$errors) {
        $res = crepo()->cash((int)$v['account'], $v['type'], (int)$v['amount'], $employee['username']);
        if ($res[0]) {
            log_activity('employee', $employee['username'], 'cash_' . $v['type'], $v['amount'] . ' on account ' . $v['account']);
            flash('success', $res[1]);
            redirect('/Employee/view/cashdesk.php');
        }
        $errors[] = $res[1];
    }
}
if (isset($_GET['account']) && ctype_digit($_GET['account']) && strlen($_GET['account']) <= 9) {
    $lookup = crepo()->findByAccount((int)$_GET['account']);
    if ($lookup) { $lookup['balance'] = crepo()->balance((int)$lookup['accountno']); if ($v['account'] === '') { $v['account'] = (string)$lookup['accountno']; } }
}
$pageTitle = 'Cash desk';
require __DIR__ . '/header.php';
?>
<h1>Cash desk</h1>
<p class="muted">Record a customer's cash deposit or withdrawal. The balance and the customer's statement update immediately, and the customer is notified.</p>
<section class="grid">
    <div class="card">
        <h2>Find an account</h2>
        <form method="get">
            <label>Account number <input type="text" name="account" inputmode="numeric" pattern="[0-9]{1,9}" value="<?php echo h(isset($_GET['account']) ? $_GET['account'] : ''); ?>" required></label>
            <button class="btn btn-ghost" type="submit">Look up</button>
        </form>
        <?php if (isset($_GET['account'])) { ?>
            <?php if ($lookup) { ?>
                <dl class="facts"><dt>Customer</dt><dd><?php echo h($lookup['fname'] . ' ' . $lookup['lname']); ?></dd>
                    <dt>Balance</dt><dd>৳ <?php echo money($lookup['balance']); ?></dd></dl>
            <?php } else { ?><div class="alert alert-error" role="alert">No customer has that account number.</div><?php } ?>
        <?php } ?>
    </div>
    <div class="card">
        <h2>Record a transaction</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>Account number <input type="text" name="account" inputmode="numeric" pattern="[0-9]{1,9}" value="<?php echo h($v['account']); ?>" required></label>
            <label>Type
                <select name="type">
                    <option value="deposit"<?php echo $v['type'] === 'deposit' ? ' selected' : ''; ?>>Cash deposit</option>
                    <option value="withdraw"<?php echo $v['type'] === 'withdraw' ? ' selected' : ''; ?>>Cash withdrawal</option>
                </select>
            </label>
            <label>Amount (৳) <input type="number" name="amount" min="1" max="1000000" step="1" value="<?php echo h($v['amount']); ?>" required></label>
            <button class="btn" type="submit" onclick="return confirm('Record this transaction?');">Record</button>
        </form>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
