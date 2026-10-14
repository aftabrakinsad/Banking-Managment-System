<?php
// Registration availability check (prepared statements; no output unless a value was sent).
require_once __DIR__ . '/../../config/applications.php';

$value = trim(isset($_POST['Phone']) ? (string)$_POST['Phone'] : '');
if ($value !== '' && strlen($value) <= 100)
{
    echo (new ApplicationRepo())->taken('phone', $value) ? 'That phone number is already registered.' : 'Phone number is available.';
}
