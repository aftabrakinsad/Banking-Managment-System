<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$errors = [];
$audiences = ['all' => 'Everyone', 'customer' => 'Customers', 'manager' => 'Managers', 'employee' => 'Employees'];
$v = ['title' => '', 'body' => '', 'audience' => 'all'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    if (isset($_POST['delete'])) {
        adb()->deleteNews((int)$_POST['delete']);
        log_activity('admin', $admin['uname'], 'deleted_news', '#' . (int)$_POST['delete']);
        flash('success', 'News removed.');
        redirect('/Admin/View/postnews.php');
    }
    $v['title'] = trim(isset($_POST['title']) ? $_POST['title'] : '');
    $v['body'] = trim(isset($_POST['body']) ? $_POST['body'] : '');
    $v['audience'] = isset($_POST['audience']) ? $_POST['audience'] : '';
    if ($v['title'] === '' || strlen($v['title']) > 100) { $errors[] = 'Enter a headline (up to 100 characters).'; }
    if ($v['body'] === '' || strlen($v['body']) > 500) { $errors[] = 'Enter the details (up to 500 characters).'; }
    if (!isset($audiences[$v['audience']])) { $errors[] = 'Choose an audience.'; }
    if (!$errors) {
        adb()->postNews($v['title'], $v['body'], $v['audience']);
        log_activity('admin', $admin['uname'], 'posted_news', $v['audience'] . ': ' . $v['title']);
        flash('success', 'News posted for ' . strtolower($audiences[$v['audience']]) . '.');
        redirect('/Admin/View/postnews.php');
    }
}
$items = adb()->allNews();
$pageTitle = 'Post news';
require __DIR__ . '/header.php';
?>
<h1>Post news</h1>
<section class="grid">
    <div class="card">
        <h2>New announcement</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>Headline <input type="text" name="title" maxlength="100" value="<?php echo h($v['title']); ?>" required></label>
            <label>Details <textarea name="body" maxlength="500" required><?php echo h($v['body']); ?></textarea></label>
            <label>Audience
                <select name="audience">
                    <?php foreach ($audiences as $k => $l) { ?><option value="<?php echo $k; ?>"<?php echo $v['audience'] === $k ? ' selected' : ''; ?>><?php echo $l; ?></option><?php } ?>
                </select>
            </label>
            <button class="btn" type="submit">Post</button>
        </form>
    </div>
    <div class="card">
        <h2>Published (<?php echo count($items); ?>)</h2>
        <ul class="list">
        <?php foreach ($items as $n) { ?>
            <li>
                <span><strong><?php echo h($n['tittle']); ?></strong> <span class="badge" style="background:var(--brand)"><?php echo h($audiences[$n['audience']]); ?></span><br>
                    <span class="small"><?php echo h($n['news_body']); ?></span><br><span class="muted small"><?php echo h($n['created']); ?></span></span>
                <form method="post" onsubmit="return confirm('Remove this news item?');"><?php echo csrf_field(); ?>
                    <button class="btn btn-small btn-danger" name="delete" value="<?php echo (int)$n['news_id']; ?>">Remove</button></form>
            </li>
        <?php } ?>
        </ul>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
