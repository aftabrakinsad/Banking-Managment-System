<?php

@include("../model/db.php");

$Phone = $_POST["Phone"];

#Checking Username via ajax
if(!empty($Phone))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb -> Phonereg_Ajex($Phone,"registrationofemployee", $myconn);
if($results -> num_rows > 0)
{
echo "Phone Number Aldeady Exsists";
}
else
{
echo "Phone Number doesn't Exists";
}
}

?>