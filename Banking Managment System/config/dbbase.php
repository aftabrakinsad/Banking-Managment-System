<?php
require_once __DIR__ . '/database.php';

// Tiny prepared-statement helper shared by repositories.
abstract class BaseDb
{
    public $conn;

    function __construct() { $this->conn = bank_db_connect(); }

    protected function rows($sql, $types = '', $params = [])
    {
        $st = $this->conn->prepare($sql);
        if (!$st) { error_log('SQL prepare: ' . $this->conn->error); return []; }
        if ($types !== '') { $st->bind_param($types, ...$params); }
        $st->execute();
        $res = $st->get_result();
        $out = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        $st->close();
        return $out;
    }

    protected function run($sql, $types = '', $params = [])
    {
        $st = $this->conn->prepare($sql);
        if (!$st) { error_log('SQL prepare: ' . $this->conn->error); return false; }
        if ($types !== '') { $st->bind_param($types, ...$params); }
        $ok = $st->execute();
        $n = $ok ? $st->affected_rows : false;
        $st->close();
        return $n;
    }

    protected function one($sql, $types = '', $params = [])
    {
        $r = $this->rows($sql, $types, $params);
        return $r ? $r[0] : null;
    }
}
