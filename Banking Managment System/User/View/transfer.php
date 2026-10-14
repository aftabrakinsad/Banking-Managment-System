<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
require __DIR__ . '/../Control/transfer.process.php';
$balance = udb()->balance((int)$me['accountno']);
$title = 'Transfer';
require __DIR__ . '/layout_top.php';
?>
<h1>Transfer money</h1>
<section class="card narrow">
    <p class="muted">Available: <strong>৳ <?php echo money($balance); ?></strong></p>
    <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
    <form method="post">
        <?php echo csrf_field(); ?>
        <?php if ($bens) { ?>
        <label>Saved payee
            <select id="payee" onchange="document.getElementById('to').value=this.value">
                <option value="">— choose —</option>
                <?php foreach ($bens as $b) { ?>
                    <option value="<?php echo h($b['accountno']); ?>"><?php echo h($b['nickname'] . ' (' . $b['accountno'] . ')'); ?></option>
                <?php } ?>
            </select>
        </label>
        <?php } ?>
        <label>Receiver account number
            <input id="to" type="text" name="to_account" inputmode="numeric" pattern="[0-9]{1,9}" required value="<?php echo h(isset($_POST['to_account']) ? $_POST['to_account'] : ''); ?>">
        </label>
        <label>Amount (৳)
            <input type="number" name="amount" min="1" max="1000000" step="1" required value="<?php echo h(isset($_POST['amount']) ? $_POST['amount'] : ''); ?>">
        </label>
        <label>PIN
            <input type="password" name="pin" inputmode="numeric" autocomplete="off" required>
        </label>
        <button class="btn" type="submit">Send</button>
    </form>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
