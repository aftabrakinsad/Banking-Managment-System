<?php
// Registration availability check (prepared statements; no output unless a value was sent).
require_once __DIR__ . '/../../config/applications.php';

$value = trim(isset($_POST['Username']) ? (string)$_POST['Username'] : '');
if ($value !== '' && strlen($value) <= 100)
{
    echo (new ApplicationRepo())->taken('username', $value) ? 'That username is already taken.' : 'Username is available.';
}
