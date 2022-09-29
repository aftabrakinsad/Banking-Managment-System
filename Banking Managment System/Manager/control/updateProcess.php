<?php

include("../model/db.php");

$mydb = new db();
$myconn = $mydb -> openConn();

        $fname = "";
        $lname = "";
        $gender = "";
        $age = "";
        $fathersname = "";
        $mothersname = "";
        $uname = "";
        $password = "";
        $email ="";
        $presentaddress ="";
        $nid = "";
        $phone ="";
        $doj = "";
        $salary = "";
        $results="";
if(isset($_POST["search"]))
{
    $mydb = new db();
$myconn = $mydb -> openConn();
$username= $_POST["uname"];
$results = $mydb->searchUserbyUsername($username,"manager",$myconn);
   
if($results->num_rows>0)
    {
        while($myrow=$results->fetch_assoc())
{
    $fname = $myrow["firstname"];
    $lname = $myrow["lastname"];
    $gender = $myrow["gender"];
    $age = $myrow["age"];
    $fathersname = $myrow["fathersname"];
    $mothersname = $myrow["mothersname"];
    $uname = $myrow["username"];
    $password = $myrow["pass"];
    $email = $myrow["email"];
    $presentaddress = $myrow["presentaddress"];
    $nid = $myrow["nid"];
    $phone = $myrow["phone"];
    $doj = $myrow["doj"];
    $salary = $myrow["salary"];
}
       

    }
}
if(isset($_POST["update"]))
{    if(!empty($_POST["fname"])&&!empty($_POST["lname"])&&!empty($_POST["gender"])&&!empty($_POST["age"])&&!empty($_POST["mothername"])&&!empty($_POST["fathername"])&&!empty($_POST["username"])&&!empty($_POST["pass"])&&!empty($_POST["email"])&&!empty($_POST["address"])&&!empty($_POST["nid"])&&!empty($_POST["phone"])&&!empty($_POST["salary"])){
    $mydb = new db();
    $myconn = $mydb -> openConn();
    $results = $mydb->updateProfile($_POST["fname"],$_POST["lname"],$_POST["gender"],$_POST["age"],$_POST["fathername"],$_POST["mothername"],$_POST["username"],$_POST["pass"],$_POST["email"],$_POST["address"],$_POST["nid"],$_POST["phone"],$_POST["salary"],"manager",$myconn);
if($results===TRUE)
   {
    echo "Updated";
   }
   else{
    echo "Can't Update". $myconn->error;
   }    
}
}


?>