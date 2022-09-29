<?php

@include("../Model/db.php");

$phone = $_POST["phone"];

if(!empty($phone))
{
    $mydb = new db();
    $myconn = $mydb->openConn();
    $results = $mydb -> seaching_exixting_phone_regisstration($phone, "applicantofadmin", $myconn);
    if($results ->num_rows > 0)
    {
        echo "Phone Number Already Exists";
    }
    else
    {
        echo "";
    }
}

?>