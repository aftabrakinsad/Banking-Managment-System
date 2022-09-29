<?php

@include("../Model/db.php");

$nid = $_POST["nid"];

if(!empty($nid))
{
    $mydb = new db();
    $myconn = $mydb->openConn();
    $results = $mydb -> seaching_exixting_nid_regisstration($nid, "applicantofadmin", $myconn);
    if($results -> num_rows >0)
    {
        echo "NID Already Exists";
    }
    else
    {
        echo "";
    }
}

?>