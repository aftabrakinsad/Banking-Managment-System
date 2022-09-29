<?php

@include("../Model/db.php");

$firstname = "";
$lastname = "";
$username = "";
$email = "";
$nid = "";
$phone = "";
$salary = "";
$presentaddress = "";
$errors = array();
$success = array();

if (isset($_POST["search"]))
{
    $nid = $_POST["nid"];

    if (empty($nid))
    {
        $errors['empty-username'] =  "Please enter NID";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $result = $mydb->search_by_nid($nid, "manager", $myconn);

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $username = $row["username"];
                $email = $row["email"];
                $nid = $row["nid"];
                $phone = $row["phone"];
                $salary = $row["salary"];
                $presentaddress = $row["presentaddress"];
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
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $salary = $_POST["salary"];
    $presentaddress = $_POST["presentaddress"];

    if(empty($firstname))
    {
        $errors['empty-firstname'] = "First name can' be empty";
    }
    else if(empty($lastname))
    {
        $errors['empty-lastname'] = "Last name can' be empty";
    } 
    else if(empty($username))
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
    else if(empty($salary))
    {
        $errors['salary-empty'] = "Enter salary Amount to update";
    }
    else if(empty($presentaddress))
    {
        $errors['empty-add'] = "Enter Address to update";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();        
        $resulta = $mydb->updateProfilemanager($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["email"], $_POST["nid"], $_POST["phone"],  $_POST["salary"], $_POST["presentaddress"], "manager", $myconn);

        if($resulta == true)
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