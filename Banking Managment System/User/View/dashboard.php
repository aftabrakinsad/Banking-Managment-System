<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$acct = (int)$me['accountno'];
$balance = udb()->balance($acct);
$recent = udb()->recent($acct, 5);
$sum = udb()->monthSummary($acct);
$max = max(1, (int)$sum['in_total'], (int)$sum['out_total']);
$title = 'Dashboard';
require __DIR__ . '/layout_top.php';
?>
<h1>Welcome back, <?php echo h($me['fname']); ?></h1>

<section class="grid">
    <div class="card balance">
        <span class="label">Available balance</span>
        <div class="amount">৳ <?php echo money($balance); ?></div>
        <span class="muted">Account no. <strong><?php echo h($acct); ?></strong></span>
        <div class="actions">
            <a class="btn" href="transfer.php">Send money</a>
            <a class="btn btn-ghost" href="statement.php">View statement</a>
        </div>
    </div>

    <div class="card">
        <span class="label">Last 30 days</span>
        <div class="bar-row"><span>In</span>
            <div class="bar"><i class="in" style="width:<?php echo round($sum['in_total'] / $max * 100); ?>%"></i></div>
            <b>৳ <?php echo money($sum['in_total']); ?></b></div>
        <div class="bar-row"><span>Out</span>
            <div class="bar"><i class="out" style="width:<?php echo round($sum['out_total'] / $max * 100); ?>%"></i></div>
            <b>৳ <?php echo money($sum['out_total']); ?></b></div>
    </div>
</section>

<section class="card">
    <h2>Recent transactions</h2>
    <?php if (!$recent) { ?>
        <p class="muted">No transactions yet.</p>
    <?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Date</th><th>Details</th><th class="num">Debit</th><th class="num">Credit</th><th class="num">Balance</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $t) { ?>
            <tr>
                <td><?php echo h(substr($t['trans_date'], 0, 10)); ?></td>
                <td><?php echo h($t['remarks']); ?></td>
                <td class="num out"><?php echo $t['debit'] > 0 ? money($t['debit']) : ''; ?></td>
                <td class="num in"><?php echo $t['credit'] > 0 ? money($t['credit']) : ''; ?></td>
                <td class="num"><?php echo money($t['balance']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
