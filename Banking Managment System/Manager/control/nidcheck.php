<?php

include("../model/db.php");

$nid = $_POST["nid"];
if(!empty($nid))
{
    $mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb ->searchUserbyNid($nid,"manager",$myconn);
if($results->num_rows >0)
{
 echo "Nid Number Exsists";
}
else
{
    echo "Nid Number doesn't Exists";
}
}

?>