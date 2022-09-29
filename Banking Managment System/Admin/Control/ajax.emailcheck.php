<?php

@include("../Model/db.php");

$email = $_POST["email"];

if(!empty($email))
{
    $mydb = new db();
    $myconn = $mydb -> openConn();
    $results = $mydb -> searching_existing_email($email,"staticadmin", $myconn);
    if($results -> num_rows > 0)
    {
        echo "Email Exsists";
    }
    else
    {
        echo "Email doesn't Exists";
    }
}

?>