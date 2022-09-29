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
    <title>Transaction</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">

        <table>
       
            <thead>
                
                <tr>
                <center>
                <th scope="col">Sender Account</th>
                    <th scope="col">Recever Account</th>
                    <th scope="col">Transfered Balance</th>
                    <th scope="col">Date of Transaction</th>
                    </center>
                </tr>
               
            </thead>

            <tbody>
                <?php
                @include("../control/viewtransaction.php");
                ?>
            </tbody>
        </table>

    </form>
</body>

</html>