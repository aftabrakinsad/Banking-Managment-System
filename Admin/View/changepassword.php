<?php

include("../Control/changepassword.process.php");
$email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/forgetpassword.css">
    <title>Change Your Password</title>
</head>

<body class="body">
    <header>
        <?php

        @include("../View/header.php");

        ?>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return change_password_formcheck()">

        <p class="h2">Here you go to change your password</p>

        <table>
            <tr>
                <td>

                    <?php

                    if (count($errors) > 0) {
                    ?>
                        <?php
                        foreach ($errors as $showerror) {
                            echo "<p id='denger'>$showerror</p>";
                        }
                        ?>
                    <?php
                    }

                    ?>

                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="newpassword" id="pass" onkeyup="password_change()" placeholder="Enter new password">
                    <p id="passerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="password" name="confirmpassword" id="cpass" onkeyup="confirm_password_change()" placeholder="Confirm your password">
                    <p id="cpasserr"></p>
                    <p id="matched" onkeyup="password_check()"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="otpbtn" type="submit" name="passwordsubmission" value="Change">
                </td>
            </tr>
        </table>

    </form>
    <script src="../JS/changepassword.js"></script>
</body>

</html>