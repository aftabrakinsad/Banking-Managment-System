<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$managers = adb()->managers();
$employees = adb()->employees();
$pageTitle = 'Staff';
require __DIR__ . '/header.php';
?>
<h1>Staff</h1>
<div class="page-actions"><a class="btn" href="/Admin/View/staff_add.php">Add staff member</a></div>

<section class="card">
    <h2>Managers (<?php echo count($managers); ?>)</h2>
    <?php if (!$managers) { ?><p class="muted">No managers yet.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Salary</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($managers as $m) { ?>
            <tr>
                <td><?php echo h($m['firstname'] . ' ' . $m['lastname']); ?></td>
                <td><?php echo h($m['username']); ?></td>
                <td><?php echo h($m['email']); ?></td>
                <td><?php echo h($m['phone']); ?></td>
                <td>৳ <?php echo h($m['salary']); ?></td>
                <td><?php echo h($m['activeStatus']); ?></td>
                <td><a class="btn btn-small" href="/Admin/View/staff_edit.php?role=manager&amp;id=<?php echo (int)$m['id']; ?>">Manage</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>

<section class="card">
    <h2>Employees (<?php echo count($employees); ?>)</h2>
    <?php if (!$employees) { ?><p class="muted">No employees yet.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Reports to</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($employees as $e) { ?>
            <tr>
                <td><?php echo h(trim($e['fname'] . ' ' . $e['lname'])); ?></td>
                <td><?php echo h($e['username']); ?></td>
                <td><?php echo h($e['email']); ?></td>
                <td><?php echo h($e['phone']); ?></td>
                <td><?php echo h($e['manager'] ? $e['manager'] : '-'); ?></td>
                <td><a class="btn btn-small" href="/Admin/View/staff_edit.php?role=employee&amp;id=<?php echo (int)$e['id']; ?>">Manage</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>
