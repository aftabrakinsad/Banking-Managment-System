<?php
require_once __DIR__ . '/../Control/login.process.php';
$title = 'Sign in';
require __DIR__ . '/layout_top.php';
?>
<section class="card auth">
    <h1>Customer sign in</h1>
    <p class="muted">Access your account, transfer money and view statements.</p>
    <?php if ($error) { ?><div class="alert alert-error" role="alert"><?php echo h($error); ?></div><?php } ?>
    <form method="post" autocomplete="on">
        <?php echo csrf_field(); ?>
        <label>Username
            <input type="text" name="username" required autofocus autocomplete="username" value="<?php echo h(isset($_POST['username']) ? $_POST['username'] : ''); ?>">
        </label>
        <label>Password
            <input type="password" name="password" required autocomplete="current-password">
        </label>
        <button class="btn" type="submit">Sign in</button>
    </form>
    <p class="muted small">Demo: <code>casey</code> / <code>Demo@1234</code></p>
    <p class="small"><a href="/">&larr; Back to home</a></p>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
