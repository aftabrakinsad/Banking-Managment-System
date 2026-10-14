<?php
$pageTitle = 'Employee sign in';
include('../control/emplogin.php');     #employee login control

if (isset($_SESSION['username'])) {
    header("location: ../view/epage1.php");
    exit;
}
@include("../view/public_top.php");
?>
<section class="card auth">
    <h1>Employee sign in</h1>
    <p class="muted">Sign in to manage customers and accounts.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" onsubmit="return validlogin()" enctype="multipart/form-data">
        <label>Username
            <input type="text" id="username" name="username" onchange="uname_AJAX()" onkeyup="usernamecheck()" placeholder="Enter username" autocomplete="username">
        </label>
        <p id="usererr"></p><p id="unameajaxresponse"></p>
        <label>Password
            <input type="password" id="password" name="password" onkeyup="passwordcheck()" placeholder="Enter password" autocomplete="current-password">
        </label>
        <p id="passworderr"></p>
        <label style="font-weight:400"><input type="checkbox" name="remember" id="remember">Remember me</label>
        <input class="login" type="submit" name="submit" value="Sign in">
    </form>
    <p class="small"><a href="../view/employeregistration.php">Create an account</a> · <a id="denger" href="../view/forgetpassword.php">Forgot password?</a></p>
    <p class="small"><a href="/">&larr; Home</a></p>
    <p class="muted small">Demo: <code>employee</code> / <code>Demo@1234</code></p>
</section>
<script src="../JS/loginjs.js"></script>
<?php @include("../view/footer.php"); ?>
