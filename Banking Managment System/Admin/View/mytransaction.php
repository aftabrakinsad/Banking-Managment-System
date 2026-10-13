<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    { header("location: ../View/adminlogin.php"); exit; }
}

@include("../View/header.php");

?>

    <form action="" method="POST">
        <table>
            <caption>Transaction History</ caption>
            <thead>
                <tr>
                    <th scope="col">Transaction Date</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Account No.</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/transation.process.php");
                ?>
            </tbody>
        </table>
    </form> <br> <br>
    <a id="info2" href="../View/atm.php">Go Back</a>
<?php @include("../View/footer.php"); ?>
