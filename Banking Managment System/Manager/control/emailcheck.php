<?php
// Registration availability check (prepared statements; no output unless a value was sent).
require_once __DIR__ . '/../../config/applications.php';

$value = trim(isset($_POST['email']) ? (string)$_POST['email'] : '');
if ($value !== '' && strlen($value) <= 100)
{
    echo (new ApplicationRepo())->taken('email', $value) ? 'That email is already registered.' : 'Email is available.';
}
