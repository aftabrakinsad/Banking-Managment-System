<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$pageTitle = 'Home';
require __DIR__ . '/header.php';
require_once __DIR__ . '/../../config/feed.php';
$rc = crepo()->requestCounts();
$actions = [
    ['requests.php', 'Customer requests', $rc['open'] . ' open, ' . $rc['in_progress'] . ' in progress.'],
    ['customers.php', 'Customers', 'Search, view and update customer accounts and photos.'],
    ['customer_form.php', 'Open an account', 'Register a new customer with an opening deposit.'],
    ['cashdesk.php', 'Cash desk', 'Record cash deposits and withdrawals.'],
    ['viewinformation.php', 'My profile', 'Review and update your own details.'],
];
?>
<h1>Welcome back, <?php echo h($employee['username']); ?></h1>
<?php render_admin_feed('employee', $employee['username']); ?>
<h2>Shortcuts</h2>
<section class="grid portals">
<?php foreach ($actions as $a) { ?>
    <a class="card portal" href="../view/<?php echo $a[0]; ?>"><h2><?php echo h($a[1]); ?></h2><p class="muted"><?php echo h($a[2]); ?></p></a>
<?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
