<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
    exit;
}
$pageTitle = 'Dashboard';
@include("../View/header.php");
$actions = [
    ['adminrequest.php', 'Admin requests', 'Review and approve new admin applications.'],
    ['usermanage.php', 'Customers', 'View, update and delete customer accounts.'],
    ['manager.php', 'Managers', 'See manager details and assignments.'],
    ['addemp.php', 'Employees', 'Add or remove employees.'],
    ['admin_salary_accno.php', 'Salary &amp; account no.', 'Assign salary and account numbers to admins.'],
    ['atm.php', 'ATM', 'Deposit or withdraw cash.'],
    ['transferfunds.php', 'Transfer funds', 'Move money between accounts.'],
    ['mytransaction.php', 'Transactions', 'Review the transaction history.'],
    ['postnews.php', 'Post news', 'Publish announcements for customers.'],
];
?>
<h1>Welcome back, admin<?php include('../Control/cookie.php'); ?></h1>
<p class="muted">Pick a task to get started.</p>
<section class="grid portals">
<?php foreach ($actions as $a) { ?>
    <a class="card portal" href="../View/<?php echo $a[0]; ?>"><h2><?php echo $a[1]; ?></h2><p class="muted"><?php echo $a[2]; ?></p></a>
<?php } ?>
</section>
<?php @include("../View/footer.php"); ?>
