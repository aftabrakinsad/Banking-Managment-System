<?php
// Employee portal bootstrap: shared helpers, customer repository, auth guard.
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/activity.php';
require_once __DIR__ . '/../../config/customers.php';

function crepo() { static $r = null; if ($r === null) { $r = new CustomerRepo(); } return $r; }

// An employee session carries `username`; confirm that employee still exists (the admin may have removed them).
function require_employee()
{
    if (empty($_SESSION['username'])) { redirect('/Employee/view/employelogin.php'); }
    $st = crepo()->conn->prepare("SELECT id, username, email FROM employeelogin WHERE username = ?");
    $st->bind_param('s', $_SESSION['username']);
    $st->execute();
    $e = $st->get_result()->fetch_assoc();
    $st->close();
    if (!$e) { session_destroy(); redirect('/Employee/view/employelogin.php'); }
    return $e;
}
