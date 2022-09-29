<?php

@include("../View/header.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/news.css">
    <title>News From Admin</title>
</head>

<body>
    <form action="">
        <p id="customer">
            <?php
            @include("../Control/viewnews.process.php");
            ?>
        </p>
        <a id="btn" href="http://localhost/Bankin%20Managment%20System/Admin/View/Home.php">Back To Home</a>
    </form>
</body>

</html>