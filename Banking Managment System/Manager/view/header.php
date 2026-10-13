<?php
include("../control/managerprocess.php");
include("../control/homepageProcess.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(isset($pageTitle) ? $pageTitle : 'Manager', ENT_QUOTES, 'UTF-8'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php $cur = strtolower(basename($_SERVER['SCRIPT_NAME'])); ?>
<header class="topbar">
    <a class="brand" href="/Manager/view/managerHomePage.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <a href="/Admin/View/Home.php">Home</a>
        <a href="../view/managerHomePage.php"<?php echo $cur === 'managerhomepage.php' ? ' class="active"' : ''; ?>>Dashboard</a>
        <a href="../view/transferfunds.php"<?php echo $cur === 'transferfunds.php' ? ' class="active"' : ''; ?>>Transfer</a>
        <a href="../view/transaction.php"<?php echo $cur === 'transaction.php' ? ' class="active"' : ''; ?>>Transactions</a>
        <a href="../view/Viewemployee.php"<?php echo $cur === 'viewemployee.php' ? ' class="active"' : ''; ?>>Employees</a>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="../view/postnews.php">Post news</a>
            <a href="../view/ViewInformation.php">Manager info</a>
            <a href="../view/managerUpdate.php">Manage manager</a>
            <a href="../view/profile.php">My profile</a>
        </div></details>
        <?php if (!empty($picture)) { ?><img class="avatar" src="<?php echo htmlspecialchars($picture, ENT_QUOTES, 'UTF-8'); ?>" alt="" onerror="this.style.display='none'"><?php } ?>
        <a href="../control/logout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
