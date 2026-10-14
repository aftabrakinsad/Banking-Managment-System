<?php
session_start();
if (empty($_SESSION["username"])) { header("Location: managerlogin.php"); exit; }
$pageTitle = 'Employee applicants';
@include("../view/header.php");
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';

$tab = isset($_GET['tab']) && in_array($_GET['tab'], ['pending', 'approved', 'rejected'], true) ? $_GET['tab'] : 'pending';
$conn = bank_db_connect();
$st = $conn->prepare("SELECT id, fname, lname, Username, Email, Phone, applied_at, reviewed_at, review_note
                      FROM registrationofemployee WHERE status = ? ORDER BY id DESC");
$st->bind_param('s', $tab);
$st->execute();
$rows = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();
?>
<h1>Employee applicants</h1>
<p class="muted">People who applied to join as employees. This is a read-only view: <strong>the administrator makes the final decision</strong>.</p>
<div class="page-actions tabs">
    <?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $k => $l) { ?>
        <a class="btn <?php echo $tab === $k ? '' : 'btn-ghost'; ?>" href="?tab=<?php echo $k; ?>"><?php echo $l; ?></a>
    <?php } ?>
</div>
<section class="card">
    <?php if (!$rows) { ?><p class="muted">No <?php echo h($tab); ?> applications.</p><?php } else { ?>
    <div class="table-wrap"><table class="apps">
        <thead><tr><th>Applicant</th><th>Username</th><th>Email</th><th>Phone</th><th>Applied</th><?php echo $tab === 'pending' ? '' : '<th>Decided</th>'; ?><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $a) { ?>
            <tr>
                <td><strong><?php echo h($a['fname'] . ' ' . $a['lname']); ?></strong></td>
                <td><?php echo h($a['Username']); ?></td>
                <td><?php echo h($a['Email']); ?></td>
                <td><?php echo h($a['Phone']); ?></td>
                <td><?php echo h(substr($a['applied_at'], 0, 10)); ?></td>
                <?php if ($tab !== 'pending') { ?><td><?php echo h(substr((string)$a['reviewed_at'], 0, 10)); ?></td><?php } ?>
                <td><a class="btn btn-small btn-ghost" href="../view/employeeapplicant_view.php?id=<?php echo (int)$a['id']; ?>">View</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
