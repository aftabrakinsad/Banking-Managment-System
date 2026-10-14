<?php
// Handles the public "apply as a manager" form.
require_once __DIR__ . '/../../config/applications.php';

$appErrors = [];
$applied = false;
$cities = ['DHAKA', 'CHATTOGRAM', 'KHULNA', 'SYLHET', 'RAJSHAHI', 'NARAYANGANJ'];
$postals = ['1211', '7899', '2899', '8002', '1900', '3399'];
$v = ['fname' => '', 'lname' => '', 'gender' => '', 'dob' => '', 'fathername' => '', 'mothername' => '', 'uname' => '', 'email' => '',
      'nid' => '', 'phone' => '', 'street' => '', 'city' => 'DHAKA', 'postal' => '1211', 'doj' => '', 'salary' => ''];

if (isset($_POST['Submit']))
{
    csrf_verify();
    $map = ['fname' => 'fname', 'lname' => 'lname', 'gender' => 'gender', 'dob' => 'dateofbirth', 'fathername' => 'fathername', 'mothername' => 'mothername',
            'uname' => 'uname', 'email' => 'email', 'nid' => 'nid', 'phone' => 'phone', 'street' => 'street', 'city' => 'city', 'postal' => 'postal',
            'doj' => 'doj', 'salary' => 'salary'];
    foreach ($map as $k => $field) { $v[$k] = trim(isset($_POST[$field]) ? (string)$_POST[$field] : ''); }
    $d = $v;
    $d['password'] = isset($_POST['pass']) ? (string)$_POST['pass'] : '';
    $d['cpassword'] = isset($_POST['cpass']) ? (string)$_POST['cpass'] : '';
    if (!in_array($v['city'], $cities, true) || !in_array($v['postal'], $postals, true)) { $appErrors[] = 'Choose a city and postal code from the list.'; }
    $d['address'] = $v['street'] . ' , ' . $v['city'] . ' , ' . $v['postal'];
    $files = ['cv' => isset($_FILES['cv']) ? $_FILES['cv'] : ['name' => '', 'error' => UPLOAD_ERR_NO_FILE],
              'photo' => isset($_FILES['img']) ? $_FILES['img'] : ['name' => '', 'error' => UPLOAD_ERR_NO_FILE]];
    $repo = new ApplicationRepo();
    $appErrors = array_merge($appErrors, app_validate('manager', $d, $files, $repo));

    if (!$appErrors)
    {
        $dir = __DIR__ . '/../uploads';
        $cv = app_store_file($files['cv'], $dir, 'pdf');
        $ph = app_store_file($files['photo'], $dir, 'image');
        if (!$cv[0]) { $appErrors[] = $cv[1]; }
        if (!$ph[0]) { $appErrors[] = $ph[1]; }
        if (!$appErrors)
        {
            $d['age'] = (new DateTime($d['dob']))->diff(new DateTime('today'))->y;
            $ok = $repo->addManager($d, password_hash($d['password'], PASSWORD_DEFAULT), $cv[1], $ph[1]);
            if ($ok === false) { $appErrors[] = 'Your application could not be saved. Please try again.'; }
            else {
                $applied = true;
                log_activity('system', $d['uname'], 'manager_application_submitted');
                $v = array_fill_keys(array_keys($v), ''); $v['city'] = 'DHAKA'; $v['postal'] = '1211';
            }
        }
    }
}
