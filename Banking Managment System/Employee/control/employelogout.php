<?php
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/activity.php';
if (!empty($_SESSION['username'])) { log_activity('employee', $_SESSION['username'], 'logout'); }
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
redirect('/Employee/view/employelogin.php');
