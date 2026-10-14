<?php
require_once __DIR__ . '/../control/bootstrap.php';
$employee = require_employee();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(isset($pageTitle) ? $pageTitle : 'Employee', ENT_QUOTES, 'UTF-8'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body>
<div class="demo-banner" role="note"><strong>Demo project for learning.</strong> This is not a real bank. Do not enter real personal or financial information.</div>
<?php
$cur = strtolower(basename($_SERVER['SCRIPT_NAME']));
$flash = take_flash();
$openRequests = 0;
$rc = crepo()->requestCounts();
$openRequests = $rc['open'];
function emp_link($file, $label, $cur, $badge = 0) {
    $cls = $cur === strtolower($file) ? ' class="active"' : '';
    $b = $badge > 0 ? ' <span class="badge">' . (int)$badge . '</span>' : '';
    return '<a href="../view/' . $file . '"' . $cls . '>' . $label . $b . '</a>';
}
?>
<header class="topbar">
    <a class="brand" href="/Employee/view/epage1.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <?php
        echo emp_link('epage1.php', 'Home', $cur);
        echo emp_link('customers.php', 'Customers', $cur);
        echo emp_link('requests.php', 'Requests', $cur, $openRequests);
        echo emp_link('cashdesk.php', 'Cash desk', $cur);
        ?>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="../view/customer_form.php">Open an account</a>
            <a href="../view/viewinformation.php">My profile</a>
        </div></details>
        <a href="../control/employelogout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
<?php if ($flash) { ?><div class="alert alert-<?php echo htmlspecialchars($flash[0], ENT_QUOTES, 'UTF-8'); ?>" role="alert"><?php echo htmlspecialchars($flash[1], ENT_QUOTES, 'UTF-8'); ?></div><?php } ?>
