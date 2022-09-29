<?php
@include("../control/userexits.emailconfirmation.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/forgetpassword.css">
    <title>Forgot Password</title>
</head>

<body class="body">
    <header>
        <?php

        @include("../view/header.php");

        ?>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit=" return email_adminregistration()">

        <h2 class="h2">Forgot Password</h2>

        <input type="email" name="Email" id="email" onchange="email_AJAX()" onkeyup="email_adminregistration()" placeholder="Enter email address">
        <p id="emailerr"></p>
        <p id="emailajaxresponse"></p>

        <table id="table">
            <tr>
                <td>
                    <input class="inputbutton" type="submit" name="Change" value="Change">
                    <a class="inputrequestreturn" name="return" href="../view/employelogin.php">Back to Login</a>
                </td>
            </tr>
        </table>
        <!-- <script src="../JS/adminregistration.js"></script> -->
    </form>
</body>

</html>