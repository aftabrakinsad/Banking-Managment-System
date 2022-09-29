<?php

include("../model/db.php");

$username = $_POST["username"];
if(!empty($username))
{
    $mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb ->searchUserbyUsername($username,"manager",$myconn);
if($results->num_rows >0)
{
 echo "User Exsists";
}
else
{
    echo "User doesn't Exists";
}
}

?>