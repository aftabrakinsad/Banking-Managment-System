<?php

@include("../Model/db.php");

if(isset($_GET['deleteid']))
{
    $applicant_serial = $_GET['deleteid'];

    $mydb = new db();
    $myconn = $mydb->openConn();
    $applicant_serial = $_GET['deleteid'];
    $result = $mydb ->deleting_new_manager($applicant_serial, "applicationofmanager", $myconn);
    
    if($result == true)
    {
        header("location: ../view/managerrequest.php");
    }
    else
    {
        echo "error";
    }
}

?>