<?php
session_start();
if (empty($_SESSION["username"])) { header("Location: managerlogin.php"); exit; }
$pageTitle = 'My team';
@include("../view/header.php");
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';

$conn = bank_db_connect();
$st = $conn->prepare("SELECT e.FirsName, e.LastName, e.Username, e.Email, e.Phone, e.NID, e.gender, r.picture, r.cv
                      FROM employee e LEFT JOIN registrationofemployee r ON r.Username = e.Username
                      WHERE e.manager = ? ORDER BY e.FirsName, e.LastName");
$st->bind_param('s', $_SESSION['username']);
$st->execute();
$team = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();

function emp_file($path) {
    $b = basename((string)$path);
    return ($b !== '' && is_file(__DIR__ . '/../../Employee/uploads/' . $b)) ? '/Employee/uploads/' . rawurlencode($b) : null;
}
?>
<h1>My team</h1>
<p class="muted">Employees the administrator has assigned to you.</p>
<section class="card">
    <?php if (!$team) { ?>
        <div class="empty">
            <h2>No employees assigned yet</h2>
            <p class="muted">The administrator assigns employees to managers. They will appear here once assigned.</p>
        </div>
    <?php } else { ?>
    <div class="table-wrap"><table>
        <thead><tr><th></th><th>Name</th><th>Username</th><th>Email</th><th>Phone</th><th>NID</th><th>Gender</th><th>CV</th></tr></thead>
        <tbody>
        <?php foreach ($team as $e) { $photo = emp_file($e['picture']); $cv = emp_file($e['cv']); ?>
            <tr>
                <td><?php if ($photo) { ?><img src="<?php echo h($photo); ?>" alt="" width="48" height="48"><?php } ?></td>
                <td><strong><?php echo h(trim($e['FirsName'] . ' ' . $e['LastName'])); ?></strong></td>
                <td><?php echo h($e['Username']); ?></td>
                <td><?php echo h($e['Email']); ?></td>
                <td><?php echo h($e['Phone']); ?></td>
                <td><?php echo h($e['NID']); ?></td>
                <td><?php echo h($e['gender']); ?></td>
                <td><?php echo $cv ? '<a href="' . h($cv) . '" target="_blank" rel="noopener">Open</a>' : '<span class="muted">-</span>'; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table></div>
    <?php } ?>
</section>
<?php @include("../view/footer.php"); ?>
