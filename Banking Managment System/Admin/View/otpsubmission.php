<?php

@include("../Control/otp.process.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/forgetpassword.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>OTP via Email</title>
</head>

<body class="body">
    <header>
        <?php

        @include("../View/header.php");

        ?>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <h2 class="h2">Enter the correct OPT</h2>

        <table>

            <tr>
                <td>
                    <?php
                    if (count($errors) > 0) {
                    ?>
                        <div>
                            <?php
                            foreach ($errors as $showerror) {
                                echo "<p id='denger'>$showerror</p>";
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="otp" id="otp" onkeyup="otp_forpasswordchange()" placeholder="Enter otp">
                    <p id="otperr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <?php
                    echo "<p class='otpshowing' id='otpp' onkeyup='fade()'>$showotp</p>";
                    ?>
                    <input class="otpbtn" type="submit" name="enterotp" value="Submit"> <br> <br>
                    <input class="otpbtn" type="submit" name="otpshowing" id="otpshowing" value="Show OTP">
                </td>
            </tr>
        </table>

    </form>
    <script src="../JS/otp.js"></script>
</body>

</html>