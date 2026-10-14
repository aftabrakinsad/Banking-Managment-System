<?php
require_once __DIR__ . '/dbbase.php';

class ManagerRepo extends BaseDb
{
    // Legacy rows may hold '2' for inactive; anything else (active, 1, NULL) can sign in.
    static function isInactive($status) { return in_array(strtolower((string)$status), ['inactive', '2'], true); }

    function find($username) { return $this->one("SELECT * FROM manager WHERE username = ?", 's', [$username]); }
    function findByAccount($acct) { return $this->one("SELECT username, firstname, lastname, accountno FROM manager WHERE accountno = ?", 'i', [$acct]); }

    function setPasswordHash($username, $hash) { return $this->run("UPDATE manager SET pass = ? WHERE username = ?", 'ss', [$hash, $username]); }

    function emailTaken($email, $exceptUsername)
    {
        return (bool)($this->one("SELECT 1 FROM manager WHERE email = ? AND username <> ?", 'ss', [$email, $exceptUsername])
            || $this->one("SELECT 1 FROM employeelogin WHERE email = ?", 's', [$email]));
    }

    function updateContact($username, $email, $phone, $address)
    {
        return $this->run("UPDATE manager SET email = ?, phone = ?, presentaddress = ? WHERE username = ?", 'ssss', [$email, $phone, $address, $username]);
    }

    // Managers get a 7-digit funds account number the first time they sign in.
    function ensureAccount($username)
    {
        $m = $this->find($username);
        if (!$m || $m['accountno']) { return $m ? (int)$m['accountno'] : 0; }
        do { $n = random_int(2000000, 2999999); } while ($this->one("SELECT 1 FROM manager WHERE accountno = ?", 'i', [$n]));
        $this->run("UPDATE manager SET accountno = ? WHERE username = ? AND accountno IS NULL", 'is', [$n, $username]);
        return $n;
    }

    // Atomic manager-to-manager transfer of internal funds. Returns [ok, message, receiverRow?]
    function transfer($fromUser, $toAccount, $amount)
    {
        $c = $this->conn; $c->begin_transaction();
        $rows = $this->rows("SELECT id, username, firstname, lastname, accountno, fund FROM manager WHERE username = ? OR accountno = ? ORDER BY id FOR UPDATE", 'si', [$fromUser, $toAccount]);
        $from = null; $to = null;
        foreach ($rows as $r) {
            if ($r['username'] === $fromUser) { $from = $r; }
            if ((int)$r['accountno'] === $toAccount && $r['username'] !== $fromUser) { $to = $r; }
        }
        if (!$from) { $c->rollback(); return [false, 'Your manager record was not found.']; }
        if (!$from['accountno']) { $c->rollback(); return [false, 'Your funds account is not set up yet. Sign out and in again.']; }
        if ((int)$from['accountno'] === $toAccount) { $c->rollback(); return [false, 'You cannot transfer to your own account.']; }
        if (!$to) { $c->rollback(); return [false, 'No manager has that account number.']; }
        if ($amount > (float)$from['fund']) { $c->rollback(); return [false, 'Insufficient funds. Available: ' . number_format((float)$from['fund'], 2) . '.']; }

        $a = $this->run("UPDATE manager SET fund = fund - ? WHERE id = ?", 'ii', [$amount, $from['id']]);
        $b = $this->run("UPDATE manager SET fund = fund + ? WHERE id = ?", 'ii', [$amount, $to['id']]);
        $t = $this->run("INSERT INTO `transaction` (senderaccount, receveraccount, balancetransfered, `Date`) VALUES (?, ?, ?, NOW())", 'iii', [$from['accountno'], $to['accountno'], $amount]);
        if ($a === false || $b === false || $t === false) { $c->rollback(); return [false, 'Transfer failed. Please try again.']; }
        $c->commit();
        return [true, 'Transferred ' . $amount . ' to ' . $to['firstname'] . ' ' . $to['lastname'] . '.', $to];
    }

    function transfersFor($account, $limit = 100)
    {
        return $this->rows("SELECT t.*, s.firstname AS sfirst, s.lastname AS slast, r.firstname AS rfirst, r.lastname AS rlast
                            FROM `transaction` t
                            LEFT JOIN manager s ON s.accountno = t.senderaccount LEFT JOIN manager r ON r.accountno = t.receveraccount
                            WHERE t.senderaccount = ? OR t.receveraccount = ? ORDER BY t.id DESC LIMIT ?", 'iii', [$account, $account, $limit]);
    }

    function allTransfers($limit = 200, $q = '')
    {
        $sql = "SELECT t.*, s.firstname AS sfirst, s.lastname AS slast, s.username AS suser, r.firstname AS rfirst, r.lastname AS rlast, r.username AS ruser
                FROM `transaction` t LEFT JOIN manager s ON s.accountno = t.senderaccount LEFT JOIN manager r ON r.accountno = t.receveraccount";
        $types = ''; $params = [];
        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $sql .= " WHERE CAST(t.senderaccount AS CHAR) LIKE ? OR CAST(t.receveraccount AS CHAR) LIKE ? OR s.username LIKE ? OR r.username LIKE ?";
            $types = 'ssss'; $params = [$like, $like, $like, $like];
        }
        $sql .= " ORDER BY t.id DESC LIMIT ?";
        return $this->rows($sql, $types . 'i', array_merge($params, [$limit]));
    }
}
