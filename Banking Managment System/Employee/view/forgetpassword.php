<?php
@include("../control/userexits.emailconfirmation.php");

?>

    <header>
        <?php

        @include("../view/public_top.php");

        ?>
<section class="card auth auth-wide">
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
</section>
<?php @include("../view/footer.php"); ?>
