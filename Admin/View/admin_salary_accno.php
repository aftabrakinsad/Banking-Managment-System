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
    <link rel="stylesheet" type="text/CSS" href="../CSS/sal&acc.css">
    <title>Add Salary & Account No.</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <table>
            <caption>Selected Admins Details</caption>
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
                    <th scope="col"></th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/admin_salary_accno.process.php");
                ?>
            </tbody>
        </table>
    </form>
</body>

</html>