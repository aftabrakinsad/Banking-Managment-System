<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/atm.css">
    <title>ATM</title>
</head>

<body>
    <form action="../Control/atm.process.php" method="post" onsubmit="return formcheck_atm()">
        <div class="flex-container-form_header">
            <h1 id="form_header">ATM Simulator</h1>
        </div>
        <div>
            <nav>
                <a class="a" href="../View/mytransaction.php">See your Transactions</a>
                <a class="a" href="../View/transferfunds.php">Fund Tranfer</a>
            </nav>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter Account No:</label><br>
                <input name="accountno" id="accountno" type="text" onkeyup="accountno_atm()">
                <p id="accountno_error"></p>
            </div>

            <div class=container>
                <label>Enter Amount:</label><br>
                <input name="atm" id="atm" type="text" onkeyup="amount_atm()">
                <p id="amount_error"></p>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Type :</label>
            </div>
            <div class="flex-container-radio">
                <div class="container">
                    <input type="radio" name="type" value="debit" id="debit-radio" checked>
                    <label id="radio-label" for="debit-radio"><span class="radio">Debit</span></label>
                </div>
                <div class="container">
                    <input type="radio" name="type" value="credit" id="credit-radio">
                    <label id="radio-label" for="credit-radio"><span class="radio">Credit</span></label>
                    <p id=""></p>
                </div>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>PIN(4 digit) :</b></label><br>
                <input name="pin" id="pin" onkeyup="pin_atm()" type="password">
                <p id="pin_error"></p>
            </div>
        </div>

        <div class="flex-container">
            <div class="container">
                <input class="button" name="submit" type="submit" value="submit">
            </div>

            <div class="container">
                <button type="reset" class="reset">Reset</button>
            </div>
        </div>

    </form>
    <script src="../JS/atm.js"></script>
</body>

</html>