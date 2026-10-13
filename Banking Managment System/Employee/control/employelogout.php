<?php
session_start();

if(session_destroy()) // Destroying All Sessions
{
{ header("Location: ../view/employelogin.php"); exit; } // Redirecting To Home Page
}
?>



