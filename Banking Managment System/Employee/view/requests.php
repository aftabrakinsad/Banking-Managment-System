<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$tabs = ['open' => 'Open', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'rejected' => 'Declined', 'all' => 'All'];
$tab = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'open';
$rows = crepo()->requests($tab === 'all' ? '' : $tab);
$counts = crepo()->requestCounts();
$pageTitle = 'Customer requests';
require __DIR__ . '/header.php';
$labels = CustomerRepo::REQUEST_TYPES;
?>
<h1>Customer requests</h1>
<p class="muted">Requests customers send from their portal. Open one to reply and update its status; the customer is notified.</p>
<div class="page-actions tabs">
    <?php foreach ($tabs as $k => $l) { ?>
        <a class="btn <?php echo $tab === $k ? '' : 'btn-ghost'; ?>" href="?tab=<?php echo $k; ?>"><?php echo $l; ?><?php echo $k !== 'all' ? ' (' . (int)$counts[$k] . ')' : ''; ?></a>
    <?php } ?>
</div>
<section class="card">
    <?php if (!$rows) { ?><p class="muted">Nothing here.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>#</th><th>Customer</th><th>Type</th><th>Subject</th><th>Status</th><th>Received</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $r) { ?>
            <tr>
                <td><?php echo (int)$r['id']; ?></td>
                <td><strong><?php echo h($r['fname'] . ' ' . $r['lname']); ?></strong><br><span class="muted small">Acct <?php echo h($r['accountno']); ?></span></td>
                <td><?php echo h(isset($labels[$r['type']]) ? $labels[$r['type']] : $r['type']); ?></td>
                <td><?php echo h($r['subject']); ?></td>
                <td><?php echo h(str_replace('_', ' ', $r['status'])); ?></td>
                <td><?php echo h(substr($r['created_at'], 0, 10)); ?></td>
                <td><a class="btn btn-small<?php echo in_array($r['status'], ['open', 'in_progress'], true) ? '' : ' btn-ghost'; ?>" href="../view/request_view.php?id=<?php echo (int)$r['id']; ?>"><?php echo in_array($r['status'], ['open', 'in_progress'], true) ? 'Handle' : 'View'; ?></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
