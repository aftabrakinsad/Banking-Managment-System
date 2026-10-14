<?php
$pageTitle = 'Admin sign in';
@include('../Control/adminlogincheck.php');

if (isset($_SESSION['admin_id'])) {
    header("location: ../View/adminhomepage.php");
    exit;
}
@include("../View/public_top.php");

$q = $_SERVER['REQUEST_URI'];
$msg = '';
if (strpos($q, "login=empty") !== false) { $msg = 'You did not fill all the fields.'; }
elseif (strpos($q, "username=empty") !== false) { $msg = 'Please enter your username.'; }
elseif (strpos($q, "password=empty") !== false) { $msg = 'Please enter your password.'; }
elseif (strpos($q, "login_info=incorrect") !== false) { $msg = 'Username or password is incorrect.'; }
elseif (strpos($q, "login_info=locked") !== false) { $msg = 'Too many failed attempts. Try again in a few minutes.'; }
?>
<section class="card auth">
    <h1>Admin sign in</h1>
    <p class="muted">Manage customers, staff, requests and bank operations.</p>
    <?php if ($msg) { ?><div class="alert alert-error" role="alert"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" onsubmit="return form_check_admin()" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <label>Username
            <input type="text" name="uname" id="uname" placeholder="Username" onkeyup="usernamecheck_admin()" autocomplete="username">
        </label>
        <p id="nameerr"></p><p id="unameajaxresponse"></p>
        <label>Password
            <input type="password" name="pass" id="pass" onkeyup="passwordcheck_admin()" placeholder="Password" autocomplete="current-password">
        </label>
        <p id="passerr"></p>
        <input class="inputbutton" type="submit" name="submit" value="Sign in">
    </form>
    <p class="muted small">There is a single, fixed master administrator account.</p>
    <?php if (demo_mode()) { ?><p class="muted small">Demo: <code>admin</code> / <code>Demo@1234</code></p><?php } ?>
</section>
<script src="../JS/adminlogin.js"></script>
<?php @include("../View/footer.php"); ?>
