<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$items = udb()->notifications((int)$me['user_id']);
udb()->markAllRead((int)$me['user_id']);
$title = 'Alerts';
require __DIR__ . '/layout_top.php';
?>
<h1>Alerts</h1>
<section class="card">
    <?php if (!$items) { ?><p class="muted">Nothing here yet.</p><?php } ?>
    <ul class="list">
    <?php foreach ($items as $n) { ?>
        <li class="<?php echo $n['is_read'] ? '' : 'unread'; ?>">
            <span><?php echo h($n['message']); ?></span>
            <span class="muted small"><?php echo h($n['created_at']); ?></span>
        </li>
    <?php } ?>
    </ul>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
