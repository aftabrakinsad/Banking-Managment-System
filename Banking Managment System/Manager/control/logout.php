<?php
session_start();

if(session_destroy()) // Destroying All Sessions
{
{ header("Location: ../view/managerlogin.php"); exit; } // Redirecting To Home Page
}
?>