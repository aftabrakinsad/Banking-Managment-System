<?php
session_start();
if (empty($_SESSION["username"])) { header("Location: managerlogin.php"); exit; }
$pageTitle = 'Dashboard';
@include("../view/header.php");
require_once __DIR__ . '/../../config/feed.php';
?>
<h1>Welcome back<?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : ''; ?></h1>
<?php render_admin_feed('manager', $_SESSION['username']); ?>
<section class="card">
    <h2>Manager board</h2>
    <div class="table-wrap"><table><tbody><?php @include("../control/viewnews.php"); ?></tbody></table></div>
</section>
<?php @include("../view/footer.php"); ?>
