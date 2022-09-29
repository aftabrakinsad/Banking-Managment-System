<?php
session_start();

if(session_destroy()) // Destroying All Sessions
{
header("Location: ../view/employelogin.php"); // Redirecting To Home Page
}
?>



