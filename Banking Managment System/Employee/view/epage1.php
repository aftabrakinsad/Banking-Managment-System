<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) { header("location: ../view/employelogin.php"); exit; }
$pageTitle = 'Dashboard';
@include("../view/header.php");
require_once __DIR__ . '/../../config/feed.php';
$actions = [
    ['showuserinfo.php', 'Customers', 'Browse customer accounts and contact details.'],
    ['add_user.php', 'Add customer', 'Look up and update a customer account.'],
    ['transferfund.php', 'Transfer funds', 'Move money between customer accounts.'],
    ['qurey.php', 'Customer queries', 'Post and review customer queries.'],
    ['viewinformation.php', 'My profile', 'Review and update your own details.'],
    ['employeedetails.php', 'Employee applications', 'See registered employee applicants.'],
];
?>
<h1>Welcome back<?php include('../control/cookie.php'); ?></h1>
<?php render_admin_feed('employee', $_SESSION['username']); ?>
<h2>Shortcuts</h2>
<section class="grid portals">
<?php foreach ($actions as $a) { ?>
    <a class="card portal" href="../view/<?php echo $a[0]; ?>"><h2><?php echo $a[1]; ?></h2><p class="muted"><?php echo $a[2]; ?></p></a>
<?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
