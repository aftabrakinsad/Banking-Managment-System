<?php
// Expects $title and (optionally) $me from the including page.
$flash = take_flash();
$unread = isset($me) ? udb()->unreadCount((int)$me['user_id']) : 0;
$page = basename($_SERVER['SCRIPT_NAME']);
function navlink($file, $label, $page, $badge = 0) {
    $cls = $page === $file ? ' class="active"' : '';
    $b = $badge > 0 ? ' <span class="badge">' . (int)$badge . '</span>' : '';
    return '<a href="' . $file . '"' . $cls . '>' . $label . $b . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($title); ?> · PennyWise</title>
    <link rel="stylesheet" href="../CSS/user.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="dashboard.php"><img src="../../Admin/Image/banklogo.png" alt="" onerror="this.style.display='none'">PennyWise</a>
    <?php if (isset($me)) { ?>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <?php
        echo navlink('dashboard.php', 'Dashboard', $page);
        echo navlink('transfer.php', 'Transfer', $page);
        echo navlink('statement.php', 'Statement', $page);
        echo navlink('beneficiaries.php', 'Payees', $page);
        echo navlink('notifications.php', 'Alerts', $page, $unread);
        echo navlink('news.php', 'News', $page);
        echo navlink('profile.php', 'Profile', $page);
        echo navlink('security.php', 'Security', $page);
        ?>
        <a href="logout.php" class="logout">Sign out</a>
    </nav>
    <?php } ?>
</header>
<main class="container">
<?php if ($flash) { ?>
    <div class="alert alert-<?php echo h($flash[0]); ?>" role="alert"><?php echo h($flash[1]); ?></div>
<?php } ?>
