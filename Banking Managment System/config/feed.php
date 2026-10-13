<?php
// "From the admin" panel for the Manager and Employee dashboards: assigned tasks + audience news.
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/activity.php';

function render_admin_feed($role, $username)
{
    $conn = bank_db_connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_task'])) {
        csrf_verify();
        $tid = (int)$_POST['complete_task'];
        $st = $conn->prepare("UPDATE tasks SET status = 'done', completed_at = NOW() WHERE id = ? AND assignee_role = ? AND assignee_username = ? AND status = 'open'");
        $st->bind_param('iss', $tid, $role, $username);
        $st->execute();
        if ($st->affected_rows > 0) { log_activity($role, $username, 'completed_task', '#' . $tid); flash('success', 'Task marked as done.'); }
        $st->close();
        redirect($_SERVER['REQUEST_URI']);
    }

    $st = $conn->prepare("SELECT id, title, details, due_date FROM tasks WHERE assignee_role = ? AND assignee_username = ? AND status = 'open' ORDER BY due_date IS NULL, due_date, id");
    $st->bind_param('ss', $role, $username);
    $st->execute();
    $tasks = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();

    $st = $conn->prepare("SELECT tittle, news_body, created FROM news WHERE audience IN ('all', ?) ORDER BY news_id DESC LIMIT 10");
    $st->bind_param('s', $role);
    $st->execute();
    $news = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
    ?>
    <section class="grid">
        <div class="card">
            <h2>My tasks (<?php echo count($tasks); ?>)</h2>
            <?php if (!$tasks) { ?><p class="muted">Nothing assigned to you right now.</p><?php } ?>
            <ul class="list">
            <?php foreach ($tasks as $t) { ?>
                <li>
                    <span><strong><?php echo h($t['title']); ?></strong>
                        <?php if ($t['due_date']) { ?><span class="muted small"> · due <?php echo h($t['due_date']); ?></span><?php } ?>
                        <?php if ($t['details'] !== '' && $t['details'] !== null) { ?><br><span class="small"><?php echo h($t['details']); ?></span><?php } ?></span>
                    <form method="post"><?php echo csrf_field(); ?>
                        <button class="btn btn-small" name="complete_task" value="<?php echo (int)$t['id']; ?>">Mark done</button></form>
                </li>
            <?php } ?>
            </ul>
        </div>
        <div class="card">
            <h2>News from the admin</h2>
            <?php if (!$news) { ?><p class="muted">No announcements.</p><?php } ?>
            <ul class="list">
            <?php foreach ($news as $n) { ?>
                <li><span><strong><?php echo h($n['tittle']); ?></strong><br><span class="small"><?php echo h($n['news_body']); ?></span></span>
                    <span class="muted small"><?php echo h(substr($n['created'], 0, 10)); ?></span></li>
            <?php } ?>
            </ul>
        </div>
    </section>
    <?php
}
