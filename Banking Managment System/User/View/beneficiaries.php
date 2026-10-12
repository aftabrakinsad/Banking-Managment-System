<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$uid = (int)$me['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if ($action === 'add') {
        $nick = trim(isset($_POST['nickname']) ? $_POST['nickname'] : '');
        $acct = trim(isset($_POST['accountno']) ? $_POST['accountno'] : '');
        if ($nick === '' || strlen($nick) > 60) { flash('error', 'Enter a nickname (up to 60 characters).'); }
        elseif (!ctype_digit($acct) || strlen($acct) > 9) { flash('error', 'Enter a valid account number.'); }
        elseif ((int)$acct === (int)$me['accountno']) { flash('error', 'That is your own account.'); }
        elseif (!udb()->findByAccount((int)$acct)) { flash('error', 'No customer found with that account number.'); }
        else { udb()->addBeneficiary($uid, $nick, (int)$acct); flash('success', 'Payee saved.'); }
    } elseif ($action === 'delete') {
        udb()->deleteBeneficiary($uid, (int)(isset($_POST['id']) ? $_POST['id'] : 0));
        flash('success', 'Payee removed.');
    }
    redirect('beneficiaries.php');
}

$bens = udb()->beneficiaries($uid);
$title = 'Payees';
require __DIR__ . '/layout_top.php';
?>
<h1>Saved payees</h1>
<section class="grid">
    <div class="card">
        <h2>Add a payee</h2>
        <form method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="add">
            <label>Nickname <input type="text" name="nickname" maxlength="60" required></label>
            <label>Account number <input type="text" name="accountno" inputmode="numeric" pattern="[0-9]{1,9}" required></label>
            <button class="btn" type="submit">Save payee</button>
        </form>
    </div>
    <div class="card">
        <h2>Your payees</h2>
        <?php if (!$bens) { ?><p class="muted">No saved payees yet.</p><?php } ?>
        <ul class="list">
        <?php foreach ($bens as $b) { ?>
            <li>
                <span><strong><?php echo h($b['nickname']); ?></strong><br><span class="muted small"><?php echo h($b['accountno']); ?></span></span>
                <span class="row-actions">
                    <a class="btn btn-small" href="transfer.php">Send</a>
                    <form method="post" onsubmit="return confirm('Remove this payee?');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo (int)$b['id']; ?>">
                        <button class="btn btn-small btn-danger" type="submit">Remove</button>
                    </form>
                </span>
            </li>
        <?php } ?>
        </ul>
    </div>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
