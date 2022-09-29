<?php
// include("../model/db.php");
if(isset($_POST["delete"]))
{
$mydb = new db();
$myconn = $mydb -> openConn();
$username= $_POST["username"];
$results = $mydb->deleteUserbyUsername($username,"manager",$myconn);
if($results===TRUE)
   {
    echo "Deleted";
   }
   else{
    echo "Can't Update". $myconn->error;
   } 
}
?>