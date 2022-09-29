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
    <title>Selected Admins</title>
    <link rel="stylesheet" href="../CSS/adminrequest.css">
</head>

<body>
    <form action="" method="POST">
        <table>
            <caption>Information Of Selceted Admin</ caption>
            <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">NID</th>
                    <th scope="col">Phone</th>
                    <th scope="col">salary</th>
                    <th scope="col">accountno</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/IIadminmanage.process.php");
                ?>
            </tbody>
        </table>
    </form>
    <br><br>
    <a id="info2" href="../View/adminmanage.php">Go Back</a>
</body>

</html>