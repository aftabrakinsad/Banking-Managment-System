<?php

@include("../Model/db.php");

if(isset($_GET['deleteid']))
{
    $user_id = $_GET['deleteid'];

    $mydb = new db();
    $myconn = $mydb->openConn();
    $user_id = $_GET['deleteid'];
    $result = $mydb-> deleting_added_user($user_id, "new_user",  $myconn);
    
    if($result == true)
    {
        header("location: ../View/Show_Added_User.php");
    }
    else
    {
        echo "error";
    }
}

?>