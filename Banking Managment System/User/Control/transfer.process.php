<?php
require_once __DIR__ . '/bootstrap.php';
$errors = [];
$bens = udb()->beneficiaries((int)$me['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $to = trim(isset($_POST['to_account']) ? $_POST['to_account'] : '');
    $amountRaw = trim(isset($_POST['amount']) ? $_POST['amount'] : '');
    $pin = isset($_POST['pin']) ? $_POST['pin'] : '';

    if (!ctype_digit($to) || strlen($to) > 9) { $errors[] = 'Enter a valid receiver account number.'; }
    if (!ctype_digit($amountRaw) || (int)$amountRaw < 1 || (int)$amountRaw > 1000000) { $errors[] = 'Amount must be a whole number between 1 and 1,000,000.'; }
    if ($pin === '') { $errors[] = 'Enter your PIN.'; }
    if (!$errors && (int)$to === (int)$me['accountno']) { $errors[] = 'You cannot send money to your own account.'; }

    if (!$errors) {
        list($ok, $msg) = udb()->transfer((int)$me['accountno'], (int)$to, (int)$amountRaw, $pin);
        if ($ok) { flash('success', $msg); redirect('dashboard.php'); }
        $errors[] = $msg;
    }
}
