<?php
require_once __DIR__ . '/bootstrap.php';

if (!empty($_SESSION['cust_id'])) { redirect('dashboard.php'); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $now = time();
    $lockUntil = isset($_SESSION['login_lock']) ? $_SESSION['login_lock'] : 0;
    $uname = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    if ($lockUntil > $now) {
        $error = 'Too many failed attempts. Try again in ' . ceil(($lockUntil - $now) / 60) . ' minute(s).';
    } elseif ($uname === '' || $pass === '') {
        $error = 'Enter your username and password.';
    } else {
        $u = udb()->findByUsername($uname);
        if ($u && verify_secret($pass, $u['password'])) {
            if (!is_hashed($u['password'])) { udb()->setPassword((int)$u['user_id'], password_hash($pass, PASSWORD_DEFAULT)); }
            session_regenerate_id(true);
            $_SESSION['cust_id'] = (int)$u['user_id'];
            unset($_SESSION['login_fails'], $_SESSION['login_lock']);
            log_activity('customer', $u['uname'], 'login');
            redirect('dashboard.php');
        }
        $_SESSION['login_fails'] = (isset($_SESSION['login_fails']) ? $_SESSION['login_fails'] : 0) + 1;
        if ($_SESSION['login_fails'] >= 5) { $_SESSION['login_lock'] = $now + 300; $_SESSION['login_fails'] = 0; }
        log_activity('customer', $uname, 'login_failed');
        $error = 'Invalid username or password.';
    }
}
