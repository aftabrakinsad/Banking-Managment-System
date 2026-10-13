<?php
// Master-admin portal bootstrap: session, shared helpers, auth guard.
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/activity.php';
require_once __DIR__ . '/../Model/admin.php';

function adb() { static $d = null; if ($d === null) { $d = new AdminDb(); } return $d; }

// Only a session created by the master-admin login carries admin_id.
function require_admin()
{
    if (empty($_SESSION['admin_id'])) { redirect('/Admin/View/adminlogin.php'); }
    $a = adb()->findAdminById((int)$_SESSION['admin_id']);
    if (!$a) { session_destroy(); redirect('/Admin/View/adminlogin.php'); }
    return $a;
}
