<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="nav-wrapper">
        <div class="topnav" id="theTopNav">
            <a href="javascript:void(0);" class="icon" onclick="openNav()" id="hamburger">
                &#9776;
            </a>
            <a id="user">Welcome Manager<?php include('../control/cookie.php'); ?></a>
            <a id="profile" href="../view/profile.php">Profile</a>
            <a id="logout" href="../control/logout.php">Logout</a>
            <a id="profile" href="../view/postnews.php">Post Message</a>
            <a id="profile" href="../view/transaction.php">Transactions</a>
            <a id="profile" href="../view/managerrequest.php">Manager Requests</a>
            
        </div>
    </div>
    
    <script src="../js/navbar.js"></script>
</body>

</html>