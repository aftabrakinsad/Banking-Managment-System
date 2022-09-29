

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/registration.css">
    <title> Registration Form</title>
</head>

<body>
<div class= "header sticky"> </div>

    <header>
    <!-- <h2 class="h2" id="h2">Welcome to City Bank Limited</h2> -->
    <?php
        @include("../view/header.php");

    ?>

        <p><strong>Use correct information to apply </strong>
        </p>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">

    <h2 class="h3" id="h3">Information</h2>

        <table>

            <tr>
                <td>
                    <input type="text" name="name" placeholder="Enter Your Name" id="name">
                    <!-- <p id="nameerror"></p> -->
                </td>
                <td>
                    <input type="text" name="nid" placeholder="NID" id="NID">
                    <!-- <p id="NIDerr"></p> -->
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="address" placeholder="Address" id="address">
                    <!-- <p id="usernameerr"> -->
                </td>

                <td>
                    <input type="text" name="email" placeholder="Email:myname@example.com"" id ="email">
                    <!-- <p id="emailvalue"></p> -->
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="phone" placeholder="+880-1XXXXXXXXX" id="phone">
                    <!-- <p id="phoneerrjs"></p> -->
                </td>

                <td>
                    <input type="text" name="anc" placeholder="Account NO" id="anc">
                    <!-- <p id="Cpassworderr"></p> -->
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="age" placeholder="Age" id="age">
               <!-- <p id="passworderr"></p> -->
                </td>

                <td>
                    <input type="text" name="balance" placeholder="Balance" id="balance">
                    <!-- <p id="Cpassworderr"></p> -->
                </td>

            </tr>
