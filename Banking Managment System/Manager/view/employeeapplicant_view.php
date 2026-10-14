<?php
session_start();
if (empty($_SESSION["username"])) { header("Location: managerlogin.php"); exit; }
$pageTitle = 'Employee applicant';
@include("../view/header.php");
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';

$id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
$conn = bank_db_connect();
$st = $conn->prepare("SELECT fname, lname, Username, Email, NID, Phone, gender, picture, cv, status, review_note, reviewed_at, applied_at
                      FROM registrationofemployee WHERE id = ?");
$st->bind_param('i', $id);
$st->execute();
$a = $st->get_result()->fetch_assoc();
$st->close();
if (!$a) { echo '<div class="alert alert-error">Application not found.</div><a href="../view/employeeapplicants.php">&larr; Back</a>'; @include("../view/footer.php"); exit; }

function applicant_file($path) {
    $b = basename((string)$path);
    return ($b !== '' && is_file(__DIR__ . '/../../Employee/uploads/' . $b)) ? '/Employee/uploads/' . rawurlencode($b) : null;
}
$photo = applicant_file($a['picture']); $cv = applicant_file($a['cv']);
$rows = [['Username', $a['Username']], ['Email', $a['Email']], ['Phone', $a['Phone']], ['NID', $a['NID']], ['Gender', $a['gender']], ['Applied on', $a['applied_at']]];
?>
<p><a href="../view/employeeapplicants.php?tab=<?php echo h($a['status']); ?>">&larr; Back to applicants</a></p>
<h1><?php echo h($a['fname'] . ' ' . $a['lname']); ?> <span class="muted small">(<?php echo h($a['status']); ?>)</span></h1>
<section class="grid">
    <div class="card">
        <h2>Details</h2>
        <dl class="facts wide">
            <?php foreach ($rows as $r) { ?><dt><?php echo h($r[0]); ?></dt><dd><?php echo $r[1] !== '' && $r[1] !== null ? h($r[1]) : '<span class="muted">-</span>'; ?></dd><?php } ?>
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
                <p class="muted">Waiting for the administrator to review this application.</p>
            <?php } else { ?>
                <p><strong><?php echo h(ucfirst($a['status'])); ?></strong> on <?php echo h($a['reviewed_at']); ?></p>
                <p class="muted"><?php echo $a['review_note'] ? h($a['review_note']) : 'No note recorded.'; ?></p>
            <?php } ?>
        </div>
    </div>
</section>
<?php @include("../view/footer.php"); ?>
