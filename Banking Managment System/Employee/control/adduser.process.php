<?php

@include("../model/db.php");

$fname = "";
$lname = "";
$uname = "";
$email = "";
$nid = "";
$phone = "";
$salary = "";
$accountno = "";
$errors = array();
$success = array();

if (isset($_POST["search"]))
{
$accountno = $_POST["accountno"];

if (empty($accountno))
{
$errors['empty-username'] = "Please enter account no";
}
else if (!empty($accountno) && strlen($unaaccountnome) == 7)
{
$errors['uname-char'] = "account no must be equal 7 digits!";
}
else
{
$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb->search_by_User_accountno($accountno, "user", $myconn);

if ($result->num_rows > 0)
{
while ($row = $result->fetch_assoc())
{
$fname = $row["fname"];
$lname = $row["lname"];
$uname = $row["uname"];
$email = $row["email"];
$nid = $row["nid"];
$phone = $row["phone"];
$accountno = $row["accountno"];
}
}
else
{
$errors['username-nofound'] = "Account No. not found";
}
}
}


if(isset($_POST["submit"]))
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];


        $mydb = new db();
        $myconn = $mydb->openConn();
 
        // $resulta = $mydb->update_user($_POST["fname"], "user",$myconn);

        $resulta = $mydb->update_user($_POST["fname"], "user", $myconn);
 
        if($resulta == true)
        {
           echo "Sucessfully Updated";
        }
        else
        {
           echo "Update Failed". $myconn->error;
        }
    
}