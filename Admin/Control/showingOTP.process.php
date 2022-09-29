<?php

@include("../Model/db.php");

$showotp = "";

session_start();

if(true)
{
    $email = $_SESSION['email'];
    $mydb = new db();
    $mycon = $mydb -> openConn();
    $result = $mydb -> otp_showing($email, "staticadmin", $mycon);
    if($result -> num_rows > 0)
    {
        $myotp = $result->fetch_assoc();
        $showotp =  $myotp["code"];
        echo $showotp;
    }
}

?>