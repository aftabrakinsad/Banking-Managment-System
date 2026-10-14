<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$q = trim(isset($_GET['q']) ? $_GET['q'] : '');
if (strlen($q) > 60) { $q = substr($q, 0, 60); }
$rows = crepo()->search($q);
$pageTitle = 'Customers';
require __DIR__ . '/header.php';
?>
<h1>Customers</h1>
<div class="page-actions"><a class="btn" href="../view/customer_form.php">Open an account</a></div>
<section class="card">
    <form method="get" class="filters search">
        <label>Search by name, username or account number
            <input type="search" name="q" value="<?php echo h($q); ?>" placeholder="e.g. casey or 3000001" autocomplete="off">
        </label>
        <button class="btn" type="submit">Search</button>
        <?php if ($q !== '') { ?><a class="btn btn-ghost" href="../view/customers.php">Clear</a><?php } ?>
    </form>
    <?php if (!$rows) { ?><p class="muted"><?php echo $q === '' ? 'No customers yet.' : 'No customers match that search.'; ?></p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th></th><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Account no.</th><th>Balance</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $c) { ?>
            <tr>
                <td><?php if ($c['picture'] !== '') { ?><img src="/Admin/uploads/<?php echo h($c['picture']); ?>" alt="" width="48" height="48" onerror="this.style.display='none'"><?php } ?></td>
                <td><strong><?php echo h($c['fname'] . ' ' . $c['lname']); ?></strong></td>
                <td><?php echo h($c['uname']); ?></td>
                <td><?php echo h($c['email']); ?></td>
                <td><?php echo h($c['phone']); ?></td>
                <td><?php echo h($c['accountno']); ?></td>
                <td>৳ <?php echo money(crepo()->balance((int)$c['accountno'])); ?></td>
                <td><a class="btn btn-small" href="../view/customer_form.php?id=<?php echo (int)$c['user_id']; ?>">Update</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
