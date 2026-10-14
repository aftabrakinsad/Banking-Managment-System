<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$r = crepo()->request($id);
if (!$r) { flash('error', 'Request not found.'); redirect('/Employee/view/requests.php'); }
$labels = CustomerRepo::REQUEST_TYPES;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $response = trim(isset($_POST['response']) ? $_POST['response'] : '');
    if (!in_array($status, ['open', 'in_progress', 'resolved', 'rejected'], true)) { $errors[] = 'Choose a status.'; }
    if (strlen($response) > 1000) { $errors[] = 'The reply is too long (1000 characters max).'; }
    if (in_array($status, ['resolved', 'rejected'], true) && $response === '') { $errors[] = 'Add a reply so the customer knows the outcome.'; }
    if (!$errors) {
        crepo()->updateRequest($id, $status, $response, $employee['username']);
        log_activity('employee', $employee['username'], 'request_' . $status, '#' . $id . ' ' . $r['subject']);
        flash('success', 'Request #' . $id . ' updated.');
        redirect('/Employee/view/requests.php');
    }
    $r['status'] = $status; $r['response'] = $response;
}
$pageTitle = 'Request #' . $id;
require __DIR__ . '/header.php';
?>
<p><a href="../view/requests.php">&larr; Back to requests</a></p>
<h1>Request #<?php echo (int)$r['id']; ?> <span class="muted small">(<?php echo h(isset($labels[$r['type']]) ? $labels[$r['type']] : $r['type']); ?>)</span></h1>
<section class="grid">
    <div class="card">
        <h2><?php echo h($r['subject']); ?></h2>
        <p style="white-space:pre-wrap"><?php echo h($r['message']); ?></p>
        <p class="muted small">Received <?php echo h($r['created_at']); ?></p>
        <h2>Customer</h2>
        <dl class="facts">
            <dt>Name</dt><dd><?php echo h($r['fname'] . ' ' . $r['lname']); ?></dd>
            <dt>Username</dt><dd><?php echo h($r['uname']); ?></dd>
            <dt>Account no.</dt><dd><?php echo h($r['accountno']); ?></dd>
            <dt>Email</dt><dd><?php echo h($r['email']); ?></dd>
            <dt>Phone</dt><dd><?php echo h($r['phone']); ?></dd>
        </dl>
        <?php
        $cust = crepo()->findByAccount((int)$r['accountno']);
        if ($cust) { ?><a class="btn btn-ghost" href="../view/customer_form.php?id=<?php echo (int)$cust['user_id']; ?>">Open customer record</a><?php } ?>
    </div>
    <div class="card">
        <h2>Your response</h2>
        <?php foreach ($errors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>
        <?php if ($r['handled_by']) { ?><p class="muted small">Last handled by <?php echo h($r['handled_by']); ?><?php echo $r['updated_at'] ? ' on ' . h($r['updated_at']) : ''; ?></p><?php } ?>
        <form method="post">
            <?php echo csrf_field(); ?>
            <label>Status
                <select name="status">
                    <?php foreach (['open' => 'Open', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'rejected' => 'Declined'] as $k => $l) { ?>
                        <option value="<?php echo $k; ?>"<?php echo $r['status'] === $k ? ' selected' : ''; ?>><?php echo $l; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label>Reply to the customer
                <textarea name="response" maxlength="1000" placeholder="Explain what was done, or why it was declined"><?php echo h($r['response']); ?></textarea>
            </label>
            <button class="btn" type="submit">Save and notify customer</button>
        </form>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
