<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(isset($pageTitle) ? $pageTitle : 'Employee', ENT_QUOTES, 'UTF-8'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php $cur = strtolower(basename($_SERVER['SCRIPT_NAME'])); ?>
<header class="topbar">
    <a class="brand" href="/Employee/view/epage1.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <a href="/Admin/View/Home.php">Home</a>
        <a href="../view/epage1.php"<?php echo $cur === 'epage1.php' ? ' class="active"' : ''; ?>>Dashboard</a>
        <a href="../view/showuserinfo.php"<?php echo $cur === 'showuserinfo.php' ? ' class="active"' : ''; ?>>Customers</a>
        <a href="../view/transferfund.php"<?php echo $cur === 'transferfund.php' ? ' class="active"' : ''; ?>>Transfer</a>
        <a href="../view/qurey.php"<?php echo $cur === 'qurey.php' ? ' class="active"' : ''; ?>>Queries</a>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="../view/add_user.php">Add customer</a>
            <a href="../view/employeedetails.php">Employee applications</a>
            <a href="../view/viewinformation.php">My profile</a>
        </div></details>
        <a href="../control/employelogout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
