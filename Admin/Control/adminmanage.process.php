<?php

@include("../Model/db.php");

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
    $username = $_POST["username"];

    if (empty($username))
    {
        $errors['empty-username'] =  "Please enter username";
    }
    else if (!empty($username) && strlen($uname) >= 5)
    {
        $errors['uname-char'] = "Username must be more than 5 characters!";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $result = $mydb->search_by_User_name($username, "details_table_for_selected_admins", $myconn);

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
                $salary = $row["salary"];
                $accountno = $row["accountno"];
            }
        }
        else
        {
            $errors['username-nofound'] = "User name not found";
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

    if(empty($fname))
    {
        $errors['empty-firstname'] = "First name can' be empty";
    }
    else if(empty($lname))
    {
        $errors['empty-lastname'] = "Last name can' be empty";
    } 
    else if(empty($uname))
    {
        $errors['empty-username'] = "Username name can' be empty";
    }
    else if (empty($phone))
    {
        $errors['empty-phone'] = "Please Enter Valid Phone Number. ";
    }
    else if((!empty($phone)) && !preg_match("/^\+?(88)?0?1[3456789][0-9]{8}\b/", $phone))
    {
        $errors['phone-notvalid'] = "Phone number must contain country code. Ex. +880";
    } 
    else if (empty($email)) 
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if (!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $resulta = $mydb->updateProfile($_POST["fname"], $_POST["lname"], $_POST["uname"], $_POST["email"], $_POST["nid"], $_POST["phone"],  $_POST["salary"], $_POST["accountno"], "details_table_for_selected_admins", $myconn);

        $resultb = $mydb->updateProfileI($_POST["uname"], $_POST["email"], "admin_account_number", $myconn);

        $resultc = $mydb -> updateProfileII($_POST["uname"], $_POST["email"], "staticadmin", $myconn);

        if($resulta == true && $resultb == true)
        {
            $success['ok']= "Sucessfully Updated";
        }
        else
        {
            $errors['update-failed'] = "Update Failed". $myconn->error;
        }
    }
}

?>