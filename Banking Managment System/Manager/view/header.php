<?php
require_once __DIR__ . '/../control/bootstrap.php';
$manager = require_manager();
$cur = strtolower(basename($_SERVER['SCRIPT_NAME']));
$flash = take_flash();
$name = ', ' . trim($manager['firstname'] . ' ' . $manager['lastname']);
$avatarFile = basename((string)$manager['imgpath']);
$picture = ($avatarFile !== '' && is_file(__DIR__ . '/../uploads/' . $avatarFile)) ? '/Manager/uploads/' . rawurlencode($avatarFile) : '';
function mgr_link($file, $label, $cur) {
    $cls = $cur === strtolower($file) ? ' class="active"' : '';
    return '<a href="../view/' . $file . '"' . $cls . '>' . $label . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h(isset($pageTitle) ? $pageTitle : 'Manager'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body>
<div class="demo-banner" role="note"><strong>Demo project for learning.</strong> This is not a real bank. Do not enter real personal or financial information.</div>
<header class="topbar">
    <a class="brand" href="/Manager/view/managerHomePage.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <?php
        echo mgr_link('managerHomePage.php', 'Home', $cur);
        echo mgr_link('transferfunds.php', 'Transfer', $cur);
        echo mgr_link('transaction.php', 'Transactions', $cur);
        echo mgr_link('Viewemployee.php', 'My team', $cur);
        ?>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="../view/employeeapplicants.php">Employee applicants</a>
            <a href="../view/ViewInformation.php">My details</a>
            <a href="../view/profile.php">Profile and security</a>
        </div></details>
        <?php if ($picture) { ?><img class="avatar" src="<?php echo h($picture); ?>" alt="" onerror="this.style.display='none'"><?php } ?>
        <a href="../control/logout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
<?php if ($flash) { ?><div class="alert alert-<?php echo h($flash[0]); ?>" role="alert"><?php echo h($flash[1]); ?></div><?php } ?>
