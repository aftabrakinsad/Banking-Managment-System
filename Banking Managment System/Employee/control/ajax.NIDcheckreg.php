<?php

@include("../model/db.php");

$NId = $_POST["NId"];


if(!empty($NId))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb -> NIDreg_Ajex($NId,"registrationofemployee", $myconn);
if($results -> num_rows > 0)
{
echo "NID is alreay Exsists";
}
else
{
echo "User doesn't Exists";
}
}

?>
