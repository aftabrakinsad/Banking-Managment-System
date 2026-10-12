<?php
require_once __DIR__ . '/../../config/database.php';

// Customer-portal data access. Everything uses prepared statements.
class UserDb
{
    public $conn;

    function __construct()
    {
        $this->conn = bank_db_connect();
    }

    private function rows($sql, $types = '', $params = [])
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

    private function run($sql, $types = '', $params = [])
    {
        $st = $this->conn->prepare($sql);
        if (!$st) { error_log('SQL prepare: ' . $this->conn->error); return false; }
        if ($types !== '') { $st->bind_param($types, ...$params); }
        $ok = $st->execute();
        $affected = $ok ? $st->affected_rows : false;
        $st->close();
        return $affected;
    }

    function findByUsername($uname)
    {
        $r = $this->rows("SELECT * FROM `user` WHERE uname = ?", 's', [$uname]);
        return $r ? $r[0] : null;
    }

    function findById($id)
    {
        $r = $this->rows("SELECT * FROM `user` WHERE user_id = ?", 'i', [$id]);
        return $r ? $r[0] : null;
    }

    function findByAccount($accountno)
    {
        $r = $this->rows("SELECT user_id, fname, lname, accountno FROM `user` WHERE accountno = ?", 'i', [$accountno]);
        return $r ? $r[0] : null;
    }

    function setPassword($id, $hash)
    {
        return $this->run("UPDATE `user` SET password = ?, cpassword = '' WHERE user_id = ?", 'si', [$hash, $id]);
    }

    function setPin($id, $hash)
    {
        return $this->run("UPDATE `user` SET pin = ? WHERE user_id = ?", 'si', [$hash, $id]);
    }

    function emailTaken($email, $exceptId)
    {
        return (bool)$this->rows("SELECT 1 FROM `user` WHERE email = ? AND user_id <> ?", 'si', [$email, $exceptId]);
    }

    function updateProfile($id, $fname, $lname, $email, $phone)
    {
        return $this->run("UPDATE `user` SET fname = ?, lname = ?, email = ?, phone = ? WHERE user_id = ?",
            'ssssi', [$fname, $lname, $email, $phone, $id]);
    }

    function balance($accountno)
    {
        $r = $this->rows("SELECT balance FROM passbook WHERE accountno = ? ORDER BY trans_id DESC LIMIT 1", 'i', [$accountno]);
        return $r ? (int)$r[0]['balance'] : 0;
    }

    function recent($accountno, $limit = 5)
    {
        return $this->rows("SELECT * FROM passbook WHERE accountno = ? ORDER BY trans_id DESC LIMIT ?", 'ii', [$accountno, $limit]);
    }

    // $from/$to are Y-m-d or ''; $type is '', 'debit' or 'credit'
    function statement($accountno, $from, $to, $type)
    {
        $sql = "SELECT * FROM passbook WHERE accountno = ?";
        $types = 'i'; $params = [$accountno];
        if ($from !== '') { $sql .= " AND trans_date >= ?"; $types .= 's'; $params[] = $from . ' 00:00:00'; }
        if ($to !== '')   { $sql .= " AND trans_date <= ?"; $types .= 's'; $params[] = $to . ' 23:59:59'; }
        if ($type === 'debit')  { $sql .= " AND debit > 0"; }
        if ($type === 'credit') { $sql .= " AND credit > 0"; }
        $sql .= " ORDER BY trans_id DESC LIMIT 1000";
        return $this->rows($sql, $types, $params);
    }

    function monthSummary($accountno)
    {
        $r = $this->rows("SELECT COALESCE(SUM(debit),0) AS out_total, COALESCE(SUM(credit),0) AS in_total
                          FROM passbook WHERE accountno = ? AND trans_date >= NOW() - INTERVAL 30 DAY", 'i', [$accountno]);
        return $r[0];
    }

    // ---- beneficiaries ----
    function beneficiaries($uid)
    {
        return $this->rows("SELECT * FROM beneficiaries WHERE user_id = ? ORDER BY nickname", 'i', [$uid]);
    }

    function addBeneficiary($uid, $nickname, $accountno)
    {
        return $this->run("INSERT IGNORE INTO beneficiaries (user_id, nickname, accountno) VALUES (?, ?, ?)", 'isi', [$uid, $nickname, $accountno]);
    }

    function deleteBeneficiary($uid, $id)
    {
        return $this->run("DELETE FROM beneficiaries WHERE id = ? AND user_id = ?", 'ii', [$id, $uid]);
    }

    // ---- notifications ----
    function notify($uid, $message)
    {
        return $this->run("INSERT INTO notifications (user_id, message) VALUES (?, ?)", 'is', [$uid, $message]);
    }

    function notifications($uid, $limit = 50)
    {
        return $this->rows("SELECT * FROM notifications WHERE user_id = ? ORDER BY id DESC LIMIT ?", 'ii', [$uid, $limit]);
    }

    function unreadCount($uid)
    {
        $r = $this->rows("SELECT COUNT(*) AS c FROM notifications WHERE user_id = ? AND is_read = 0", 'i', [$uid]);
        return (int)$r[0]['c'];
    }

    function markAllRead($uid)
    {
        return $this->run("UPDATE notifications SET is_read = 1 WHERE user_id = ?", 'i', [$uid]);
    }

    function news($limit = 20)
    {
        return $this->rows("SELECT * FROM news ORDER BY news_id DESC LIMIT ?", 'i', [$limit]);
    }

    /**
     * Atomic transfer. Both customer rows are locked (always in account order, so two
     * opposite transfers can't deadlock) before balances are read.
     * Returns [bool ok, string message].
     */
    function transfer($fromAcct, $toAcct, $amount, $pin)
    {
        $c = $this->conn;
        $c->begin_transaction();

        $st = $c->prepare("SELECT user_id, fname, lname, accountno, pin FROM `user` WHERE accountno IN (?, ?) ORDER BY accountno FOR UPDATE");
        $st->bind_param('ii', $fromAcct, $toAcct);
        $st->execute();
        $found = $st->get_result()->fetch_all(MYSQLI_ASSOC);
        $st->close();

        $by = [];
        foreach ($found as $r) { $by[(int)$r['accountno']] = $r; }

        if (!isset($by[$fromAcct]) || !isset($by[$toAcct])) { $c->rollback(); return [false, 'Receiver account not found.']; }
        if (!verify_secret($pin, $by[$fromAcct]['pin'])) { $c->rollback(); return [false, 'Incorrect PIN.']; }

        $fromBal = $this->balance($fromAcct);
        if ($amount > $fromBal) { $c->rollback(); return [false, 'Insufficient balance.']; }
        $toBal = $this->balance($toAcct);

        $s = $by[$fromAcct]; $r = $by[$toAcct];
        $remarkOut = 'Sent to: ' . $r['fname'] . ' ' . $r['lname'] . ', AC/No: ' . $toAcct;
        $remarkIn  = 'Received from: ' . $s['fname'] . ' ' . $s['lname'] . ', AC/No: ' . $fromAcct;
        $newFrom = $fromBal - $amount;
        $newTo   = $toBal + $amount;

        $ok1 = $this->run("INSERT INTO passbook (trans_date, remarks, debit, credit, balance, accountno) VALUES (NOW(), ?, ?, 0, ?, ?)",
            'siii', [$remarkOut, $amount, $newFrom, $fromAcct]);
        $ok2 = $this->run("INSERT INTO passbook (trans_date, remarks, debit, credit, balance, accountno) VALUES (NOW(), ?, 0, ?, ?, ?)",
            'siii', [$remarkIn, $amount, $newTo, $toAcct]);
        if ($ok1 === false || $ok2 === false) { $c->rollback(); return [false, 'Transfer failed. Please try again.']; }

        $this->notify($r['user_id'], 'You received ' . $amount . ' from ' . $s['fname'] . ' ' . $s['lname'] . ' (AC/No: ' . $fromAcct . ')');
        $this->notify($s['user_id'], 'You sent ' . $amount . ' to ' . $r['fname'] . ' ' . $r['lname'] . ' (AC/No: ' . $toAcct . ')');

        $c->commit();
        return [true, 'Transferred ' . $amount . ' to ' . $r['fname'] . ' ' . $r['lname'] . '.'];
    }
}
