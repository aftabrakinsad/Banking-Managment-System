<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(isset($pageTitle) ? $pageTitle : 'Admin', ENT_QUOTES, 'UTF-8'); ?> · Banking Management System</title>
    <link rel="stylesheet" href="/assets/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php $cur = strtolower(basename($_SERVER['SCRIPT_NAME'])); ?>
<header class="topbar">
    <a class="brand" href="/Admin/View/adminhomepage.php"><img src="/Admin/Image/banklogo.png" alt="">Banking Management System</a>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger" aria-label="Menu">&#9776;</label>
    <nav>
        <a href="/Admin/View/Home.php">Home</a>
        <a href="../View/adminhomepage.php"<?php echo $cur === 'adminhomepage.php' ? ' class="active"' : ''; ?>>Dashboard</a>
        <a href="../View/adminrequest.php"<?php echo $cur === 'adminrequest.php' ? ' class="active"' : ''; ?>>Requests</a>
        <a href="../View/usermanage.php"<?php echo $cur === 'usermanage.php' ? ' class="active"' : ''; ?>>Customers</a>
        <a href="../View/manager.php"<?php echo $cur === 'manager.php' ? ' class="active"' : ''; ?>>Managers</a>
        <a href="../View/addemp.php"<?php echo $cur === 'addemp.php' ? ' class="active"' : ''; ?>>Employees</a>
        <details class="more"><summary>More &#9662;</summary><div class="menu">
            <a href="../View/adminmanage.php">Manage admins</a>
            <a href="../View/admin_salary_accno.php">Salary &amp; account no.</a>
            <a href="../View/atm.php">ATM deposit / withdraw</a>
            <a href="../View/transferfunds.php">Transfer funds</a>
            <a href="../View/mytransaction.php">Transactions</a>
            <a href="../View/postnews.php">Post news</a>
        </div></details>
        <a href="../Control/adminlogout.php" class="logout">Sign out</a>
    </nav>
</header>
<main class="page">
