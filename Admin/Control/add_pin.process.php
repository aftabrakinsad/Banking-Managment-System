<?php

@include("../Model/db.php");
$errors = array();
$success = array();

$email = $_GET["email"];
$nid = $_GET["nid"];

$mydb = new db();
$myconn = $mydb->openConn();

$resultd =
$mydb->showing_data_from_admin_salary_control_to_add_salary($email, $nid, "details_table_for_selected_admins", $myconn);
$row = $resultd->fetch_assoc();
$email = $row["email"];
$nid = $row["nid"];

if(isset($_POST["submit"]))
{
    $email = $_POST["email"];
    $nid = $_POST["nid"];
    $pin = $_POST["pin"];

    if(empty($email))
    {
        $errors['email-empty'] = "Enter email to add Salary";
    }
    else if(!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address.";
    }
    else if(empty($nid))
    {
        $errors['empty-nid'] = "Please Enter Valid NationalIdentity Number. ";
    }
    else if(!empty($nid) && !is_numeric($nid))
    {
        $errors['nid-notnumetic'] = "NID must be numeric value";
    }
    else if(!empty($nid) && strlen($nid) != 8)
    {
        $errors['nid-digit'] = "NID should be 8 digits. ";
    }
    else if(empty($pin))
    {
        $errors['empty-pin'] = "Enter PIN";
    }
    else if(!is_numeric($pin))
    {
        $errors['pin-notnumeric'] = "PIN must be numeric value";
    }
    else if(!empty($pin) && strlen($pin) != 4)
    {
        $errors['salary-notvalidamount'] = "Enter 4 digit PIN";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $emailresult = $mydb -> searching_existing_email_in_details_table_for_selected_admins($email, "details_table_for_selected_admins", $myconn);
        $nidresult = $mydb -> searching_existing_nid_in_details_table_for_selected_admins($nid, "details_table_for_selected_admins", $myconn);

        if(($emailresult->num_rows > 0) && ($nidresult->num_rows > 0))
        {
            $result = $mydb->adding_pin_to_selected_admins($email, $nid, $pin, "details_table_for_selected_admins", $myconn);
            if ($result == true)
            {
                $success['pin-added'] = "PIN Added Sucessfully";
            }
        }
        else
        {
            $errors['email&nid-notexites'] = "Email or NID dosen't exists";
        }

    }
}
?>