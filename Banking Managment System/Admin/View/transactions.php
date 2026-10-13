<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$rows = adb()->transactions(200);
$pageTitle = 'All transactions';
require __DIR__ . '/header.php';
?>
<h1>All transactions</h1>
<p class="muted">The 200 most recent ledger entries across every customer account.</p>
<section class="card">
    <?php if (!$rows) { ?><p class="muted">No transactions yet.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Date</th><th>Account</th><th>Customer</th><th>Details</th><th class="num">Debit</th><th class="num">Credit</th><th class="num">Balance</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $t) { ?>
            <tr>
                <td><?php echo h($t['trans_date']); ?></td>
                <td><?php echo h($t['accountno']); ?></td>
                <td><?php echo h(trim($t['fname'] . ' ' . $t['lname'])); ?></td>
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
<?php require __DIR__ . '/footer.php'; ?>
