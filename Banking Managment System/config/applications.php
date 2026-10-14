<?php
// Shared validation + storage for the two public "apply to join" forms (manager and employee).
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/dbbase.php';
require_once __DIR__ . '/activity.php';

class ApplicationRepo extends BaseDb
{
    // True if the username, email or NID is already used by an account or an undecided/approved application.
    function conflict($username, $email, $nid)
    {
        $q = "SELECT 1 FROM manager WHERE username = ? OR email = ? OR nid = ? LIMIT 1";
        if ($this->one($q, 'ssi', [$username, $email, $nid])) { return true; }
        if ($this->one("SELECT 1 FROM employeelogin WHERE username = ? OR email = ? LIMIT 1", 'ss', [$username, $email])) { return true; }
        if ($this->one("SELECT 1 FROM applicationofmanager WHERE status <> 'rejected' AND (username = ? OR email = ? OR nid = ?) LIMIT 1", 'ssi', [$username, $email, $nid])) { return true; }
        if ($this->one("SELECT 1 FROM registrationofemployee WHERE status <> 'rejected' AND (Username = ? OR Email = ? OR NID = ?) LIMIT 1", 'ssi', [$username, $email, $nid])) { return true; }
        return false;
    }

    // Is a username / email / NID / phone already taken by an account or a live application?
    function taken($field, $value)
    {
        switch ($field) {
            case 'username':
                return (bool)($this->one("SELECT 1 FROM manager WHERE username = ?", 's', [$value]) || $this->one("SELECT 1 FROM employeelogin WHERE username = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM applicationofmanager WHERE status <> 'rejected' AND username = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM registrationofemployee WHERE status <> 'rejected' AND Username = ?", 's', [$value]));
            case 'email':
                return (bool)($this->one("SELECT 1 FROM manager WHERE email = ?", 's', [$value]) || $this->one("SELECT 1 FROM employeelogin WHERE email = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM applicationofmanager WHERE status <> 'rejected' AND email = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM registrationofemployee WHERE status <> 'rejected' AND Email = ?", 's', [$value]));
            case 'nid':
                $n = (int)$value;
                return (bool)($this->one("SELECT 1 FROM manager WHERE nid = ?", 'i', [$n]) || $this->one("SELECT 1 FROM employee WHERE NID = ?", 'i', [$n])
                    || $this->one("SELECT 1 FROM applicationofmanager WHERE status <> 'rejected' AND nid = ?", 'i', [$n])
                    || $this->one("SELECT 1 FROM registrationofemployee WHERE status <> 'rejected' AND NID = ?", 'i', [$n]));
            case 'phone':
                return (bool)($this->one("SELECT 1 FROM manager WHERE phone = ?", 's', [$value]) || $this->one("SELECT 1 FROM employee WHERE Phone = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM applicationofmanager WHERE status <> 'rejected' AND phone = ?", 's', [$value])
                    || $this->one("SELECT 1 FROM registrationofemployee WHERE status <> 'rejected' AND Phone = ?", 's', [$value]));
        }
        return false;
    }

    function addManager($d, $passHash, $cv, $photo)
    {
        return $this->run("INSERT INTO applicationofmanager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,fund)
                           VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0)", 'sssissssssissssi',
            [$d['fname'], $d['lname'], $d['gender'], $d['age'], $d['fathername'], $d['mothername'], $d['uname'], $passHash, $d['email'], $d['address'],
             $d['nid'], $d['phone'], $cv, $photo, $d['doj'], $d['salary']]);
    }

    function addEmployee($d, $passHash, $cv, $photo)
    {
        return $this->run("INSERT INTO registrationofemployee (fname,lname,Username,Email,NID,Phone,Password,cpassword,gender,picture,cv) VALUES (?,?,?,?,?,?,?,'',?,?,?)",
            'ssssisssss', [$d['fname'], $d['lname'], $d['uname'], $d['email'], $d['nid'], $d['phone'], $passHash, $d['gender'], $photo, $cv]);
    }
}

function app_name_ok($s) { return (bool)preg_match("/^[\\p{L}][\\p{L} .'-]{0,59}$/u", $s); }

// $role: 'manager' | 'employee'. $d = cleaned text fields. Returns a list of error strings.
function app_validate($role, array $d, array $files, ApplicationRepo $repo)
{
    $e = [];
    if (!app_name_ok($d['fname'])) { $e[] = 'Enter a valid first name.'; }
    if (!app_name_ok($d['lname'])) { $e[] = 'Enter a valid last name.'; }
    if (!in_array($d['gender'], ['male', 'female', 'others'], true)) { $e[] = 'Choose a gender.'; }
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $d['uname'])) { $e[] = 'Username: 3-30 letters, numbers or underscores.'; }
    if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL) || strlen($d['email']) > 100) { $e[] = 'Enter a valid email address.'; }
    if (!preg_match('/^\+?[0-9\-]{7,17}$/', $d['phone'])) { $e[] = 'Enter a valid phone number (digits, optional + or -).'; }
    if (!ctype_digit($d['nid']) || strlen($d['nid']) < 8 || strlen($d['nid']) > 15) { $e[] = 'NID must be 8-15 digits.'; }
    if (!valid_password($d['password'])) { $e[] = 'Password needs 8+ characters with upper, lower, a number and a symbol.'; }
    elseif ($d['password'] !== $d['cpassword']) { $e[] = 'The two passwords do not match.'; }

    if ($role === 'manager') {
        $dob = DateTime::createFromFormat('Y-m-d', $d['dob']);
        if (!$dob || $dob->format('Y-m-d') !== $d['dob']) { $e[] = 'Enter your date of birth.'; }
        elseif ($dob->diff(new DateTime('today'))->y < 18) { $e[] = 'You must be at least 18 years old.'; }
        if (!app_name_ok($d['fathername']) || !app_name_ok($d['mothername'])) { $e[] = "Enter your father's and mother's names."; }
        if (strlen(trim($d['address'])) < 3) { $e[] = 'Enter your street address.'; }
        $doj = DateTime::createFromFormat('Y-m-d', $d['doj']);
        if (!$doj || $doj->format('Y-m-d') !== $d['doj']) { $e[] = 'Enter an expected joining date.'; }
        if (!ctype_digit($d['salary']) || (int)$d['salary'] < 1 || (int)$d['salary'] > 10000000) { $e[] = 'Expected salary must be a whole number.'; }
    }

    foreach (['cv' => 'CV (PDF)', 'photo' => 'photo'] as $k => $label) {
        if (empty($files[$k]['name']) || $files[$k]['error'] === UPLOAD_ERR_NO_FILE) { $e[] = 'Please upload your ' . $label . '.'; }
        elseif ($files[$k]['error'] !== UPLOAD_ERR_OK) { $e[] = 'The ' . $label . ' could not be uploaded. Try a smaller file.'; }
    }
    if (!$e && $repo->conflict($d['uname'], $d['email'], (int)$d['nid'])) { $e[] = 'That username, email or NID is already registered or has a pending application.'; }
    return $e;
}

// Stores an upload under $dir with a random name. $kind 'pdf' or 'image'. Returns [true, filename] or [false, error].
function app_store_file($file, $dir, $kind)
{
    if ($kind === 'pdf') {
        if ($file['size'] > 5 * 1048576) { return [false, 'The CV must be 5 MB or smaller.']; }
        $head = @file_get_contents($file['tmp_name'], false, null, 0, 5);
        if ($head !== '%PDF-') { return [false, 'The CV must be a PDF file.']; }
        $ext = 'pdf';
    } else {
        if ($file['size'] > 2 * 1048576) { return [false, 'The photo must be 2 MB or smaller.']; }
        $info = @getimagesize($file['tmp_name']);
        $map = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif'];
        if (!$info || !isset($map[$info[2]])) { return [false, 'The photo must be a JPG, PNG or GIF image.']; }
        $ext = $map[$info[2]];
    }
    if (!is_dir($dir)) { mkdir($dir, 0775, true); }
    $name = bin2hex(random_bytes(10)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], rtrim($dir, '/') . '/' . $name)) { return [false, 'Could not save an uploaded file.']; }
    return [true, $name];
}
