<?php
require_once __DIR__ . '/../../config/database.php';

// Master-admin data access. All queries are prepared statements.
// Note: nothing here updates or deletes the staticadmin row - the master admin is fixed.
class AdminDb
{
    public $conn;

    function __construct() { $this->conn = bank_db_connect(); }

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
        $n = $ok ? $st->affected_rows : false;
        $st->close();
        return $n;
    }

    private function one($sql, $types = '', $params = [])
    {
        $r = $this->rows($sql, $types, $params);
        return $r ? $r[0] : null;
    }

    // ---------- auth ----------
    function findAdmin($uname) { return $this->one("SELECT * FROM staticadmin WHERE uname = ?", 's', [$uname]); }
    function findAdminById($id) { return $this->one("SELECT admin_id, uname, email FROM staticadmin WHERE admin_id = ?", 'i', [$id]); }

    // ---------- summary ----------
    function summary()
    {
        $c = function ($sql) { $r = $this->one($sql); return $r ? (int)array_values($r)[0] : 0; };
        $bal = $this->one("SELECT COALESCE(SUM(p.balance),0) AS t FROM passbook p
                           JOIN (SELECT accountno, MAX(trans_id) AS m FROM passbook GROUP BY accountno) x ON p.trans_id = x.m");
        return [
            'customers' => $c("SELECT COUNT(*) FROM `user`"),
            'managers' => $c("SELECT COUNT(*) FROM manager"),
            'employees' => $c("SELECT COUNT(*) FROM employeelogin"),
            'pending_managers' => $c("SELECT COUNT(*) FROM applicationofmanager WHERE status = 'pending'"),
            'pending_employees' => $c("SELECT COUNT(*) FROM registrationofemployee WHERE status = 'pending'"),
            'tx_today' => $c("SELECT COUNT(*) FROM passbook WHERE DATE(trans_date) = CURDATE() AND debit > 0"),
            'tx_total' => $c("SELECT COUNT(*) FROM passbook WHERE debit > 0"),
            'open_tasks' => $c("SELECT COUNT(*) FROM tasks WHERE status = 'open'"),
            'holdings' => $bal ? (int)$bal['t'] : 0,
        ];
    }

    function recentActivity($limit = 15, $role = '')
    {
        if ($role !== '') {
            return $this->rows("SELECT * FROM activity_log WHERE actor_role = ? ORDER BY id DESC LIMIT ?", 'si', [$role, $limit]);
        }
        return $this->rows("SELECT * FROM activity_log ORDER BY id DESC LIMIT ?", 'i', [$limit]);
    }

    function activityRoles() { return $this->rows("SELECT DISTINCT actor_role FROM activity_log ORDER BY actor_role"); }

    function transactions($limit = 200)
    {
        return $this->rows("SELECT p.*, u.fname, u.lname FROM passbook p LEFT JOIN `user` u ON u.accountno = p.accountno
                            ORDER BY p.trans_id DESC LIMIT ?", 'i', [$limit]);
    }

    // ---------- applications ----------
    function managerApplications($status)
    {
        return $this->rows("SELECT id, firstname, lastname, gender, age, username, email, presentaddress, nid, phone, doj, salary, cvpath, imgpath, status, review_note, reviewed_at, applied_at
                            FROM applicationofmanager WHERE status = ? ORDER BY id DESC", 's', [$status]);
    }

    function employeeApplications($status)
    {
        return $this->rows("SELECT id, fname, lname, Username AS username, Email AS email, NID AS nid, Phone AS phone, gender, picture, cv, status, review_note, reviewed_at, applied_at
                            FROM registrationofemployee WHERE status = ? ORDER BY id DESC", 's', [$status]);
    }

    // Returns [ok, message]
    function reviewManager($id, $approve, $note)
    {
        $c = $this->conn; $c->begin_transaction();
        $a = $this->one("SELECT * FROM applicationofmanager WHERE id = ? AND status = 'pending' FOR UPDATE", 'i', [$id]);
        if (!$a) { $c->rollback(); return [false, 'That application is not pending any more.']; }
        if ($approve) {
            if ($this->one("SELECT 1 FROM manager WHERE username = ? OR email = ?", 'ss', [$a['username'], $a['email']])) {
                $c->rollback(); return [false, 'A manager with that username or email already exists.'];
            }
            $ok = $this->run("INSERT INTO manager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,activeStatus,fund)
                              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'active',0)", 'sssissssssissssi',
                [$a['firstname'], $a['lastname'], $a['gender'], $a['age'], $a['fathersname'], $a['mothersname'], $a['username'], $a['pass'],
                 $a['email'], $a['presentaddress'], $a['nid'], $a['phone'], $a['cvpath'], $a['imgpath'], $a['doj'], $a['salary']]);
            if ($ok === false) { $c->rollback(); return [false, 'Could not create the manager account.']; }
        }
        $this->run("UPDATE applicationofmanager SET status = ?, review_note = ?, reviewed_at = NOW() WHERE id = ?", 'ssi', [$approve ? 'approved' : 'rejected', $note, $id]);
        $c->commit();
        return [true, $a['firstname'] . ' ' . $a['lastname'] . ($approve ? ' is now a manager.' : "'s application was rejected."), $a['username']];
    }

    function reviewEmployee($id, $approve, $note)
    {
        $c = $this->conn; $c->begin_transaction();
        $a = $this->one("SELECT * FROM registrationofemployee WHERE id = ? AND status = 'pending' FOR UPDATE", 'i', [$id]);
        if (!$a) { $c->rollback(); return [false, 'That application is not pending any more.']; }
        if ($approve) {
            if ($this->one("SELECT 1 FROM employeelogin WHERE username = ? OR email = ?", 'ss', [$a['Username'], $a['Email']])) {
                $c->rollback(); return [false, 'An employee with that username or email already exists.'];
            }
            $ok = $this->run("INSERT INTO employeelogin (username, password, email) VALUES (?, ?, ?)", 'sss', [$a['Username'], $a['Password'], $a['Email']]);
            $ok2 = $this->run("INSERT INTO employee (FirsName,LastName,Username,Password,ConfirmPassword,Email,NID,Phone,gender) VALUES (?,?,?,?,?,?,?,?,?)",
                'ssssssiss', [$a['fname'], $a['lname'], $a['Username'], $a['Password'], $a['Password'], $a['Email'], $a['NID'], $a['Phone'], $a['gender']]);
            if ($ok === false || $ok2 === false) { $c->rollback(); return [false, 'Could not create the employee account.']; }
        }
        $this->run("UPDATE registrationofemployee SET status = ?, review_note = ?, reviewed_at = NOW() WHERE id = ?", 'ssi', [$approve ? 'approved' : 'rejected', $note, $id]);
        $c->commit();
        return [true, $a['fname'] . ' ' . $a['lname'] . ($approve ? ' is now an employee.' : "'s application was rejected."), $a['Username']];
    }

    // ---------- staff ----------
    function managers()
    {
        return $this->rows("SELECT id, firstname, lastname, username, email, phone, salary, activeStatus FROM manager ORDER BY id");
    }

    function employees()
    {
        return $this->rows("SELECT el.id, el.username, el.email, e.FirsName AS fname, e.LastName AS lname, e.Phone AS phone, e.manager
                            FROM employeelogin el LEFT JOIN employee e ON e.Username = el.username ORDER BY el.id");
    }

    function manager($id) { return $this->one("SELECT * FROM manager WHERE id = ?", 'i', [$id]); }

    function employee($id)
    {
        return $this->one("SELECT el.id, el.username, el.email, e.FirsName AS fname, e.LastName AS lname, e.Phone AS phone, e.NID AS nid, e.gender, e.manager
                           FROM employeelogin el LEFT JOIN employee e ON e.Username = el.username WHERE el.id = ?", 'i', [$id]);
    }

    function managerUsernames()
    {
        return array_column($this->rows("SELECT username FROM manager ORDER BY username"), 'username');
    }

    function emailInUse($email, $exceptRole, $exceptId)
    {
        $m = $this->one("SELECT 1 FROM manager WHERE email = ? AND NOT (? = 'manager' AND id = ?)", 'ssi', [$email, $exceptRole, $exceptId]);
        $e = $this->one("SELECT 1 FROM employeelogin WHERE email = ? AND NOT (? = 'employee' AND id = ?)", 'ssi', [$email, $exceptRole, $exceptId]);
        return (bool)($m || $e);
    }

    function updateManager($id, $first, $last, $email, $phone, $salary, $status)
    {
        return $this->run("UPDATE manager SET firstname = ?, lastname = ?, email = ?, phone = ?, salary = ?, activeStatus = ? WHERE id = ?",
            'ssssisi', [$first, $last, $email, $phone, $salary, $status, $id]);
    }

    function updateEmployee($id, $first, $last, $email, $phone, $managerUsername)
    {
        $el = $this->one("SELECT username FROM employeelogin WHERE id = ?", 'i', [$id]);
        if (!$el) { return false; }
        $this->run("UPDATE employeelogin SET email = ? WHERE id = ?", 'si', [$email, $id]);
        $mgr = $managerUsername === '' ? null : $managerUsername;
        return $this->run("UPDATE employee SET FirsName = ?, LastName = ?, Email = ?, Phone = ?, manager = ? WHERE Username = ?",
            'ssssss', [$first, $last, $email, $phone, $mgr, $el['username']]);
    }

    function removeManager($id)
    {
        $m = $this->manager($id);
        if (!$m) { return null; }
        $this->run("DELETE FROM manager WHERE id = ?", 'i', [$id]);
        $this->run("DELETE FROM tasks WHERE assignee_role = 'manager' AND assignee_username = ?", 's', [$m['username']]);
        $this->run("UPDATE employee SET manager = NULL WHERE manager = ?", 's', [$m['username']]);
        return $m['username'];
    }

    function removeEmployee($id)
    {
        $e = $this->one("SELECT username FROM employeelogin WHERE id = ?", 'i', [$id]);
        if (!$e) { return null; }
        $this->run("DELETE FROM employeelogin WHERE id = ?", 'i', [$id]);
        $this->run("DELETE FROM employee WHERE Username = ?", 's', [$e['username']]);
        $this->run("DELETE FROM tasks WHERE assignee_role = 'employee' AND assignee_username = ?", 's', [$e['username']]);
        return $e['username'];
    }

    // Move someone between Manager and Employee. $to is 'manager' or 'employee'.
    function changeRole($id, $to)
    {
        $c = $this->conn; $c->begin_transaction();
        if ($to === 'employee') {
            $m = $this->one("SELECT * FROM manager WHERE id = ? FOR UPDATE", 'i', [$id]);
            if (!$m) { $c->rollback(); return [false, 'Manager not found.']; }
            if ($this->one("SELECT 1 FROM employeelogin WHERE username = ?", 's', [$m['username']])) { $c->rollback(); return [false, 'An employee with that username already exists.']; }
            $a = $this->run("INSERT INTO employeelogin (username, password, email) VALUES (?, ?, ?)", 'sss', [$m['username'], $m['pass'], $m['email']]);
            $b = $this->run("INSERT INTO employee (FirsName,LastName,Username,Password,ConfirmPassword,Email,NID,Phone,gender) VALUES (?,?,?,?,?,?,?,?,?)",
                'ssssssiss', [$m['firstname'], $m['lastname'], $m['username'], $m['pass'], $m['pass'], $m['email'], $m['nid'], $m['phone'], $m['gender']]);
            if ($a === false || $b === false) { $c->rollback(); return [false, 'Role change failed.']; }
            $this->run("DELETE FROM manager WHERE id = ?", 'i', [$id]);
            $this->run("UPDATE employee SET manager = NULL WHERE manager = ?", 's', [$m['username']]);
            $this->run("UPDATE tasks SET assignee_role = 'employee' WHERE assignee_role = 'manager' AND assignee_username = ?", 's', [$m['username']]);
            $c->commit();
            return [true, $m['firstname'] . ' ' . $m['lastname'] . ' is now an employee.', $m['username']];
        }
        $e = $this->one("SELECT el.username, el.password, el.email, e.FirsName, e.LastName, e.NID, e.Phone, e.gender
                         FROM employeelogin el LEFT JOIN employee e ON e.Username = el.username WHERE el.id = ? FOR UPDATE", 'i', [$id]);
        if (!$e) { $c->rollback(); return [false, 'Employee not found.']; }
        if ($this->one("SELECT 1 FROM manager WHERE username = ?", 's', [$e['username']])) { $c->rollback(); return [false, 'A manager with that username already exists.']; }
        $ok = $this->run("INSERT INTO manager (firstname,lastname,gender,username,pass,email,nid,phone,activeStatus,fund,salary) VALUES (?,?,?,?,?,?,?,?,'active',0,0)",
            'ssssssis', [$e['FirsName'], $e['LastName'], $e['gender'], $e['username'], $e['password'], $e['email'], $e['NID'], $e['Phone']]);
        if ($ok === false) { $c->rollback(); return [false, 'Role change failed.']; }
        $this->run("DELETE FROM employeelogin WHERE id = ?", 'i', [$id]);
        $this->run("DELETE FROM employee WHERE Username = ?", 's', [$e['username']]);
        $this->run("UPDATE tasks SET assignee_role = 'manager' WHERE assignee_role = 'employee' AND assignee_username = ?", 's', [$e['username']]);
        $c->commit();
        return [true, $e['FirsName'] . ' ' . $e['LastName'] . ' is now a manager.', $e['username']];
    }

    // ---------- tasks ----------
    function tasks($status = '')
    {
        if ($status !== '') { return $this->rows("SELECT * FROM tasks WHERE status = ? ORDER BY due_date IS NULL, due_date, id DESC", 's', [$status]); }
        return $this->rows("SELECT * FROM tasks ORDER BY status = 'done', due_date IS NULL, due_date, id DESC");
    }

    function addTask($title, $details, $role, $username, $due)
    {
        $d = $due === '' ? null : $due;
        return $this->run("INSERT INTO tasks (title, details, assignee_role, assignee_username, due_date) VALUES (?, ?, ?, ?, ?)",
            'sssss', [$title, $details, $role, $username, $d]);
    }

    function setTaskStatus($id, $status)
    {
        return $this->run("UPDATE tasks SET status = ?, completed_at = IF(? = 'done', NOW(), NULL) WHERE id = ?", 'ssi', [$status, $status, $id]);
    }

    function deleteTask($id) { return $this->run("DELETE FROM tasks WHERE id = ?", 'i', [$id]); }

    // ---------- news ----------
    function allNews() { return $this->rows("SELECT * FROM news ORDER BY news_id DESC"); }

    function postNews($title, $body, $audience)
    {
        return $this->run("INSERT INTO news (tittle, news_body, created, audience) VALUES (?, ?, NOW(), ?)", 'sss', [$title, $body, $audience]);
    }

    function deleteNews($id) { return $this->run("DELETE FROM news WHERE news_id = ?", 'i', [$id]); }

    function pendingCount()
    {
        $a = $this->one("SELECT (SELECT COUNT(*) FROM applicationofmanager WHERE status = 'pending') + (SELECT COUNT(*) FROM registrationofemployee WHERE status = 'pending') AS c");
        return $a ? (int)$a['c'] : 0;
    }

    // ---------- add staff directly ----------
    function usernameTaken($u)
    {
        return (bool)($this->one("SELECT 1 FROM manager WHERE username = ?", 's', [$u]) || $this->one("SELECT 1 FROM employeelogin WHERE username = ?", 's', [$u]));
    }

    function addManager($first, $last, $username, $email, $phone, $password, $salary)
    {
        return $this->run("INSERT INTO manager (firstname,lastname,username,pass,email,phone,salary,activeStatus,fund,doj) VALUES (?,?,?,?,?,?,?,'active',0,CURDATE())",
            'ssssssi', [$first, $last, $username, $password, $email, $phone, $salary]);
    }

    function addEmployee($first, $last, $username, $email, $phone, $password)
    {
        $a = $this->run("INSERT INTO employeelogin (username, password, email) VALUES (?, ?, ?)", 'sss', [$username, $password, $email]);
        if ($a === false) { return false; }
        return $this->run("INSERT INTO employee (FirsName,LastName,Username,Password,ConfirmPassword,Email,Phone) VALUES (?,?,?,?,?,?,?)",
            'sssssss', [$first, $last, $username, $password, $password, $email, $phone]);
    }

    // ---------- customers ----------
    function customers() { return $this->rows("SELECT user_id, fname, lname, uname, email, phone, accountno, picture FROM `user` ORDER BY user_id"); }
    function customer($id) { return $this->one("SELECT * FROM `user` WHERE user_id = ?", 'i', [$id]); }

    function customerTaken($uname, $email, $nid, $exceptId)
    {
        return (bool)$this->one("SELECT 1 FROM `user` WHERE (uname = ? OR email = ? OR nid = ?) AND user_id <> ?", 'ssii', [$uname, $email, $nid, $exceptId]);
    }

    function customerEmailTaken($email, $exceptId)
    {
        return (bool)$this->one("SELECT 1 FROM `user` WHERE email = ? AND user_id <> ?", 'si', [$email, $exceptId]);
    }

    function newAccountNumber()
    {
        do { $n = random_int(1000000, 9999999); } while ($this->one("SELECT 1 FROM `user` WHERE accountno = ?", 'i', [$n]));
        return $n;
    }

    function addCustomer($fname, $lname, $uname, $email, $nid, $phone, $accountno, $pinHash, $passHash, $picture, $opening)
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

    function updateCustomer($id, $fname, $lname, $email, $phone)
    {
        return $this->run("UPDATE `user` SET fname = ?, lname = ?, email = ?, phone = ? WHERE user_id = ?", 'ssssi', [$fname, $lname, $email, $phone, $id]);
    }

    function setCustomerPassword($id, $hash) { return $this->run("UPDATE `user` SET password = ?, cpassword = '' WHERE user_id = ?", 'si', [$hash, $id]); }
    function setCustomerPin($id, $hash) { return $this->run("UPDATE `user` SET pin = ? WHERE user_id = ?", 'si', [$hash, $id]); }
    function setCustomerPicture($id, $path) { return $this->run("UPDATE `user` SET picture = ? WHERE user_id = ?", 'si', [$path, $id]); }

    function removeCustomer($id)
    {
        $u = $this->customer($id);
        if (!$u) { return null; }
        $this->run("DELETE FROM `user` WHERE user_id = ?", 'i', [$id]);
        return $u['uname'];
    }

    function customerBalance($accountno)
    {
        $r = $this->one("SELECT balance FROM passbook WHERE accountno = ? ORDER BY trans_id DESC LIMIT 1", 'i', [$accountno]);
        return $r ? (int)$r['balance'] : 0;
    }
}
