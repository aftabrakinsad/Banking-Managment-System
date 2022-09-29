<?php

@include("../Model/db.php");

$email = $_POST["email"];

if(!empty($email))
{
    $mydb = new db();
    $myconn = $mydb->openConn();
    $results = $mydb -> searching_existing_email_registration($email, "applicantofadmin", $myconn);
    if($results -> num_rows > 0)
    {
        echo "Email Already Exists";
    }
    else
    {
        echo "";
    }
}

?>