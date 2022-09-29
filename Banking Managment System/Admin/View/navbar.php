<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/navbar.css">
    <script src="jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="nav-wrapper">
        <div class="topnav" id="theTopNav">
            <a href="javascript:void(0);" class="icon" onclick="openNav()" id="hamburger">
                &#9776;
            </a>
            <a id="user">Welcome Admin<?php include('../Control/cookie.php'); ?></a>
            <a id="logout" href="../Control/adminlogout.php">Logout</a>
        </div>
    </div>

    <script src="../JS/navbar.js"></script>
</body>

</html>