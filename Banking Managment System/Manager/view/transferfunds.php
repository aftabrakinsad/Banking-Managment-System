<?php


// if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
//     header("location: ../View/adminlogin.php");
// }
session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}
@include("../view/header.php");
@include("../view/navbar.php");
@include("../view/sidebar.php");

include("../control/transferfundprocess.php")

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/transferfunds.css">
</head>

<body>
<form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <div class="flex-container-form_header">
            <h1 id="form_header">Transfer Funds</h1>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter Account No. :</label><br>
                <input type="text" name="accountno" id="accountno" onkeyup="checkaccountno()" onchange="accountcheck()"><p id="account"></p>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter Amount :</label><br>
                <input name="atm" id="amount"size="24" type="text" onkeyup="checkamount()"><p id="amounter"></p>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter your Password :</b></label><br>
                <input name="pass" id="pass" size="24" type="password" onkeyup="passcheck()"><p id="passvalue"></p>
                <input name="submit" type="submit"  class="button">
                <button type="reset" class="reset">Reset</button>
            </div>
        </div>

            <div class="container">
              
            </div>

            <div class="container">
                
            </div>
        </div>

    </form>
    <script src="../js/fund.js"></script>
</body>
</html>