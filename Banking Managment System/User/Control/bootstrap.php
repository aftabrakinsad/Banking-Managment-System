<?php
// Shared helpers for the customer portal: session, CSRF, flash messages, escaping.
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../Model/db.php';

function udb() { static $d = null; if ($d === null) { $d = new UserDb(); } return $d; }

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function money($n) { return number_format((float)$n, 2); }
function redirect($to) { header('Location: ' . $to); exit; }

function csrf_token() {
    if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
    return $_SESSION['csrf'];
}
function csrf_field() { return '<input type="hidden" name="csrf" value="' . h(csrf_token()) . '">'; }
function csrf_verify() {
    $ok = isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']);
    if (!$ok) { http_response_code(400); exit('Invalid request token. Go back, refresh the page and try again.'); }
}

function flash($type, $msg) { $_SESSION['flash'] = [$type, $msg]; }
function take_flash() { $f = isset($_SESSION['flash']) ? $_SESSION['flash'] : null; unset($_SESSION['flash']); return $f; }

// Accepts hashes and, for legacy seed/admin-created rows, plain text.
function verify_secret($input, $stored) {
    $stored = (string)$stored;
    if (strncmp($stored, '$2y$', 4) === 0 || strncmp($stored, '$argon', 6) === 0) { return password_verify((string)$input, $stored); }
    return $stored !== '' && hash_equals($stored, (string)$input);
}
function is_hashed($stored) { return strncmp((string)$stored, '$2y$', 4) === 0 || strncmp((string)$stored, '$argon', 6) === 0; }

function require_login() {
    if (empty($_SESSION['cust_id'])) { redirect('login.php'); }
    $u = udb()->findById((int)$_SESSION['cust_id']);
    if (!$u) { session_destroy(); redirect('login.php'); }
    return $u;
}

function valid_password($p) {
    return strlen($p) >= 8 && preg_match('/[A-Z]/', $p) && preg_match('/[a-z]/', $p)
        && preg_match('/[0-9]/', $p) && preg_match('/[^A-Za-z0-9]/', $p);
}
