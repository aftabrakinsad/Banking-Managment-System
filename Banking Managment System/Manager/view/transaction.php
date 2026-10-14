<?php
require_once __DIR__ . '/../control/bootstrap.php';
$manager = require_manager();
$pageTitle = 'Transactions';
$acct = (int)$manager['accountno'];
$rows = $acct ? mrepo()->transfersFor($acct, 100) : [];
require __DIR__ . '/header.php';
?>
<h1>My transactions</h1>
<p class="muted">Fund transfers sent from or received by your account<?php echo $acct ? ' (' . h($acct) . ')' : ''; ?>.</p>
<section class="card">
    <?php if (!$rows) { ?><p class="muted">No transfers yet.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Date</th><th>Direction</th><th>Other manager</th><th>Account</th><th class="num">Amount</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $t) { $out = (int)$t['senderaccount'] === $acct; ?>
            <tr>
                <td><?php echo h($t['Date']); ?></td>
                <td><?php echo $out ? 'Sent' : 'Received'; ?></td>
                <td><?php echo h($out ? trim($t['rfirst'] . ' ' . $t['rlast']) : trim($t['sfirst'] . ' ' . $t['slast'])); ?></td>
                <td><?php echo h($out ? $t['receveraccount'] : $t['senderaccount']); ?></td>
                <td class="num <?php echo $out ? 'out' : 'in'; ?>"><?php echo ($out ? '-' : '+') . money($t['balancetransfered']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
