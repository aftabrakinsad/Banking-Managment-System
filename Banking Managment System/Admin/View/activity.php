<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$role = isset($_GET['role']) ? $_GET['role'] : '';
$roles = array_column(adb()->activityRoles(), 'actor_role');
if (!in_array($role, $roles, true)) { $role = ''; }
$rows = adb()->recentActivity(300, $role);
$pageTitle = 'Activity log';
require __DIR__ . '/header.php';
?>
<h1>Activity log</h1>
<section class="card">
    <form method="get" class="filters">
        <label>Who
            <select name="role" onchange="this.form.submit()">
                <option value="">Everyone</option>
                <?php foreach ($roles as $r) { ?><option value="<?php echo h($r); ?>"<?php echo $role === $r ? ' selected' : ''; ?>><?php echo h(ucfirst($r)); ?></option><?php } ?>
            </select>
        </label>
        <noscript><button class="btn" type="submit">Filter</button></noscript>
    </form>
    <?php if (!$rows) { ?><p class="muted">No activity recorded.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>When</th><th>Role</th><th>Who</th><th>Action</th><th>Details</th><th>IP</th></tr></thead>
        <tbody>
        <?php foreach ($rows as $a) { ?>
            <tr>
                <td><?php echo h($a['created_at']); ?></td>
                <td><?php echo h($a['actor_role']); ?></td>
                <td><?php echo h($a['actor']); ?></td>
                <td><?php echo h(str_replace('_', ' ', $a['action'])); ?></td>
                <td><?php echo h($a['detail']); ?></td>
                <td class="muted small"><?php echo h($a['ip']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>
