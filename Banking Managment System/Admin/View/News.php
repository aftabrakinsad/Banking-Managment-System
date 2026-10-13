<?php
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';
$pageTitle = 'News';
$conn = bank_db_connect();
$res = $conn->query("SELECT tittle, news_body, created FROM news WHERE audience IN ('all','customer') ORDER BY news_id DESC LIMIT 50");
$items = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
@include("../View/public_top.php");
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
<a class="btn btn-ghost" href="/Admin/View/Home.php">Back to home</a>
<?php @include("../View/footer.php"); ?>
