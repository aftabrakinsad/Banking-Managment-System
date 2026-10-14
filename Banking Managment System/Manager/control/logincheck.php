<?php
// Manager sign-in: prepared lookup, hashed passwords (plain-text legacy rows are upgraded on first login), CSRF, lockout.
require_once __DIR__ . '/bootstrap.php';

$error = '';

if (isset($_POST['submit']))
{
    csrf_verify();
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $now = time();

    if (isset($_SESSION['mgr_lock']) && $_SESSION['mgr_lock'] > $now)
    {
        $error = 'Too many failed attempts. Try again in a few minutes.';
    }
    elseif ($username === '' || $password === '')
    {
        $error = 'Enter your username and password.';
    }
    else
    {
        $m = mrepo()->find($username);
        if ($m && verify_secret($password, $m['pass']))
        {
            if (ManagerRepo::isInactive($m['activeStatus']))
            {
                log_activity('manager', $username, 'login_blocked', 'inactive account');
                $error = 'Your account is inactive. Please contact the administrator.';
            }
            else
            {
                if (!is_hashed($m['pass'])) { mrepo()->setPasswordHash($m['username'], password_hash($password, PASSWORD_DEFAULT)); }
                mrepo()->ensureAccount($m['username']);
                session_regenerate_id(true);
                $_SESSION['username'] = $m['username'];
                unset($_SESSION['mgr_fails'], $_SESSION['mgr_lock']);
                log_activity('manager', $m['username'], 'login');
                redirect('/Manager/view/managerHomePage.php');
            }
        }
        else
        {
            $_SESSION['mgr_fails'] = (isset($_SESSION['mgr_fails']) ? $_SESSION['mgr_fails'] : 0) + 1;
            if ($_SESSION['mgr_fails'] >= 5) { $_SESSION['mgr_lock'] = $now + 300; $_SESSION['mgr_fails'] = 0; }
            log_activity('manager', $username, 'login_failed');
            $error = 'Username or password is incorrect.';
        }
    }
}
