<?php
$pageTitle = 'Manager sign in';
include('../control/logincheck.php');

if (isset($_SESSION['username'])) {
    header("location: ../view/managerHomePage.php");
    exit;
}
@include("../view/public_top.php");
?>
<section class="card auth">
    <h1>Manager sign in</h1>
    <p class="muted">Sign in to manage requests, employees and transfers.</p>
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <label>Username
            <input type="text" name="username" id="username" placeholder="Enter username" onchange="myAJAX()" onkeyup="checkusername()" autocomplete="username">
        </label>
        <p id="nameerror"></p><p id="ajaxresponse"></p>
        <label>Password
            <input type="password" name="password" id="password" placeholder="Enter password" onkeyup="loginpassCheck()" autocomplete="current-password">
        </label>
        <p id="passvalue"></p>
        <label style="font-weight:400"><input type="checkbox" name="remember" id="remember" checked>Remember me</label>
        <input class="login" type="submit" name="submit" value="Sign in">
        <?php if (!empty($error)) { ?><div class="alert alert-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
    </form>
    <p class="small"><a href="../view/managerRegistration.php">Apply for a manager account</a> · <a href="/Admin/View/Home.php">&larr; Home</a></p>
    <p class="muted small">Demo: <code>manager</code> / <code>Demo@1234</code></p>
</section>
<script src="../js/managerlogin.js"></script>
<?php @include("../view/footer.php"); ?>
