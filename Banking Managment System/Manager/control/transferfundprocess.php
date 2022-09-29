<?php

//include("../model/db.php");
// if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
//     header("location: ../View/adminlogin.php");
// }
if(!empty($_SESSION["username"])&&!empty($_SESSION["password"])) 
{
$username =$_SESSION["username"];
$password = $_SESSION["password"];
}

$receveraccount='';
$receiverbalance='';


if(isset($_POST["submit"]))
{  
   
    
    
    if(!empty($_POST["accountno"])&&!empty($_POST["atm"])&&!empty($_POST["pass"])) 
    {
        $receveraccount = $_POST["accountno"];
    
    
   
   
    $atm = (int)$_POST["atm"];
    $pass = $_POST["pass"];
    
    if(strcmp($password,$pass)==0){
    $mydb = new db();
    $myconn = $mydb -> openConn();
   $result=$mydb->getaccount($username,"manager",$myconn);
    if($result->num_rows>0)
    { while($row = $result->fetch_assoc()){
        $senderaccount= (int)$row['accountno'];
    }
   
    }
  
     $result=$mydb->getbalancebyusername($username,"manager",$myconn);
    if($result->num_rows>0)
    {while($row = $result->fetch_assoc()){
        $senderbalance= (int)$row['fund'];
    }
}
     $result=$mydb->getbalancebyaccountno($receveraccount,"manager",$myconn);
    if($result->num_rows>0)
    {while($row = $result->fetch_assoc()){
        $receiverbalance= (int)$row['fund'];
    }
}

if($senderbalance<$atm)
{echo "Balance not sufficent";}
else
{
    $updated_sender_balance = $senderbalance - $atm;
    $updated_recever_balance = $receiverbalance + $atm;
    $senderupdate = $mydb->updatebalancebyusername($username,$updated_sender_balance,"manager",$myconn);
    $receverupdate= $mydb->updatebalancebyaccountno($receveraccount,$updated_recever_balance,"manager",$myconn);
    $transaction =$mydb->updatepassbook($senderaccount,$receveraccount,$atm,"transaction",$myconn);
}
   
}
else
{echo "Password doesn't Match";}
}
}
else{echo "Fill all the fields";}
?>