<?php
// Master-admin sign-in. Single fixed account; the session carries only admin_id (never the password).
require_once __DIR__ . '/bootstrap.php';

if (isset($_POST['submit']))
{
    csrf_verify();
    $uname = trim(isset($_POST['uname']) ? $_POST['uname'] : '');
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $now = time();

    if (isset($_SESSION['admin_lock']) && $_SESSION['admin_lock'] > $now) { redirect('/Admin/View/adminlogin.php?login_info=locked'); }
    if ($uname === '' && $pass === '') { redirect('/Admin/View/adminlogin.php?login=empty'); }
    if ($uname === '') { redirect('/Admin/View/adminlogin.php?username=empty'); }
    if ($pass === '') { redirect('/Admin/View/adminlogin.php?password=empty'); }

    $a = adb()->findAdmin($uname);
    if ($a && verify_secret($pass, $a['pass']))
    {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$a['admin_id'];
        unset($_SESSION['admin_fails'], $_SESSION['admin_lock']);
        log_activity('admin', $a['uname'], 'login');
        redirect('/Admin/View/adminhomepage.php');
    }

    $_SESSION['admin_fails'] = (isset($_SESSION['admin_fails']) ? $_SESSION['admin_fails'] : 0) + 1;
    if ($_SESSION['admin_fails'] >= 5) { $_SESSION['admin_lock'] = $now + 300; $_SESSION['admin_fails'] = 0; }
    log_activity('admin', $uname, 'login_failed');
    redirect('/Admin/View/adminlogin.php?login_info=incorrect');
}
