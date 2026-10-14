<?php
$pageTitle = 'Manager sign in';
include('../control/logincheck.php');

if (!empty($_SESSION['username'])) { header("location: ../view/managerHomePage.php"); exit; }
@include("../view/public_top.php");
?>
<section class="card auth">
    <h1>Manager sign in</h1>
    <p class="muted">Sign in to follow your team, tasks and funds.</p>
    <?php if (!empty($error)) { ?><div class="alert alert-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <?php echo csrf_field(); ?>
        <label>Username
            <input type="text" name="username" id="username" placeholder="Enter username" onkeyup="checkusername()" autocomplete="username">
        </label>
        <p id="nameerror"></p>
        <label>Password
            <input type="password" name="password" id="password" placeholder="Enter password" onkeyup="loginpassCheck()" autocomplete="current-password">
        </label>
        <p id="passvalue"></p>
        <input class="login" type="submit" name="submit" value="Sign in">
    </form>
    <p class="small"><a href="../view/managerRegistration.php">Apply for a manager account</a> · <a href="/">&larr; Home</a></p>
    <?php if (demo_mode()) { ?><p class="muted small">Demo: <code>manager</code> / <code>Demo@1234</code></p><?php } ?>
</section>
<script src="../js/managerlogin.js"></script>
<?php @include("../view/footer.php"); ?>
