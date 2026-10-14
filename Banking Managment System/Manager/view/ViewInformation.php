<?php
session_start();
if (empty($_SESSION["username"])) { header("Location: managerlogin.php"); exit; }
$pageTitle = 'My details';
@include("../view/header.php");
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';

$conn = bank_db_connect();
$st = $conn->prepare("SELECT firstname, lastname, username, gender, age, email, presentaddress, nid, phone, doj, salary, activeStatus, accountno, imgpath, cvpath
                      FROM manager WHERE username = ?");
$st->bind_param('s', $_SESSION['username']);
$st->execute();
$m = $st->get_result()->fetch_assoc();
$st->close();

function mgr_file($path) {
    $b = basename((string)$path);
    return ($b !== '' && is_file(__DIR__ . '/../uploads/' . $b)) ? '../uploads/' . rawurlencode($b) : null;
}
if (!$m) { echo '<div class="alert alert-error">Your manager record could not be found.</div>'; @include("../view/footer.php"); exit; }
$photo = mgr_file($m['imgpath']); $cv = mgr_file($m['cvpath']);
$status = strtolower((string)$m['activeStatus']);
$statusLabel = ($status === 'active' || $status === '1') ? 'Active' : (($status === 'inactive' || $status === '2') ? 'Inactive' : 'Pending');
$rows = [
    ['Username', $m['username']], ['Email', $m['email']], ['Phone', $m['phone']], ['NID', $m['nid']],
    ['Gender', $m['gender']], ['Age', $m['age']], ['Address', $m['presentaddress']],
    ['Date of joining', $m['doj']], ['Salary', $m['salary'] !== null ? '৳ ' . $m['salary'] : ''],
    ['Status', $statusLabel], ['Account no.', $m['accountno'] ? $m['accountno'] : 'Not assigned'],
];
?>
<h1>My details</h1>
<section class="card narrow">
    <div class="profile-head">
        <?php if ($photo) { ?><img class="avatar-lg" src="<?php echo h($photo); ?>" alt="Your photo"><?php } ?>
        <div>
            <h2 style="margin:0"><?php echo h(trim($m['firstname'] . ' ' . $m['lastname'])); ?></h2>
            <span class="muted">Manager</span>
        </div>
    </div>
    <dl class="facts wide">
        <?php foreach ($rows as $r) { ?>
            <dt><?php echo h($r[0]); ?></dt><dd><?php echo $r[1] !== '' && $r[1] !== null ? h($r[1]) : '<span class="muted">-</span>'; ?></dd>
        <?php } ?>
        <dt>CV</dt><dd><?php echo $cv ? '<a href="' . h($cv) . '" target="_blank" rel="noopener">Open</a>' : '<span class="muted">-</span>'; ?></dd>
    </dl>
    <a class="btn" href="../view/profile.php">Edit profile</a>
    <p class="muted small">To change your role, salary or status, contact the administrator.</p>
</section>
<?php @include("../view/footer.php"); ?>
