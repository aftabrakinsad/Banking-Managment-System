<?php

@include("../model/db.php");

$Email = $_POST["Email"];

#Checking Username via ajax
if(!empty($Email))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb -> Emailreg_Ajex($Email,"registrationofemployee", $myconn);
if($results -> num_rows > 0)
{
echo "User Exsists";
}
else
{
echo "User doesn't Exists";
}
}

?>
