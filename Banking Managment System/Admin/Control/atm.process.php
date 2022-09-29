<?php

@include("../Model/db.php");

$errors = array();

session_start();
if (empty($_SESSION["username"]) && empty($_SESS["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

if(isset($_POST["submit"]))
{
    $atm = $_POST["atm"];
    $type = $_POST["type"];
    $pin = $_POST["pin"];
    $accountno = $_POST["accountno"];

    $mydb = new db();
    $myconn = $mydb->openConn();
    $resultI = $mydb-> retreving_balance_from_passbook ("passbook", $myconn);
    $reI = $resultI->fetch_assoc();
    $balance = $reI["balance"];
    $err_no = -1;

    $resultII = $mydb->retriving_accountno_pin_from_details_table_for_selected_admins($accountno, $pin, "details_table_for_selected_admins", $myconn);
        
    if($resultII->num_rows > 0)
    {
        if($type == "credit")
        {
            $final_balance = $balance + $atm;

            $resultIII = $mydb-> inserting_passbook_credit($accountno,$atm, $final_balance, "passbook", $myconn);

            if($resultIII === true)
            {
                $err_no = 0;
            }
        }

        if($type == "debit")
        {
            $final_balance = $balance - $atm;

            if($final_balance >= 0)
            {
                $resultIV = $mydb->inserting_passbook_debit($accountno,$atm, $final_balance, "passbook", $myconn);

                if($resultIV === true)
                {
                    $err_no = 0;
                }
            }
            else
            {
                $err_no = 1;
            }
        }
    }
    else
    {
        $err_no = 2;
    } 
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/atmsuccess.css">
    <title>ATM Transactions</title>
</head>

<body>
    <div class="flex-container">
        <div class="flex-item">
            <?php
            if ($err_no == -1) 
            { 
            ?>
                <p id="info"><?php echo "Connection Error ! Please try again later.\n"; ?></p>
            <?php 
            } 
            ?>
            <?php
            if ($err_no == 0)
            { 
            ?>
                <p id="info"><?php echo "Transaction Successful !\n"; ?></p>
            <?php
            }
            ?>
            <?php
            if ($err_no == 1) 
            {
            ?>
                <p id="info"><?php echo "Insufficient Funds !\n"; ?></p>
            <?php 
            }
            ?>
            <?php
            if ($err_no == 2)
            {
            ?>
                <p id="info"><?php echo "Please Fill The Information Currectly !\n"; ?></p>
            <?php 
            } 
            ?>
        </div>

        <div class="flex-item">
            <a href="../View/atm.php" class="button">Go Back</a>
        </div>
    </div>

</body>

</html>