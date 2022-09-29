<?php

@include("../Model/db.php");

if(isset($_GET['deleteid']))
{
    $applicant_serial = $_GET['deleteid'];

    $mydb = new db();
    $myconn = $mydb->openConn();
    $applicant_serial = $_GET['deleteid'];
    $result = $mydb ->deleting_new_admin($applicant_serial, "applicantofadmin", $myconn);
    
    if($result == true)
    {
        header("location: ../View/adminrequest.php");
    }
    else
    {
        echo "error";
    }
}

?>