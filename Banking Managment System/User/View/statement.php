<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();

$from = isset($_GET['from']) ? $_GET['from'] : '';
$to   = isset($_GET['to']) ? $_GET['to'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$dateOk = function ($d) { return $d === '' || (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $d); };
if (!$dateOk($from)) { $from = ''; }
if (!$dateOk($to)) { $to = ''; }
if (!in_array($type, ['', 'debit', 'credit'], true)) { $type = ''; }

$rows = udb()->statement((int)$me['accountno'], $from, $to, $type);

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    // Neutralise spreadsheet formulas in free-text cells
    $safe = function ($v) { $v = (string)$v; return preg_match('/^[=+\-@\t\r]/', $v) ? "'" . $v : $v; };
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="statement-' . (int)$me['accountno'] . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Date', 'Details', 'Debit', 'Credit', 'Balance']);
    foreach ($rows as $t) { fputcsv($out, [$t['trans_date'], $safe($t['remarks']), $t['debit'], $t['credit'], $t['balance']]); }
    fclose($out);
    exit;
}

$title = 'Statement';
$qs = http_build_query(['from' => $from, 'to' => $to, 'type' => $type, 'export' => 'csv']);
require __DIR__ . '/layout_top.php';
?>
<h1>Account statement</h1>
<section class="card">
    <form method="get" class="filters">
        <label>From <input type="date" name="from" value="<?php echo h($from); ?>"></label>
        <label>To <input type="date" name="to" value="<?php echo h($to); ?>"></label>
        <label>Type
            <select name="type">
                <option value="">All</option>
                <option value="debit"<?php echo $type === 'debit' ? ' selected' : ''; ?>>Debits</option>
                <option value="credit"<?php echo $type === 'credit' ? ' selected' : ''; ?>>Credits</option>
            </select>
        </label>
        <button class="btn" type="submit">Filter</button>
        <a class="btn btn-ghost" href="?<?php echo h($qs); ?>">Download CSV</a>
        <a class="btn btn-ghost" href="#" onclick="window.print();return false;">Print</a>
    </form>

    <?php if (!$rows) { ?>
        <p class="muted">No transactions match these filters.</p>
    <?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Date</th><th>Details</th><th class="num">Debit</th><th class="num">Credit</th><th class="num">Balance</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $t) { ?>
            <tr>
                <td><?php echo h($t['trans_date']); ?></td>
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
