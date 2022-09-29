<?php

include("../model/db.php");

$accountno = $_POST["accountno"];
if(!empty($accountno))
{
    $mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb ->accountsearch($accountno,"manager",$myconn);
if($results->num_rows >0)
{
 echo "Account Exsists";
}
else
{
    echo "Account doesn't Exists";
}
}

?>