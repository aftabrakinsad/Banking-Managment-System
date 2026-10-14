<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$tab = isset($_GET['tab']) && in_array($_GET['tab'], ['pending', 'approved', 'rejected'], true) ? $_GET['tab'] : 'pending';
$mgr = adb()->managerApplications($tab);
$emp = adb()->employeeApplications($tab);
$pageTitle = 'Applications';
require __DIR__ . '/header.php';
?>
<h1>Join applications</h1>
<p class="muted">Managers and employees who asked to join. Open an application to read it in full and decide.</p>
<div class="page-actions tabs">
    <?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $k => $l) { ?>
        <a class="btn <?php echo $tab === $k ? '' : 'btn-ghost'; ?>" href="?tab=<?php echo $k; ?>"><?php echo $l; ?></a>
    <?php } ?>
</div>

<?php
$sections = [
    ['Manager applications', 'manager', $mgr, function ($a) { return $a['firstname'] . ' ' . $a['lastname']; }],
    ['Employee applications', 'employee', $emp, function ($a) { return $a['fname'] . ' ' . $a['lname']; }],
];
foreach ($sections as $sec) { list($label, $type, $list, $nameOf) = $sec; ?>
<section class="card">
    <h2><?php echo h($label); ?> (<?php echo count($list); ?>)</h2>
    <?php if (!$list) { ?><p class="muted">None.</p><?php } else { ?>
    <div class="table-wrap"><table class="apps">
        <thead><tr><th>Applicant</th><th>Username</th><th>Email</th><th>Applied</th><th><?php echo $tab === 'pending' ? 'Waiting' : 'Reviewed'; ?></th><th></th></tr></thead>
        <tbody>
        <?php foreach ($list as $a) { ?>
            <tr>
                <td><strong><?php echo h($nameOf($a)); ?></strong></td>
                <td><?php echo h($a['username']); ?></td>
                <td><?php echo h($a['email']); ?></td>
                <td><?php echo h(substr($a['applied_at'], 0, 10)); ?></td>
                <td><?php echo $tab === 'pending' ? h(max(0, (int)floor((time() - strtotime($a['applied_at'])) / 86400))) . ' day(s)' : h(substr((string)$a['reviewed_at'], 0, 10)); ?></td>
                <td><a class="btn btn-small<?php echo $tab === 'pending' ? '' : ' btn-ghost'; ?>" href="/Admin/View/application_view.php?type=<?php echo $type; ?>&amp;id=<?php echo (int)$a['id']; ?>"><?php echo $tab === 'pending' ? 'Review' : 'View'; ?></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php } ?>
<?php require __DIR__ . '/footer.php'; ?>
