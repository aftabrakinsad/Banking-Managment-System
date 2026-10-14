<?php
// Employee sign-in. Verifies against employeelogin with a prepared statement and stores only the username in the session.
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/activity.php';

$loginError = '';

if (isset($_POST['submit']))
{
    csrf_verify();
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $now = time();

    if (isset($_SESSION['emp_lock']) && $_SESSION['emp_lock'] > $now)
    {
        $loginError = 'Too many failed attempts. Try again in a few minutes.';
    }
    elseif ($username === '' || $password === '')
    {
        $loginError = "Username and password can't be empty.";
    }
    else
    {
        $conn = bank_db_connect();
        $st = $conn->prepare("SELECT username, password FROM employeelogin WHERE username = ?");
        $st->bind_param('s', $username);
        $st->execute();
        $row = $st->get_result()->fetch_assoc();
        $st->close();

        if ($row && verify_secret($password, $row['password']))
        {
            if (!is_hashed($row['password'])) {
                $up = $conn->prepare("UPDATE employeelogin SET password = ? WHERE username = ?");
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $up->bind_param('ss', $hash, $row['username']); $up->execute(); $up->close();
            }
            session_regenerate_id(true);
            $_SESSION['username'] = $row['username'];
            unset($_SESSION['emp_fails'], $_SESSION['emp_lock']);
            log_activity('employee', $row['username'], 'login');
            redirect('/Employee/view/epage1.php');
        }

        $_SESSION['emp_fails'] = (isset($_SESSION['emp_fails']) ? $_SESSION['emp_fails'] : 0) + 1;
        if ($_SESSION['emp_fails'] >= 5) { $_SESSION['emp_lock'] = $now + 300; $_SESSION['emp_fails'] = 0; }
        log_activity('employee', $username, 'login_failed');
        $loginError = 'Username or password is incorrect.';
    }
}
if (isset($_POST['registration']))
{
    redirect('/Employee/view/employeregistration.php');
}
