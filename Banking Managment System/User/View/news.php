<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$items = udb()->news();
$title = 'News';
require __DIR__ . '/layout_top.php';
?>
<h1>Bank news</h1>
<?php if (!$items) { ?><section class="card"><p class="muted">No news yet.</p></section><?php } ?>
<?php foreach ($items as $n) { ?>
<section class="card">
    <h2><?php echo h($n['tittle']); ?></h2>
    <p><?php echo h($n['news_body']); ?></p>
    <span class="muted small"><?php echo h($n['created']); ?></span>
</section>
<?php } ?>
<?php require __DIR__ . '/layout_bottom.php'; ?>
