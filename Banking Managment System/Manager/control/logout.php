<?php
require_once __DIR__ . '/bootstrap.php';
if (!empty($_SESSION['username'])) { log_activity('manager', $_SESSION['username'], 'logout'); }
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
redirect('/Manager/view/managerlogin.php');
