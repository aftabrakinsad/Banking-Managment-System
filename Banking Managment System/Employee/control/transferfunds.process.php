<?php
@include("../model/db.php");

$err_no = -1;

if(isset($_GET['accountno']))
{
$receiver_accountno = $_GET['accountno'];
}

if(isset($_POST["submit"]))
{
$accountno = $_POST["accountno"];
$atm = $_POST["atm"];
$pin = $_POST["pin"];

$mydb = new db();
$myconn = $mydb->openConn();
$resultI = $mydb->retrive_data_from($pin,"user", $myconn);
$row0 = $resultI->fetch_assoc();

$resultII = $mydb->dataone($accountno, "user", $myconn);
$row5 = $resultII->fetch_assoc();

if($resultI -> num_rows >0)
{
$resultIII = $mydb-> balance_from_passbook("prebookfunds", $myconn);
$row1 = $resultIII->fetch_assoc();
$sender_balance = $row1["balance"];

$updated_sender_balance = $sender_balance - $atm;

if($updated_sender_balance >= 0)
{
$resultIV = $mydb->datatwo("prebookfunds", $myconn);
$row2 = $resultIV->fetch_assoc();
$receiver_balance = $row2["balance"];

$updated_receiver_balance = $receiver_balance +
$atm;

$resultV = $mydb-> datathree($accountno,$row5, $atm, $updated_sender_balance, "prebookfunds", $myconn);

$resultVI = $mydb-> datafour($accountno,$row0, $atm, $updated_receiver_balance,"prebookfunds", $myconn);

if($resultV === true && $resultVI === true)
{
$err_no = 0;
}
}
else
{
$err_no = 1;
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
<!-- <link rel="stylesheet" href="../CSS/atmsuccess.css"> -->
<title>Transfer Some Funds to Others</title>
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
<p id="info"><?php echo "Transfer Successful !\n"; ?></p>
<?php
}
?>
<?php
if ($err_no == 1)
{
?>
<p id="info"><?php echo "Insufficient Funds !\n";?></p>
<?php
}
?>
<?php
if ($err_no == 2)
{
?>
<p id="info"><?php echo "Fill the information currectly !\n"; ?></p>
<?php
}
?>
</div>

<div class="flex-item">
<a href="../view/transferfund.php" class="button">Go Back</a>
</div>
</div>

</body>
</html>
