<?php
// Handles the public "apply as an employee" form.
require_once __DIR__ . '/../../config/applications.php';

$appErrors = [];
$applied = false;
$v = ['fname' => '', 'lname' => '', 'uname' => '', 'email' => '', 'nid' => '', 'phone' => '', 'gender' => ''];

if (isset($_POST['submit']))
{
    csrf_verify();
    $map = ['fname' => 'fname', 'lname' => 'lname', 'uname' => 'uname', 'email' => 'email', 'nid' => 'nid', 'phone' => 'Phone', 'gender' => 'gender'];
    foreach ($map as $k => $field) { $v[$k] = trim(isset($_POST[$field]) ? (string)$_POST[$field] : ''); }
    $d = $v;
    $d['password'] = isset($_POST['password']) ? (string)$_POST['password'] : '';
    $d['cpassword'] = isset($_POST['cpassword']) ? (string)$_POST['cpassword'] : '';
    $files = ['cv' => isset($_FILES['cv']) ? $_FILES['cv'] : ['name' => '', 'error' => UPLOAD_ERR_NO_FILE],
              'photo' => isset($_FILES['picture']) ? $_FILES['picture'] : ['name' => '', 'error' => UPLOAD_ERR_NO_FILE]];
    $repo = new ApplicationRepo();
    $appErrors = app_validate('employee', $d, $files, $repo);

    if (!$appErrors)
    {
        $dir = __DIR__ . '/../uploads';
        $cv = app_store_file($files['cv'], $dir, 'pdf');
        $ph = app_store_file($files['photo'], $dir, 'image');
        if (!$cv[0]) { $appErrors[] = $cv[1]; }
        if (!$ph[0]) { $appErrors[] = $ph[1]; }
        if (!$appErrors)
        {
            $ok = $repo->addEmployee($d, password_hash($d['password'], PASSWORD_DEFAULT), $cv[1], $ph[1]);
            if ($ok === false) { $appErrors[] = 'Your application could not be saved. Please try again.'; }
            else {
                $applied = true;
                log_activity('system', $d['uname'], 'employee_application_submitted');
                $v = array_fill_keys(array_keys($v), '');
            }
        }
    }
}
