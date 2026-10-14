<?php
require_once __DIR__ . '/../Control/bootstrap.php';
$admin = require_admin();
$cur = strtolower(basename($_SERVER['SCRIPT_NAME']));
$pending = adb()->pendingCount();
function admin_link($file, $label, $cur, $badge = 0) {
    $cls = $cur === strtolower($file) ? ' class="active"' : '';
    $b = $badge > 0 ? ' <span class="badge">' . (int)$badge . '</span>' : '';
    return '<a href="/Admin/View/' . $file . '"' . $cls . '>' . $label . $b . '</a>';
}
$flash = take_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h(isset($pageTitle) ? $pageTitle : 'Admin'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body>
<div class="demo-banner" role="note"><strong>Demo project for learning.</strong> This is not a real bank. Do not enter real personal or financial information.</div>
<header class="topbar">
    <a class="brand" href="/Admin/View/adminhomepage.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <?php
        echo admin_link('adminhomepage.php', 'Home', $cur);
        echo admin_link('applications.php', 'Applications', $cur, $pending);
        echo admin_link('staff.php', 'Staff', $cur);
        echo admin_link('customers.php', 'Customers', $cur);
        echo admin_link('tasks.php', 'Tasks', $cur);
        ?>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="/Admin/View/postnews.php">Post news</a>
            <a href="/Admin/View/transactions.php">All transactions</a>
            <a href="/Admin/View/activity.php">Activity log</a>
        </div></details>
        <a href="/Admin/Control/adminlogout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
<?php if ($flash) { ?><div class="alert alert-<?php echo h($flash[0]); ?>" role="alert"><?php echo h($flash[1]); ?></div><?php } ?>
