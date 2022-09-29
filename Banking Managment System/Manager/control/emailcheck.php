<?php

include("../model/db.php");

$email = $_POST["email"];
if(!empty($email))
{
    $mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb ->searchUserbyEmail($email,"manager",$myconn);
if($results->num_rows >0)
{
 echo "Email Exsists";
}
else
{
    echo "Email doesn't Exists";
}
}

?>