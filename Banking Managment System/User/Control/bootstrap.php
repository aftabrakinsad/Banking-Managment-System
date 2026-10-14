<?php
// Shared helpers for the customer portal: session, CSRF, flash messages, escaping.
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/activity.php';
require_once __DIR__ . '/../Model/db.php';

function udb() { static $d = null; if ($d === null) { $d = new UserDb(); } return $d; }

function require_login() {
    if (empty($_SESSION['cust_id'])) { redirect('login.php'); }
    $u = udb()->findById((int)$_SESSION['cust_id']);
    if (!$u) { session_destroy(); redirect('login.php'); }
    return $u;
}

