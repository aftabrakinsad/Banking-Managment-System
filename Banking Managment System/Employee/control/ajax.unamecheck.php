<?php

@include("../model/db.php");

$username = $_POST["username"];

#Checking Username via ajax
if(!empty($username))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb -> search_employee_by_username($username,"employeelogin", $myconn);
if($results -> num_rows > 0)
{
echo "User Exsists";
}
else
{
echo "User doesn't Exists";
}
}

?>
