<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

// @include("../Control/transferfunds.process.php");

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/transferfunds.css">
    <title>Transfer Some Funds to Others</title>
</head>

<body>
    <form action="../Control/transferfunds.process.php" method="post" onsubmit="return formcheck_atm()">
        <div class="flex-container-form_header">
            <h1 id="form_header">Transfer Funds</h1>
        </div>

        <div>
            <nav>
                <a class="a" href="../View/mytransaction.php">See your Transactions</a>
            </nav>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter Account No. :</label><br>
                <input type="text" name="accountno" id="accountno" onkeyup="accountno_atm()">
                <p id="accountno_error"></p>
            </div>

            <div class=container>
                <label>Enter Amount :</label><br>
                <input name="atm" type="text" id="atm" onkeyup="amount_atm()">
                <p id="amount_error"></p>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter your PIN :</b></label><br>
                <input name="pin" type="password" id="pin" onkeyup="pin_atm()">
                <p id="pin_error"></p>
            </div>

            <div class="container">
                <input class="button" name="submit" type="submit">
            </div>
        </div>

        <div class="flex-container">
            <div class="container">
                <a href="../View/atm.php" class="button">Go Back</a>
            </div>

            <div class="container">
                <button type="reset" class="reset">Reset</button>
            </div>
        </div>

    </form>
    <script src="../JS/atm.js"></script>
</body>

</html>