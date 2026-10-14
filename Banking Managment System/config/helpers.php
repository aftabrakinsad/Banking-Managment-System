<?php
// Helpers shared by the Admin and User portals: escaping, CSRF, flash messages, secrets.
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Demo credentials are shown on sign-in pages unless APP_DEMO=0.
function demo_mode() { return getenv('APP_DEMO') !== '0'; }

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

// Accepts password_hash()/crypt() hashes and, for legacy rows, plain text.
function is_hashed($stored) {
    $s = (string)$stored;
    return strncmp($s, '$2y$', 4) === 0 || strncmp($s, '$argon', 6) === 0 || strncmp($s, '$6$', 3) === 0;
}
function verify_secret($input, $stored) {
    $stored = (string)$stored;
    if (is_hashed($stored)) { return password_verify((string)$input, $stored); }
    return $stored !== '' && hash_equals($stored, (string)$input);
}
function valid_password($p) {
    return strlen($p) >= 8 && preg_match('/[A-Z]/', $p) && preg_match('/[a-z]/', $p)
        && preg_match('/[0-9]/', $p) && preg_match('/[^A-Za-z0-9]/', $p);
}

// Validates and stores an uploaded image (JPG/PNG/WEBP, <= $maxBytes).
// Returns [true, 'relative/path.ext'] or [false, 'error message']. $rel is relative to $baseDir.
function save_image_upload($file, $baseDir, $rel, $maxBytes = 2097152)
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) { return [false, 'Upload failed. Choose an image and try again.']; }
    $info = @getimagesize($file['tmp_name']);
    $allowed = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    if (!$info || !isset($allowed[$info[2]])) { return [false, 'Picture must be a JPG, PNG or WEBP image.']; }
    if ($file['size'] > $maxBytes) { return [false, 'Picture must be ' . round($maxBytes / 1048576) . ' MB or smaller.']; }
    $dir = rtrim($baseDir, '/') . '/' . trim(dirname($rel), '/');
    if (!is_dir($dir)) { mkdir($dir, 0775, true); }
    $name = trim(dirname($rel), '/') . '/' . bin2hex(random_bytes(8)) . '.' . $allowed[$info[2]];
    if (!move_uploaded_file($file['tmp_name'], rtrim($baseDir, '/') . '/' . $name)) { return [false, 'Could not save the picture.']; }
    return [true, $name];
}
