<?php

@include("../control/changepassword.process.php");
$Email = $_SESSION['Email'];

?>

    <header>
        <?php

        @include("../view/public_top.php");

        ?>
<section class="card auth auth-wide">
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

        <p class="h2">Change your password</p>

        <table>
            <tr>
                <td>
                    <input type="password" name="newpassword" placeholder="Enter new password">
                    <input type="password" name="confirmpassword" placeholder="Confirm your password">
                </td>
            </tr>

            <tr>
                <td>

                </td>
            </tr>

            <tr>
                <td>
                    <input class="otpbtn" type="submit" name="passwordsubmission" value="Change">

                </td>
            </tr>
        </table>

    </form>
</section>
<?php @include("../view/footer.php"); ?>
