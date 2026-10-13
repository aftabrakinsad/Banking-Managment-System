<?php
@include("../Control/userexits.emailconfirmation.php");

?>

    <header>
        <?php

        @include("../View/public_top.php");

        ?>
<section class="card auth auth-wide">
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit=" return email_adminregistration()">

        <h2 class="h2">Forgot Password</h2>

        <?php
        if (count($errors) > 0)
        {
        ?>
            <div>
                <?php
                foreach ($errors as $showerror)
                {
                    echo "<p id='denger'>$showerror</p>";
                }
                ?>
            </div>
        <?php
        }
        ?>

        <input type="email" name="email" id="email" onchange="email_AJAX()" onkeyup="email_adminregistration()" placeholder="Enter email address">
        <p id="emailerr"></p>
        <p id="emailajaxresponse"></p>

        <table id="table">
            <tr>
                <td>
                    <input class="inputbutton" type="submit" name="Change" value="Change">
                    <a class="inputrequestreturn" name="return" href="../View/adminlogin.php">Back to Login</a>
                </td>
            </tr>
        </table>
        <script src="../JS/adminregistration.js"></script>
    </form>
</section>
<?php @include("../View/footer.php"); ?>
