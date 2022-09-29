<?php

session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
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
    <title>My Transactions</title>
    <link rel="stylesheet" href="../CSS/adminrequest.css">
</head>

<body>
    <form action="" method="POST">
        <table>
            <caption>Transaction History</ caption>
            <thead>
                <tr>
                    <th scope="col">Transaction Date</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Account No.</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/transation.process.php");
                ?>
            </tbody>
        </table>
    </form>
</body>

</html>