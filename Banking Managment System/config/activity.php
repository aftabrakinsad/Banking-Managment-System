<?php
// Append-only audit trail shown on the admin dashboard.
require_once __DIR__ . '/database.php';

function log_activity($role, $actor, $action, $detail = '')
{
    static $conn = null;
    if ($conn === null) { $conn = bank_db_connect(); }
    $st = $conn->prepare("INSERT INTO activity_log (actor_role, actor, action, detail, ip) VALUES (?, ?, ?, ?, ?)");
    if (!$st) { return; }
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    // Behind Render's proxy the real client is the first X-Forwarded-For entry.
    if (getenv('APP_ENV') === 'production' && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $first = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        if (filter_var($first, FILTER_VALIDATE_IP)) { $ip = $first; }
    }
    $ip = substr($ip, 0, 45);
    $role = substr((string)$role, 0, 20); $actor = substr((string)$actor, 0, 100);
    $action = substr((string)$action, 0, 60); $detail = substr((string)$detail, 0, 255);
    $st->bind_param('sssss', $role, $actor, $action, $detail, $ip);
    $st->execute();
    $st->close();
}
