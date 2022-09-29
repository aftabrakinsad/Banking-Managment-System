<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/adminhome.css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="fonts/lineo-icon/style.css" rel="stylesheet" type="text/css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="flex-container">
        <div class="flex-item">
            <h1 id="customer">Welcome to the deshboard admin<?php include('../Control/cookie.php'); ?></h1>

            <p class="customer">Hello Everyone. Admin speaking. You know what I like pizza, not pasta.<br>
                Hello Sir! It's an honor to have you as faculty. Thanks for helping us, and supporting us.<br> Pray for us and give us 5 to 6 grade semester break bonous.😁</p>
        </div>
    </div>
</body>

</html>