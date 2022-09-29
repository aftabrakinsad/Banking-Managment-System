<?php
class db{

    function openConn()
    {
        $servername="localhost";
        $username = "root";
        $password = "";
        $dbname = "bankinmanagmentsystemmm";
        $conn =  new mysqli($servername,$username,$password,$dbname);
        if($conn -> connect_error)
        {
            echo "error connecting database";
        
        }
        return $conn;
    }


    function insertUser($name,$name2,$gender,$Age,$fathername,$mothername,$username,$password,$email,$presentaddress,$nid,$phone,$filepath,$imgpath,$Doj,$Salary,$table,$conn)
    {
        $sqlstr="INSERT INTO $table(firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary)
        VALUES ('$name','$name2','$gender','$Age','$fathername','$mothername','$username','$password','$email','$presentaddress','$nid','$phone','$filepath','$imgpath','$Doj','$Salary') ";

        if($conn-> query($sqlstr))
        {
            echo "Data saved";
        }
        else{
            echo "cant insert". $conn->error;
        }
    }


function delete_after_selection($email,$table, $conn)
{
    $sqlstr = "DELETE FROM $table WHERE email = '$email'";
        return $conn->query($sqlstr);
}


    function email_checking($email, $table, $conn)
    {
        $sqlstr = "SELECT email FROM $table WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    function deleting_new_manager($applicant_serial, $table, $conn)
    {
        $sqlstr = "DELETE FROM $table WHERE id = '$applicant_serial'";
        return $conn->query($sqlstr);
    }
    
    // function insertintomanager($email, $manager, $applicationofmanager, $conn)
    // {
    //     $sqlstr = "INSERT INTO $manager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund) SELECT firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund FROM $applicationofmanager WHERE email = '$email'";
    //     return $conn->query($sqlstr);
    // }
    function insertintomanager($email, $manager, $applicationofmanager, $conn)
    {
        $sqlstr = "INSERT INTO $manager (firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund) SELECT firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary,accountno,activeStatus,fund FROM $applicationofmanager";
        return $conn->query($sqlstr);
    }

    function insertaccountinfo($email, $manager_account_number,$applicationofmanager, $conn)
    {
        $sqlstr = "INSERT INTO $manager_account_number (email, nid) SELECT email, nid FROM $applicationofmanager WHERE email = '$email'";
        return $conn->query($sqlstr);
    }

    function insertapplicationUser($name,$name2,$gender,$Age,$fathername,$mothername,$username,$password,$email,$presentaddress,$nid,$phone,$filepath,$imgpath,$Doj,$Salary,$table,$conn)
    {
        $sqlstr="INSERT INTO $table(firstname,lastname,gender,age,fathersname,mothersname,username,pass,email,presentaddress,nid,phone,cvpath,imgpath,doj,salary)
        VALUES ('$name','$name2','$gender','$Age','$fathername','$mothername','$username','$password','$email','$presentaddress','$nid','$phone','$filepath','$imgpath','$Doj','$Salary') ";

        if($conn-> query($sqlstr))
        {
            echo "Data saved";
        }
        else{
            echo "cant insert". $conn->error;
        }
    }

    function CheckUser($username,$password,$table,$conn)
    {
        $result = $conn->query("SELECT * FROM ". $table." WHERE username='". $username."' AND pass ='". $password."'");
        return $result;
    }
    function displayUser($table,$conn)
    {
        $result = $conn->query("SELECT * FROM  $table");
        
        return $result;
           
    }

    function searchUserbyUsername($username,$table,$conn)
    {
        $result = "SELECT* FROM $table WHERE username = '$username'";
        return $conn->query($result);
    }

    function searchUserbyEmail($email,$table,$conn)
    {
        $result = "SELECT* FROM $table WHERE email = '$email'";
        return $conn->query($result);
    }

    function searchUserbyNid($nid,$table,$conn)
    {
        $result = "SELECT* FROM $table WHERE nid = '$nid'";
        return $conn->query($result);
    }

    function deleteUserbyUsername($username,$table,$conn)
    {
        $result = "DELETE FROM $table WHERE username = '$username'";
        return $conn->query($result);
    }

    function updateProfile($name,$name2,$gender,$Age,$fathername,$mothername,$username,$password,$email,$presentaddress,$nid,$phone,$Salary,$table,$conn)
    {
        $result = "UPDATE $table SET firstname='$name',lastname='$name2',gender='$gender',age='$Age',fathersname='$fathername',mothersname='$mothername',username ='$username',pass='$password',email='$email',presentaddress='$presentaddress',nid='$nid',phone='$phone',salary='$Salary' WHERE username ='$username' ";
    return $conn->query($result);
    }
    
    function updateEmail($email,$username,$table,$conn)
    {
        $result = "UPDATE $table SET email='$email'WHERE username ='$username' ";
    return $conn->query($result);
    }


    function updateUname($username,$table,$conn)
    {
        $result = "UPDATE $table SET username ='$username'WHERE username ='$username' ";
    return $conn->query($result);
    }

    function assignaccountno($username,$accountno,$table,$conn)
    {
        $result = "UPDATE $table SET accountno ='$accountno' WHERE username ='$username' ";
    return $conn->query($result);
    }
    function checkassignaccountno($username,$table,$conn)
    {
        $result = "SELECT  accountno FROM $table WHERE username ='$username' AND accountno is NULL  ";
    return $conn->query($result);
    }

    function checkactivestatus($username,$table,$conn)
    {
        $result = "SELECT  activeStatus FROM $table WHERE username ='$username' ";
    return $conn->query($result);
    } 
    
    function assignactivestatus($username,$status,$table,$conn)
    {
        $result = "UPDATE $table SET activeStatus = '$status' WHERE username ='$username' ";
    return $conn->query($result);
    }

    function viewemployee($username,$table,$conn)
    {
        $result = "SELECT* FROM $table WHERE manager ='$username' ";
    return $conn->query($result);
    }
/////////

function getaccount($username,$table,$conn)
{
    $result = "SELECT accountno FROM $table WHERE username ='$username' ";
    return $conn->query($result);
}

function getbalancebyusername($username,$table,$conn)
{
    $result = "SELECT fund FROM $table WHERE username ='$username' ";
    return $conn->query($result); 
}

function accountsearch($accountno,$table,$conn)
{
    $result = "SELECT* FROM $table WHERE accountno ='$accountno' ";
    return $conn->query($result); 
}

function getbalancebyaccountno($accountno,$table,$conn)
{
    $result = "SELECT fund FROM $table WHERE accountno ='$accountno' ";
    return $conn->query($result);
}

function updatebalancebyusername($username,$updated_sender_balance,$table,$conn)
{
    $result = "UPDATE $table SET fund = '$updated_sender_balance' WHERE username ='$username' ";
    return $conn->query($result);
}

function updatebalancebyaccountno($accountno,$updated_recever_balance,$table,$conn)
{
    $result = "UPDATE $table SET fund = '$updated_recever_balance' WHERE accountno ='$accountno' ";
    return $conn->query($result);
}

function updatepassbook($senderaccount,$receveraccount,$balancetransfered,$table,$conn)
{
    $sqlstr="INSERT INTO $table(senderaccount,receveraccount,balancetransfered,Date)
        VALUES ('$senderaccount','$receveraccount','$balancetransfered',NOW())";
     return $conn->query($sqlstr);
}

function getpassbyaccountno($username,$table,$conn)
{
    $result = "SELECT pass FROM $table WHERE username ='$username' ";
    return $conn->query($result);
}

function displaytransaction($table,$conn)
{
    $result = "SELECT* FROM $table ";
    return $conn->query($result);
}

function displaynews($news,$conn)
{
    $result = "SELECT* FROM $news ";
    return $conn->query($result);
}
function post_news($headline, $news_details, $news, $conn,$username)
    {
        $sqlstr = "INSERT INTO $news (tittle, news_body, created,sender) VALUES ('$headline', '$news_details', NOW(),'$username')";
        return $conn->query($sqlstr);
    }
}
?>