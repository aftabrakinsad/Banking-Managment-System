<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();

$type = isset($_GET['type']) && $_GET['type'] === 'employee' ? 'employee' : 'manager';
$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$a = $type === 'manager' ? adb()->managerApplication($id) : adb()->employeeApplication($id);
if (!$a) { flash('error', 'Application not found.'); redirect('/Admin/View/applications.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $decision = isset($_POST['decision']) ? $_POST['decision'] : '';
    $note = substr(trim(isset($_POST['note']) ? $_POST['note'] : ''), 0, 250);
    if (!in_array($decision, ['approve', 'reject'], true)) { flash('error', 'Invalid request.'); redirect($_SERVER['REQUEST_URI']); }
    $res = $type === 'manager' ? adb()->reviewManager($id, $decision === 'approve', $note) : adb()->reviewEmployee($id, $decision === 'approve', $note);
    flash($res[0] ? 'success' : 'error', $res[1]);
    if ($res[0]) {
        log_activity('admin', $admin['uname'], $decision . 'd_' . $type . '_application', $res[2] . ($note !== '' ? ' - ' . $note : ''));
        redirect('/Admin/View/applications.php?tab=' . ($decision === 'approve' ? 'approved' : 'rejected'));
    }
    redirect($_SERVER['REQUEST_URI']);
}

// Show an uploaded file only if it really exists on disk.
function upload_info($module, $path) {
    $b = basename((string)$path);
    if ($b === '' || !is_file(__DIR__ . '/../../' . $module . '/uploads/' . $b)) { return null; }
    return '/' . $module . '/uploads/' . rawurlencode($b);
}
$module = $type === 'manager' ? 'Manager' : 'Employee';
$name = $type === 'manager' ? $a['firstname'] . ' ' . $a['lastname'] : $a['fname'] . ' ' . $a['lname'];
$cv = upload_info($module, $type === 'manager' ? $a['cvpath'] : $a['cv']);
$photo = upload_info($module, $type === 'manager' ? $a['imgpath'] : $a['picture']);

$fields = [['Username', $a['username']], ['Email', $a['email']], ['Phone', $a['phone']], ['NID', $a['nid']], ['Gender', $a['gender']]];
if ($type === 'manager') {
    $fields = array_merge($fields, [['Age', $a['age']], ["Father's name", $a['fathersname']], ["Mother's name", $a['mothersname']],
        ['Present address', $a['presentaddress']], ['Expected joining date', $a['doj']], ['Expected salary', '৳ ' . $a['salary']]]);
}
$fields[] = ['Applied on', $a['applied_at']];

$pageTitle = 'Application · ' . $name;
require __DIR__ . '/header.php';
?>
<p><a href="/Admin/View/applications.php?tab=<?php echo h($a['status']); ?>">&larr; Back to applications</a></p>
<h1><?php echo h($name); ?> <span class="muted small">(<?php echo h($type); ?> application · <?php echo h($a['status']); ?>)</span></h1>

<section class="grid">
    <div class="card">
        <h2>Applicant details</h2>
        <dl class="facts">
            <?php foreach ($fields as $f) { ?>
                <dt><?php echo h($f[0]); ?></dt><dd><?php echo $f[1] !== '' && $f[1] !== null ? h($f[1]) : '<span class="muted">-</span>'; ?></dd>
            <?php } ?>
        </dl>
    </div>
    <div>
        <div class="card">
            <h2>Documents</h2>
            <?php if ($photo) { ?><img class="avatar-lg" src="<?php echo h($photo); ?>" alt="Applicant photo"><?php } ?>
            <ul class="list">
                <li><span>Photo</span><span><?php echo $photo ? '<a href="' . h($photo) . '" target="_blank" rel="noopener">Open</a>' : '<span class="muted">Not provided</span>'; ?></span></li>
                <li><span>CV</span><span><?php echo $cv ? '<a href="' . h($cv) . '" target="_blank" rel="noopener">Open</a>' : '<span class="muted">Not provided</span>'; ?></span></li>
            </ul>
        </div>
        <div class="card">
            <h2>Decision</h2>
            <?php if ($a['status'] === 'pending') { ?>
                <form method="post">
                    <?php echo csrf_field(); ?>
                    <label>Note (optional, kept on record)
                        <textarea name="note" maxlength="250" placeholder="Reason or instructions"></textarea>
                    </label>
                    <button class="btn" type="submit" name="decision" value="approve">Approve and create account</button>
                    <button class="btn btn-danger" type="submit" name="decision" value="reject" onclick="return confirm('Reject this application?');">Reject</button>
                </form>
            <?php } else { ?>
                <p><strong><?php echo h(ucfirst($a['status'])); ?></strong> on <?php echo h($a['reviewed_at']); ?></p>
                <p class="muted"><?php echo $a['review_note'] !== '' && $a['review_note'] !== null ? h($a['review_note']) : 'No note recorded.'; ?></p>
            <?php } ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
