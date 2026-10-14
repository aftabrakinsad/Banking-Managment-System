<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$q = trim(isset($_GET['q']) ? $_GET['q'] : '');
if (strlen($q) > 60) { $q = substr($q, 0, 60); }
$rows = adb()->transactions($q === '' ? 200 : 500, $q);
$pageTitle = 'All transactions';
require __DIR__ . '/header.php';
?>
<h1>All transactions</h1>
<p class="muted">Ledger entries across every customer account, newest first.</p>
<section class="card">
    <form method="get" class="filters search">
        <label>Search by account number or customer name
            <input type="search" name="q" value="<?php echo h($q); ?>" placeholder="e.g. 3000001" inputmode="search" autocomplete="off">
        </label>
        <button class="btn" type="submit">Search</button>
        <?php if ($q !== '') { ?><a class="btn btn-ghost" href="/Admin/View/transactions.php">Clear</a><?php } ?>
    </form>
    <p class="muted small"><?php echo $q === '' ? 'Showing the latest ' . count($rows) . ' entries.' : count($rows) . ' result(s) for &ldquo;' . h($q) . '&rdquo;.'; ?></p>
    <?php if (!$rows) { ?><p class="muted"><?php echo $q === '' ? 'No transactions yet.' : 'No transactions match that search.'; ?></p><?php } else { ?>
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
