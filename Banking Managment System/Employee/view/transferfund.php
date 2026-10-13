<?php
session_start();

@include("../view/header.php");

?>

<form action="../control/transferfunds.process.php" method="post" onsubmit="return formcheck_transfer()">
<div class="flex-container-form_header">
<h1 id="form_header">Money Transition </h1>
</div>

<!-- <div>
<nav>
<a class="a" href="../view/transferfund.php">See your Transactions</a>
</nav>
</div> -->

<div class="flex-container">
<div class=container>
<label>Enter Account No. :</label><br>
<input type="text" name="accountno" id="accountno" onkeyup="account_no()">
<p id="account_no_error"></p>
</div>

<div class=container>
<label>Enter Amount to Tranfer :</label><br>
<input name="atm" type="text" id="atm" onkeyup="transfer_amount()">
<p id="transfer_amount_error"></p>
</div>
</div>

<div class="flex-container">
<div class=container>
<label>Enter Your PIN :</b></label><br>
<input name="pin" type="password" id="pin" onkeyup="tranfer_pin()">
<p id="pin_error"></p>
</div>

<div class="container">
<input class="button" name="submit" type="submit">
</div>
</div>

<div class="flex-container">
<div class="container">
<a href="../view/epage1.php" class="button">Go Back</a>
</div>

<div class="container">
<button type="reset" class="reset">Reset</button>
</div>
</div>

</form>
<script src="../JS/transfermoney.js"></script>
<?php @include("../view/footer.php"); ?>
