<?php
require_once __DIR__ . '/dbbase.php';

class CustomerRepo extends BaseDb
{
    const REQUEST_TYPES = [
        'profile_update' => 'Update my details',
        'statement' => 'Statement request',
        'loan' => 'Loan enquiry',
        'pin_help' => 'PIN or password help',
        'other' => 'Something else',
    ];

    // ---------- customers ----------
    function search($q = '')
    {
        if ($q === '') { return $this->rows("SELECT user_id, fname, lname, uname, email, phone, accountno, picture FROM `user` ORDER BY user_id"); }
        $like = '%' . addcslashes($q, '%_\\') . '%';
        return $this->rows("SELECT user_id, fname, lname, uname, email, phone, accountno, picture FROM `user`
                            WHERE CONCAT(fname, ' ', lname) LIKE ? OR uname LIKE ? OR CAST(accountno AS CHAR) LIKE ? ORDER BY user_id", 'sss', [$like, $like, $like]);
    }

    function find($id) { return $this->one("SELECT * FROM `user` WHERE user_id = ?", 'i', [$id]); }
    function findByAccount($acct) { return $this->one("SELECT user_id, fname, lname, accountno FROM `user` WHERE accountno = ?", 'i', [$acct]); }

    function taken($uname, $email, $nid, $exceptId)
    {
        return (bool)$this->one("SELECT 1 FROM `user` WHERE (uname = ? OR email = ? OR nid = ?) AND user_id <> ?", 'ssii', [$uname, $email, $nid, $exceptId]);
    }

    function emailTaken($email, $exceptId)
    {
        return (bool)$this->one("SELECT 1 FROM `user` WHERE email = ? AND user_id <> ?", 'si', [$email, $exceptId]);
    }

    function newAccountNumber()
    {
        do { $n = random_int(1000000, 9999999); } while ($this->one("SELECT 1 FROM `user` WHERE accountno = ?", 'i', [$n]));
        return $n;
    }

    function add($fname, $lname, $uname, $email, $nid, $phone, $accountno, $pinHash, $passHash, $picture, $opening)
    {
        $c = $this->conn; $c->begin_transaction();
        $ok = $this->run("INSERT INTO `user` (fname,lname,uname,email,nid,phone,accountno,pin,password,cpassword,picture) VALUES (?,?,?,?,?,?,?,?,?,'',?)",
            'ssssisisss', [$fname, $lname, $uname, $email, $nid, $phone, $accountno, $pinHash, $passHash, $picture]);
        if ($ok === false) { $c->rollback(); return false; }
        if ($opening > 0) {
            $this->run("INSERT INTO passbook (trans_date, remarks, debit, credit, balance, accountno) VALUES (NOW(), 'Opening deposit', 0, ?, ?, ?)", 'iii', [$opening, $opening, $accountno]);
        }
        $c->commit();
        return true;
    }

    function update($id, $fname, $lname, $email, $phone)
    {
        return $this->run("UPDATE `user` SET fname = ?, lname = ?, email = ?, phone = ? WHERE user_id = ?", 'ssssi', [$fname, $lname, $email, $phone, $id]);
    }

    function setPicture($id, $path) { return $this->run("UPDATE `user` SET picture = ? WHERE user_id = ?", 'si', [$path, $id]); }

    function balance($accountno)
    {
        $r = $this->one("SELECT balance FROM passbook WHERE accountno = ? ORDER BY trans_id DESC LIMIT 1", 'i', [$accountno]);
        return $r ? (int)$r['balance'] : 0;
    }

    function notify($userId, $message) { return $this->run("INSERT INTO notifications (user_id, message) VALUES (?, ?)", 'is', [$userId, $message]); }

    // Teller cash deposit / withdrawal. Returns [ok, message, customerRow?, newBalance?]
    function cash($accountno, $type, $amount, $teller)
    {
        $c = $this->conn; $c->begin_transaction();
        $u = $this->one("SELECT user_id, fname, lname, accountno FROM `user` WHERE accountno = ? FOR UPDATE", 'i', [$accountno]);
        if (!$u) { $c->rollback(); return [false, 'No customer has that account number.']; }
        $bal = $this->balance($accountno);
        if ($type === 'withdraw' && $amount > $bal) { $c->rollback(); return [false, 'Insufficient balance. Available: ' . $bal . '.']; }
        $new = $type === 'deposit' ? $bal + $amount : $bal - $amount;
        $remarks = ($type === 'deposit' ? 'Cash deposit' : 'Cash withdrawal') . ' (teller: ' . $teller . ')';
        $debit = $type === 'withdraw' ? $amount : 0;
        $credit = $type === 'deposit' ? $amount : 0;
        $ok = $this->run("INSERT INTO passbook (trans_date, remarks, debit, credit, balance, accountno) VALUES (NOW(), ?, ?, ?, ?, ?)",
            'siiii', [$remarks, $debit, $credit, $new, $accountno]);
        if ($ok === false) { $c->rollback(); return [false, 'Could not record the transaction.']; }
        $this->notify($u['user_id'], ($type === 'deposit' ? 'Cash deposit of ' : 'Cash withdrawal of ') . $amount . ' recorded. New balance: ' . $new . '.');
        $c->commit();
        return [true, ($type === 'deposit' ? 'Deposited ' : 'Withdrew ') . $amount . ' ' . ($type === 'deposit' ? 'to ' : 'from ') . $u['fname'] . ' ' . $u['lname'] . '. New balance: ' . $new . '.', $u, $new];
    }

    // ---------- customer requests ----------
    function requests($status = '')
    {
        $sql = "SELECT r.*, u.fname, u.lname, u.accountno, u.uname FROM customer_requests r JOIN `user` u ON u.user_id = r.user_id";
        if ($status !== '') { return $this->rows($sql . " WHERE r.status = ? ORDER BY r.id DESC", 's', [$status]); }
        return $this->rows($sql . " ORDER BY FIELD(r.status, 'open', 'in_progress', 'resolved', 'rejected'), r.id DESC");
    }

    function request($id)
    {
        return $this->one("SELECT r.*, u.fname, u.lname, u.accountno, u.uname, u.email, u.phone FROM customer_requests r JOIN `user` u ON u.user_id = r.user_id WHERE r.id = ?", 'i', [$id]);
    }

    function requestCounts()
    {
        $out = ['open' => 0, 'in_progress' => 0, 'resolved' => 0, 'rejected' => 0];
        foreach ($this->rows("SELECT status, COUNT(*) AS c FROM customer_requests GROUP BY status") as $r) { $out[$r['status']] = (int)$r['c']; }
        return $out;
    }

    function updateRequest($id, $status, $response, $handler)
    {
        $r = $this->request($id);
        if (!$r) { return null; }
        $this->run("UPDATE customer_requests SET status = ?, response = ?, handled_by = ?, updated_at = NOW() WHERE id = ?", 'sssi', [$status, $response, $handler, $id]);
        if ($status !== $r['status'] || $response !== (string)$r['response']) {
            $label = ['open' => 'reopened', 'in_progress' => 'being handled', 'resolved' => 'resolved', 'rejected' => 'declined'][$status];
            $this->notify($r['user_id'], 'Your request "' . $r['subject'] . '" is ' . $label . '.' . ($response !== '' ? ' Reply: ' . mb_substr($response, 0, 120) : ''));
        }
        return $r;
    }
}
