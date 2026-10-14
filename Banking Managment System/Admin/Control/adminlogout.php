<?php
require_once __DIR__ . '/bootstrap.php';
if (!empty($_SESSION['admin_id'])) { log_activity('admin', 'admin', 'logout'); }
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
redirect('/Admin/View/adminlogin.php');
