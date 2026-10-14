<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$me = require_login();
$uid = (int)$me['user_id'];
$types = [
    'profile_update' => 'Update my details',
    'statement' => 'Statement request',
    'loan' => 'Loan enquiry',
    'pin_help' => 'PIN or password help',
    'other' => 'Something else',
];
$errors = [];
$v = ['type' => 'other', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $v['type'] = isset($_POST['type']) ? $_POST['type'] : '';
    $v['subject'] = trim(isset($_POST['subject']) ? $_POST['subject'] : '');
    $v['message'] = trim(isset($_POST['message']) ? $_POST['message'] : '');
    if (!isset($types[$v['type']])) { $errors[] = 'Choose what your request is about.'; }
    if ($v['subject'] === '' || strlen($v['subject']) > 120) { $errors[] = 'Enter a short subject (up to 120 characters).'; }
    if ($v['message'] === '' || strlen($v['message']) > 2000) { $errors[] = 'Describe your request (up to 2000 characters).'; }
    if (udb()->openRequestCount($uid) >= 10) { $errors[] = 'You already have 10 open requests. Please wait for some to be handled.'; }
    if (!$errors) {
        udb()->createRequest($uid, $v['type'], $v['subject'], $v['message']);
        log_activity('customer', $me['uname'], 'submitted_request', $v['subject']);
        flash('success', 'Request sent. A bank employee will respond soon.');
        redirect('requests.php');
    }
}
$mine = udb()->myRequests($uid);
$title = 'Requests';
require __DIR__ . '/layout_top.php';
$badge = ['open' => 'Received', 'in_progress' => 'Being handled', 'resolved' => 'Resolved', 'rejected' => 'Declined'];
?>
<h1>Requests to the bank</h1>
<section class="grid">
    <div class="card">
        <h2>New request</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>What is it about?
                <select name="type">
                    <?php foreach ($types as $k => $l) { ?><option value="<?php echo $k; ?>"<?php echo $v['type'] === $k ? ' selected' : ''; ?>><?php echo h($l); ?></option><?php } ?>
                </select>
            </label>
            <label>Subject <input type="text" name="subject" maxlength="120" value="<?php echo h($v['subject']); ?>" required></label>
            <label>Details <textarea name="message" maxlength="2000" required><?php echo h($v['message']); ?></textarea></label>
            <button class="btn" type="submit">Send request</button>
        </form>
    </div>
    <div class="card">
        <h2>Your requests (<?php echo count($mine); ?>)</h2>
        <?php if (!$mine) { ?><p class="muted">You have not sent any requests.</p><?php } ?>
        <ul class="list">
        <?php foreach ($mine as $r) { ?>
            <li style="align-items:flex-start">
                <span>
                    <strong><?php echo h($r['subject']); ?></strong>
                    <span class="muted small"> · <?php echo h($types[$r['type']]); ?> · <?php echo h(substr($r['created_at'], 0, 10)); ?></span><br>
                    <span class="small"><?php echo h($r['message']); ?></span>
                    <?php if ($r['response'] !== null && $r['response'] !== '') { ?>
                        <br><span class="small"><strong>Reply from <?php echo h($r['handled_by']); ?>:</strong> <?php echo h($r['response']); ?></span>
                    <?php } ?>
                </span>
                <span class="badge" style="background:var(--brand);white-space:nowrap"><?php echo h($badge[$r['status']]); ?></span>
            </li>
        <?php } ?>
        </ul>
    </div>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
