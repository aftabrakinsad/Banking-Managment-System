<?php

session_start();
if(!empty($_SESSION["username"])) 
{
$uname =$_SESSION["username"];
}
$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb -> searchUserbyUsername($uname,"manager",$myconn);

if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()){
    $name =", ".$row["lastname"]." ".$row["firstname"];
   $picture=$row["imgpath"];
    }
   
}
    
?>

