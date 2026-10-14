<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$s = adb()->summary();
$recent = adb()->recentActivity(10);
$pageTitle = 'Dashboard';
require __DIR__ . '/header.php';
$pendingTotal = $s['pending_managers'] + $s['pending_employees'];
?>
<h1>System overview</h1>
<p class="muted">Signed in as the master administrator (<strong><?php echo h($admin['uname']); ?></strong>).</p>

<?php if ($pendingTotal > 0) { ?>
<div class="alert alert-success" role="status">
    <?php echo (int)$pendingTotal; ?> application(s) waiting for your review.
    <a href="/Admin/View/applications.php">Review now &rarr;</a>
</div>
<?php } ?>

<section class="stat-row">
    <div class="stat"><span class="label">Customers</span><b><?php echo $s['customers']; ?></b></div>
    <div class="stat"><span class="label">Managers</span><b><?php echo $s['managers']; ?></b></div>
    <div class="stat"><span class="label">Employees</span><b><?php echo $s['employees']; ?></b></div>
    <div class="stat"><span class="label">Pending applications</span><b><?php echo $pendingTotal; ?></b></div>
    <div class="stat"><span class="label">Open tasks</span><b><?php echo $s['open_tasks']; ?></b></div>
    <div class="stat"><span class="label">Customer requests open</span><b><?php echo $s['open_requests']; ?></b></div>
    <div class="stat"><span class="label">Transfers today</span><b><?php echo $s['tx_today']; ?></b></div>
    <div class="stat"><span class="label">Manager fund transfers</span><b><?php echo $s['fund_transfers']; ?></b></div>
    <div class="stat"><span class="label">Transfers, all time</span><b><?php echo $s['tx_total']; ?></b></div>
    <div class="stat"><span class="label">Customer holdings</span><b>৳ <?php echo money($s['holdings']); ?></b></div>
</section>

<section class="grid">
    <div class="card">
        <h2>Latest activity</h2>
        <?php if (!$recent) { ?><p class="muted">Nothing recorded yet.</p><?php } ?>
        <ul class="list">
        <?php foreach ($recent as $a) { ?>
            <li>
                <span><strong><?php echo h($a['actor']); ?></strong> <span class="muted">(<?php echo h($a['actor_role']); ?>)</span> &middot; <?php echo h(str_replace('_', ' ', $a['action'])); ?>
                    <?php if ($a['detail'] !== '') { ?><br><span class="muted small"><?php echo h($a['detail']); ?></span><?php } ?></span>
                <span class="muted small"><?php echo h($a['created_at']); ?></span>
            </li>
        <?php } ?>
        </ul>
        <a class="btn btn-ghost" href="/Admin/View/activity.php">Full activity log</a>
    </div>
    <div class="card">
        <h2>Quick actions</h2>
        <a class="btn" href="/Admin/View/applications.php">Review applications</a>
        <a class="btn btn-ghost" href="/Admin/View/staff_add.php">Add staff member</a>
        <a class="btn btn-ghost" href="/Admin/View/customer_form.php">Add customer</a>
        <a class="btn btn-ghost" href="/Admin/View/tasks.php">Assign work</a>
        <a class="btn btn-ghost" href="/Admin/View/postnews.php">Post news</a>
        <a class="btn btn-ghost" href="/Admin/View/transactions.php">View all transactions</a>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
