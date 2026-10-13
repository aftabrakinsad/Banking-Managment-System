<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $id = (int)(isset($_POST['id']) ? $_POST['id'] : 0);
    $decision = isset($_POST['decision']) ? $_POST['decision'] : '';
    $note = substr(trim(isset($_POST['note']) ? $_POST['note'] : ''), 0, 250);
    if (!in_array($type, ['manager', 'employee'], true) || !in_array($decision, ['approve', 'reject'], true) || $id < 1) {
        flash('error', 'Invalid request.');
    } else {
        $res = $type === 'manager' ? adb()->reviewManager($id, $decision === 'approve', $note) : adb()->reviewEmployee($id, $decision === 'approve', $note);
        flash($res[0] ? 'success' : 'error', $res[1]);
        if ($res[0]) { log_activity('admin', $admin['uname'], $decision . 'd_' . $type . '_application', $res[2] . ($note !== '' ? ' - ' . $note : '')); }
    }
    redirect('/Admin/View/applications.php?tab=' . urlencode(isset($_GET['tab']) ? $_GET['tab'] : 'pending'));
}

$tab = isset($_GET['tab']) && in_array($_GET['tab'], ['pending', 'approved', 'rejected'], true) ? $_GET['tab'] : 'pending';
$mgr = adb()->managerApplications($tab);
$emp = adb()->employeeApplications($tab);
$pageTitle = 'Applications';
require __DIR__ . '/header.php';

function file_link($module, $path, $label) {
    $b = basename((string)$path);
    return $b === '' ? '<span class="muted">-</span>' : '<a href="/' . $module . '/uploads/' . h(rawurlencode($b)) . '" target="_blank" rel="noopener">' . $label . '</a>';
}
function review_form($type, $id, $tab) {
    if ($tab !== 'pending') { return ''; }
    ob_start(); ?>
    <form method="post" action="?tab=pending">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="type" value="<?php echo h($type); ?>">
        <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
        <input type="text" name="note" placeholder="Note (optional)" maxlength="250">
        <button class="btn btn-small" type="submit" name="decision" value="approve">Approve</button>
        <button class="btn btn-small btn-danger" type="submit" name="decision" value="reject" onclick="return confirm('Reject this application?');">Reject</button>
    </form>
    <?php return ob_get_clean();
}
?>
<h1>Join applications</h1>
<p class="muted">Managers and employees who asked to join. Approving creates their working account.</p>
<div class="page-actions tabs">
    <?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $k => $l) { ?>
        <a class="btn <?php echo $tab === $k ? '' : 'btn-ghost'; ?>" href="?tab=<?php echo $k; ?>"><?php echo $l; ?></a>
    <?php } ?>
</div>

<section class="card">
    <h2>Manager applications (<?php echo count($mgr); ?>)</h2>
    <?php if (!$mgr) { ?><p class="muted">None.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Applicant</th><th>Username</th><th>Contact</th><th>Details</th><th>Files</th><th>Applied</th><th><?php echo $tab === 'pending' ? 'Decision' : 'Review'; ?></th></tr></thead>
        <tbody>
        <?php foreach ($mgr as $a) { ?>
            <tr>
                <td><strong><?php echo h($a['firstname'] . ' ' . $a['lastname']); ?></strong><br><span class="muted small"><?php echo h($a['gender']); ?>, <?php echo h($a['age']); ?></span></td>
                <td><?php echo h($a['username']); ?></td>
                <td><?php echo h($a['email']); ?><br><?php echo h($a['phone']); ?></td>
                <td>NID <?php echo h($a['nid']); ?><br><?php echo h($a['presentaddress']); ?><br>Expected salary ৳ <?php echo h($a['salary']); ?></td>
                <td><?php echo file_link('Manager', $a['cvpath'], 'CV'); ?> &middot; <?php echo file_link('Manager', $a['imgpath'], 'Photo'); ?></td>
                <td><?php echo h(substr($a['applied_at'], 0, 10)); ?></td>
                <td><?php echo $tab === 'pending' ? review_form('manager', $a['id'], $tab) : h($a['status']) . ' ' . h(substr((string)$a['reviewed_at'], 0, 10)) . '<br><span class="muted small">' . h($a['review_note']) . '</span>'; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>

<section class="card">
    <h2>Employee applications (<?php echo count($emp); ?>)</h2>
    <?php if (!$emp) { ?><p class="muted">None.</p><?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th>Applicant</th><th>Username</th><th>Contact</th><th>Details</th><th>Files</th><th>Applied</th><th><?php echo $tab === 'pending' ? 'Decision' : 'Review'; ?></th></tr></thead>
        <tbody>
        <?php foreach ($emp as $a) { ?>
            <tr>
                <td><strong><?php echo h($a['fname'] . ' ' . $a['lname']); ?></strong><br><span class="muted small"><?php echo h($a['gender']); ?></span></td>
                <td><?php echo h($a['username']); ?></td>
                <td><?php echo h($a['email']); ?><br><?php echo h($a['phone']); ?></td>
                <td>NID <?php echo h($a['nid']); ?></td>
                <td><?php echo file_link('Employee', $a['cv'], 'CV'); ?> &middot; <?php echo file_link('Employee', $a['picture'], 'Photo'); ?></td>
                <td><?php echo h(substr($a['applied_at'], 0, 10)); ?></td>
                <td><?php echo $tab === 'pending' ? review_form('employee', $a['id'], $tab) : h($a['status']) . ' ' . h(substr((string)$a['reviewed_at'], 0, 10)) . '<br><span class="muted small">' . h($a['review_note']) . '</span>'; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>
