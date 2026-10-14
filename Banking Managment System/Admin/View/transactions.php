<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
require_once __DIR__ . '/../../config/managers.php';
$tab = isset($_GET['tab']) && $_GET['tab'] === 'funds' ? 'funds' : 'customers';
$q = trim(isset($_GET['q']) ? $_GET['q'] : '');
if (strlen($q) > 60) { $q = substr($q, 0, 60); }
$rows = $tab === 'funds' ? (new ManagerRepo())->allTransfers($q === '' ? 200 : 500, $q) : adb()->transactions($q === '' ? 200 : 500, $q);
$pageTitle = 'All transactions';
require __DIR__ . '/header.php';
?>
<h1>All transactions</h1>
<div class="page-actions tabs">
    <a class="btn <?php echo $tab === 'customers' ? '' : 'btn-ghost'; ?>" href="?tab=customers">Customer accounts</a>
    <a class="btn <?php echo $tab === 'funds' ? '' : 'btn-ghost'; ?>" href="?tab=funds">Manager fund transfers</a>
</div>
<p class="muted"><?php echo $tab === 'funds' ? 'Internal fund transfers between managers, newest first.' : 'Ledger entries across every customer account, newest first.'; ?></p>
<section class="card">
    <form method="get" class="filters search">
        <input type="hidden" name="tab" value="<?php echo h($tab); ?>">
        <label>Search by account number or customer name
            <input type="search" name="q" value="<?php echo h($q); ?>" placeholder="e.g. 3000001" inputmode="search" autocomplete="off">
        </label>
        <button class="btn" type="submit">Search</button>
        <?php if ($q !== '') { ?><a class="btn btn-ghost" href="/Admin/View/transactions.php?tab=<?php echo h($tab); ?>">Clear</a><?php } ?>
    </form>
    <p class="muted small"><?php echo $q === '' ? 'Showing the latest ' . count($rows) . ' entries.' : count($rows) . ' result(s) for &ldquo;' . h($q) . '&rdquo;.'; ?></p>
    <?php if (!$rows) { ?><p class="muted"><?php echo $q === '' ? 'No transactions yet.' : 'No transactions match that search.'; ?></p><?php } else { ?>
    <?php if ($tab === 'funds') { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Date</th><th>From</th><th>To</th><th class="num">Amount</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $t) { ?>
            <tr>
                <td><?php echo h($t['Date']); ?></td>
                <td><?php echo h(trim($t['sfirst'] . ' ' . $t['slast'])); ?> <span class="muted small">(<?php echo h($t['senderaccount']); ?>)</span></td>
                <td><?php echo h(trim($t['rfirst'] . ' ' . $t['rlast'])); ?> <span class="muted small">(<?php echo h($t['receveraccount']); ?>)</span></td>
                <td class="num"><?php echo money($t['balancetransfered']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } else { ?>
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
    <?php } ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>
