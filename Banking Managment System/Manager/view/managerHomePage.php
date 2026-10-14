<?php
require_once __DIR__ . '/../control/bootstrap.php';
$pageTitle = 'Home';
require __DIR__ . '/header.php';
require_once __DIR__ . '/../../config/feed.php';
$acct = mrepo()->ensureAccount($manager['username']);
$fresh = mrepo()->find($manager['username']);
?>
<h1>Welcome back<?php echo h($name); ?></h1>
<section class="stat-row">
    <div class="stat"><span class="label">Funds account</span><b><?php echo $acct ? h($acct) : '-'; ?></b></div>
    <div class="stat"><span class="label">Available funds</span><b>৳ <?php echo money($fresh['fund']); ?></b></div>
</section>
<?php render_admin_feed('manager', $manager['username']); ?>
<?php @include("../view/footer.php"); ?>
