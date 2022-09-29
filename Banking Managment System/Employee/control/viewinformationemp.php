<?php

@include("../model/db.php");

$mydb = new db();
$myconn = $mydb -> openConn();

$fname = "";
$lname = "";
$Username= "";
$Email = "";
$NID = "";
$Phone = "";
$Password = "";
$cpassword="";
$picture = "";
$cv = "";

if(isset($_POST["Search"]))
{
    $username =$_POST["username"];
$mydb = new db();
$myconn = $mydb -> openConn();
$results = $mydb->searchUserbyUsername($username,"registrationofemployee",$myconn);

if($results->num_rows>0)
{
while($myrow=$results->fetch_assoc())
{
$fname = $myrow["fname"];
$lname = $myrow["lname"];
$Username = $myrow["Username"];
$Email = $myrow["Email"];
$NID = $myrow["NID"];
$Phone = $myrow["Phone"];
$Password = $myrow["Password"];
$cpassword = $myrow["cpassword"];
// $picture = $myrow["picture"]["name"];
// $cv = $myrow["cv"]["name"];
}


}
}
if(isset($_POST["update"]))
{  
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $Phone = $_POST["phone"];
    // $Email = $_POST["Email"];

        $mydb = new db();
        $myconn = $mydb->openConn();
        $resulta = $mydb->updateProfile($_POST["fname"], $_POST["uname"],$_POST["lname"], $_POST["phone"],"registrationofemployee", $myconn);
 
        if($resulta == true)
        {
            echo "Sucessfully Updated";
        }
        else
        {
            echo "Update Failed". $myconn->error;
        }
    }




?>