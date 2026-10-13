<?php
$pageTitle = 'Home';
@include("../View/public_top.php");
?>
<section class="hero">
    <h1>Banking Management System</h1>
    <p class="muted">A role-based web banking application with Admin, Manager, Employee and Customer portals. Choose a portal to sign in.</p>
</section>
<section class="grid portals">
    <a class="card portal" href="/Admin/View/adminlogin.php"><h2>Admin</h2><p class="muted">Manage customers, staff, requests and finances.</p><span class="btn btn-small">Sign in &rarr;</span></a>
    <a class="card portal" href="/Manager/view/managerlogin.php"><h2>Manager</h2><p class="muted">Approve requests, oversee employees and transfers.</p><span class="btn btn-small">Sign in &rarr;</span></a>
    <a class="card portal" href="/Employee/view/employelogin.php"><h2>Employee</h2><p class="muted">Serve customers and handle account queries.</p><span class="btn btn-small">Sign in &rarr;</span></a>
    <a class="card portal" href="/User/View/login.php"><h2>Customer</h2><p class="muted">Check your balance, send money, download statements.</p><span class="btn btn-small">Sign in &rarr;</span></a>
</section>
<p class="muted small">This is a demo environment with sample data. Latest <a href="/Admin/View/News.php">bank news</a>.</p>
<?php @include("../View/footer.php"); ?>
