<?php

include("../Control/changepassword.process.php");
$email = $_SESSION['email'];

?>

    <header>
        <?php

        @include("../View/public_top.php");

        ?>
<section class="card auth auth-wide">
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
</section>
<?php @include("../View/footer.php"); ?>
