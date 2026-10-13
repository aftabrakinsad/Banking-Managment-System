<?php

@include("../control/otp.process.php");

//$Email =$_SESSION["Email"];

?>

    <header>
        <?php
        
            @include("../view/public_top.php");

        ?>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return otp_forpasswordchange()">

        <h2 class="h2">Enter the correct OTP</h2>
        <table>
            <tr>
                <td>
                    <input type="text" name="otp" id="otp" onkeyup="otp_forpasswordchange()" placeholder="Enter otp">
                    <p id="otperr"></p>
                    <?php
                    echo "<p class='xd' id='otpp' onkeyup='fade()'>$showotp</p>";
                    ?>
                    <input class="otpbtn" type="submit" name="enterotp" value="Submit">
                    <input class="otpbtn" type="submit" name="otpshowing" id="otpshowing" value="Show OTP">
                </td>
            </tr>
        </table>
    </form>
    <script src="../JS/OTP.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php @include("../view/footer.php"); ?>
