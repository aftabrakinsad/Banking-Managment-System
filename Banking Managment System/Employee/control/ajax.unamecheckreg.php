<?php

@include("../model/db.php");

$Username = $_POST["Username"];

#Checking Username via ajax
if(!empty($Username))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb -> usernamereg_Ajex($Username,"registrationofemployee", $myconn);
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
