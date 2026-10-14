<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    if (isset($_POST['action']) && $_POST['action'] === 'remove') {
        $gone = adb()->removeCustomer((int)(isset($_POST['id']) ? $_POST['id'] : 0));
        if ($gone !== null) { log_activity('admin', $admin['uname'], 'removed_customer', $gone); flash('success', 'Customer ' . $gone . ' removed.'); }
        else { flash('error', 'Customer not found.'); }
    }
    redirect('/Admin/View/customers.php');
}
$rows = adb()->customers();
$pageTitle = 'Customers';
require __DIR__ . '/header.php';
?>
<h1>Customers</h1>
<div class="page-actions"><a class="btn" href="/Admin/View/customer_form.php">Add customer</a></div>
<section class="card">
    <?php if (!$rows) { ?><p class="muted">No customers yet.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th></th><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Account no.</th><th>Balance</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $c) { ?>
            <tr>
                <td><?php if ($c['picture'] !== '') { ?><img src="/Admin/uploads/<?php echo h($c['picture']); ?>" alt="" width="48" height="48" onerror="this.style.display='none'"><?php } ?></td>
                <td><?php echo h($c['fname'] . ' ' . $c['lname']); ?></td>
                <td><?php echo h($c['uname']); ?></td>
                <td><?php echo h($c['email']); ?></td>
                <td><?php echo h($c['phone']); ?></td>
                <td><?php echo h($c['accountno']); ?></td>
                <td>৳ <?php echo money(adb()->customerBalance((int)$c['accountno'])); ?></td>
                <td>
                    <a class="btn btn-small" href="/Admin/View/customer_form.php?id=<?php echo (int)$c['user_id']; ?>">Update</a>
                    <form method="post" onsubmit="return confirm('Remove this customer?');">
                        <?php echo csrf_field(); ?><input type="hidden" name="action" value="remove"><input type="hidden" name="id" value="<?php echo (int)$c['user_id']; ?>">
                        <button class="btn btn-small btn-danger" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>
