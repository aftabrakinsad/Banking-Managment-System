<?php
// Single place for DB settings. Reads DB_* env vars (set by docker-compose / Render).
function bank_db_connect()
{
    $host = getenv('DB_HOST') ?: 'localhost';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    $name = getenv('DB_NAME') ?: 'bankingmanagementsystem';
    $port = (int)(getenv('DB_PORT') ?: 3306);

    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = mysqli_init();

    $flags = 0;
    // Hosted MySQL (TiDB Cloud, etc.) requires TLS. The server certificate is verified against the system CA
    // bundle; set DB_SSL_VERIFY=0 only if a provider's certificate chain cannot be verified.
    if (getenv('DB_SSL') === '1') {
        $ca = getenv('DB_SSL_CA') ?: '/etc/ssl/certs/ca-certificates.crt';
        if (is_readable($ca)) { $conn->ssl_set(null, null, $ca, null, null); }
        mysqli_options($conn, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, getenv('DB_SSL_VERIFY') !== '0');
        $flags = MYSQLI_CLIENT_SSL;
    }
    if (!@$conn->real_connect($host, $user, $pass, $name, $port, null, $flags)) {
        error_log('DB connection failed: ' . mysqli_connect_error());
        http_response_code(500);
        exit('Database unavailable.');
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
