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
    $name =$row["lastname"].", ".$row["firstname"];
    $username =$row["username"];
    $email =$row["email"];
    $dateofjoin=$row["doj"];
    $salary =$row["salary"];
    $phone =$row["phone"];
    $accountno =$row["accountno"];
    $fund =$row["fund"];
    if($row["activeStatus"]==0)
    {$status ="Pending";}
    if($row["activeStatus"]==1)
    {$status = "Active";}
    if($row["activeStatus"]==2)
    {$status ="Not Active";}
    }
   
}

// if () {
//     while($row = $result->fetch_assoc())
//     echo "id: ". $row["id"]."<br>"." First Name: ". $row["firstname"]."<br> "."Username : ".
//     $row["username"]."<br>"."Password : ". $row["pass"];
// }
//     else
//     echo "0 results";

if(isset($_POST["submit"]))
{   
   
     if(!empty($_POST["username"]))
    {
        $username = $_POST["username"];
        $mydb = new db();
        $myconn = $mydb -> openConn();
        $result2= $mydb -> updateUname($username,"manager",$myconn);
    }
    else
    {
        echo "";
      
    }

    if(!empty($_POST["email"]))
    { 
        $email = $_POST["email"];
        $mydb = new db();
        $myconn = $mydb -> openConn();
        $result3= $mydb -> updateEmail($email,$username,"manager",$myconn);
    }
   else
   {
    echo "";
    
   }
 
}


?>