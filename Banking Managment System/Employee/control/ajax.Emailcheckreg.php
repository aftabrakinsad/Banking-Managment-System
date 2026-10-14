<?php
// Registration availability check (prepared statements; no output unless a value was sent).
require_once __DIR__ . '/../../config/applications.php';

$value = trim(isset($_POST['Email']) ? (string)$_POST['Email'] : '');
if ($value !== '' && strlen($value) <= 100)
{
    echo (new ApplicationRepo())->taken('email', $value) ? 'That email is already registered.' : 'Email is available.';
}
