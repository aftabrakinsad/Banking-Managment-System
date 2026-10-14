<?php
// Manager portal bootstrap: shared helpers, repository, auth guard.
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/activity.php';
require_once __DIR__ . '/../../config/managers.php';

function mrepo() { static $r = null; if ($r === null) { $r = new ManagerRepo(); } return $r; }

// The session carries only `username`. Re-check on every page that the manager still exists and is not inactive.
function require_manager()
{
    if (empty($_SESSION['username'])) { redirect('/Manager/view/managerlogin.php'); }
    $m = mrepo()->find($_SESSION['username']);
    if (!$m || ManagerRepo::isInactive($m['activeStatus'])) {
        $_SESSION = [];
        session_destroy();
        redirect('/Manager/view/managerlogin.php');
    }
    return $m;
}
