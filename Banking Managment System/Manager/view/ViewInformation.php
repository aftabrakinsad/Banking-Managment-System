<?php

session_start();
// if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
//     header("location: ../View/adminlogin.php");
// }
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}

@include("../view/header.php");
@include("../view/navbar.php");
@include("../view/sidebar.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/adminrequest.css">
    <title>Manager Requests</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">

        <table>
       
            <thead>
                <tr>
                <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Nid  Number</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Image</th>
                    <th scope="col">CV</th>
                    <th scope="col">Date Of Joining</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Active Status</th>
                    <th scope="col">Account No</th>
                </tr>
            </thead>

            <tbody>
                <?php
                @include("../control/viewmanager.php");
                ?>
            </tbody>
        </table>

    </form>
</body>

</html>