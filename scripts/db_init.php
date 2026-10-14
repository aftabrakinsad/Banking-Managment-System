<?php
// Loads the schema and demo data into the database named by the DB_* environment variables.
//
//   php /opt/scripts/db_init.php             first-time load (refuses if the database already has tables)
//   php /opt/scripts/db_init.php --reset --yes   DROP every table, then load again (use for a demo reset)
//
// Optional: MASTER_ADMIN_PASSWORD=...  replaces the demo master-admin password after loading.
require_once '/var/www/html/config/database.php';
require_once __DIR__ . '/sqlsplit.php';

$reset = in_array('--reset', $argv, true);
$yes = in_array('--yes', $argv, true);
$dir = is_dir('/opt/db/init') ? '/opt/db/init' : __DIR__ . '/../db/init';

$conn = bank_db_connect();
echo "Connected to " . (getenv('DB_HOST') ?: 'localhost') . " / " . (getenv('DB_NAME') ?: 'bankingmanagementsystem') . "\n";

$tables = [];
$res = $conn->query('SHOW TABLES');
while ($res && ($row = $res->fetch_row())) { $tables[] = $row[0]; }

if ($tables && !$reset) { fwrite(STDERR, "The database already has " . count($tables) . " tables. Nothing was changed.\nUse --reset --yes to wipe and reload (this DELETES all data).\n"); exit(2); }
if ($tables && $reset) {
    if (!$yes) { fwrite(STDERR, "--reset deletes ALL data in this database. Add --yes to confirm.\n"); exit(2); }
    foreach ($tables as $t) { $conn->query('DROP TABLE IF EXISTS `' . str_replace('`', '``', $t) . '`'); }
    echo "Dropped " . count($tables) . " tables.\n";
}

// Only the numbered schema files (01_name.sql, 02_name.sql ...). Copies such as "01_schema 2.sql" are skipped.
$files = [];
foreach (glob($dir . '/*.sql') as $f) {
    if (preg_match('/^\d{2}_[A-Za-z0-9_]+\.sql$/', basename($f))) { $files[] = $f; }
    else { echo "Skipping unexpected file: " . basename($f) . "\n"; }
}
sort($files);
$count = 0;
foreach ($files as $f) {
    foreach (split_sql(file_get_contents($f)) as $stmt) {
        if (!$conn->query($stmt)) {
            fwrite(STDERR, "FAILED in " . basename($f) . ":\n  " . $conn->error . "\n  " . substr(preg_replace('/\s+/', ' ', $stmt), 0, 160) . "\n");
            exit(1);
        }
        $count++;
    }
    echo "Loaded " . basename($f) . "\n";
}

$pw = getenv('MASTER_ADMIN_PASSWORD');
if ($pw !== false && $pw !== '') {
    $hash = password_hash($pw, PASSWORD_DEFAULT);
    $st = $conn->prepare("UPDATE staticadmin SET pass = ? WHERE admin_id = 1");
    $st->bind_param('s', $hash); $st->execute();
    echo "Master admin password set from MASTER_ADMIN_PASSWORD.\n";
}
echo "Done: $count statements executed.\n";
