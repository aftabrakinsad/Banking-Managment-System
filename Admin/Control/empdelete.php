<?php

@include("../Model/db.php");

if(isset($_GET['deleteid']))
{
    $id = $_GET['deleteid'];

    $mydb = new db();
    $myconn = $mydb->openConn();
    $id = $_GET['deleteid'];
    $result = $mydb->deleting_new_emp($id, "registrationofemployee", $myconn);
    
    if($result == true)
    {
        header("location: ../View/manageemp.php");
    }
    else
    {
        echo "error";
    }
}

?>