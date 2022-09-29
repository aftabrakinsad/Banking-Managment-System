<?php

session_start();


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
    
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">

        <table>
       
            <thead>
                <tr>
                <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nid  Number</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Password</th>
                    <th scope="col">Gender</th>
                     <th scope="col">Image</th>
                    <th scope="col">CV</th>
                    <th scope="col">Salary</th>                    
                    <th scope="col">Manager</th>
                    <th scope="col">Account Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                @include("../control/viewemployeeprocess.php");
                ?>
            </tbody>
        </table>

    </form>
</body>

</html>