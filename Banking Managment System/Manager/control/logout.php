<?php
session_start();

if(session_destroy()) // Destroying All Sessions
{
header("Location: ../view/managerlogin.php"); // Redirecting To Home Page
}
?>