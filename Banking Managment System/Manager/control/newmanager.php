<?php

@include("../model/db.php");

if($_GET['email'])
{
    $email = $_GET['email'];
    
    $mydb = new db();
    $myconn = $mydb->openConn();
    $result = $mydb -> email_checking($email, "manager", $myconn);
    
    if($result -> num_rows > 0)
    {
        // echo "email already exists"; 
        header("location: ../view/managerrequest.php?admin=already_exists");
    }
    else
    {
        
        $resultII = $mydb -> insertintomanager($email,"manager", "applicationofmanager", $myconn);
       // $resultIII = $mydb -> adding_new_admin_accountno_info($email, "manager", "applicationofmanager", $myconn);
        $deleteresult= $mydb -> delete_after_selection($email,"applicationofmanager", $myconn);
        if($result == true && $resultII == true && $deleteresult==true)
        {
            header("location: ../view/managerrequest.php?manager=added");
        }
        else
        {
            echo "error";
        }
    }
}

?>