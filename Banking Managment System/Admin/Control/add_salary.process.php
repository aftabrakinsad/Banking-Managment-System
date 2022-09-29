<?php

@include("../Model/db.php");
$errors = array();
$success = array();

$email = $_GET["email"];
$nid = $_GET["nid"];

$mydb = new db();
$myconn = $mydb->openConn();
$resultd = $mydb->showing_data_from_admin_salary_control_to_add_salary($email, $nid, "details_table_for_selected_admins", $myconn);
$row = $resultd->fetch_assoc();
$email = $row["email"];
$nid = $row["nid"];

if(isset($_POST["submit"]))
{
    $email = $_POST["email"];
    $nid = $_POST["nid"];
    $salary = $_POST["salary"];

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
        $errors['empty-nid'] = "Please Enter Valid National Identity Number. ";
    }
    else if(!empty($nid) && !is_numeric($nid))
    {
        $errors['nid-notnumetic'] = "NID must be numeric value";
    }
    else if(!empty($nid) && strlen($nid) != 8)
    {
        $errors['nid-digit'] = "NID should be 8 digits. ";
    }
    else if(empty($salary))
    {
        $errors['empty-salary'] = "Enter Salary amount";
    }
    else if(!is_numeric($salary))
    {
        $errors['salary-notnumeric'] = "Salary must be numeric value";
    }
    else if(!empty($salary) && strlen($salary) > 7)
    {
        $errors['salary-notvalidamount'] = "Salary Can't be more than 7 digits (1000000)";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $emailresult = $mydb -> searching_existing_email_in_details_table_for_selected_admins($email, "details_table_for_selected_admins", $myconn);
        $nidresult = $mydb -> searching_existing_nid_in_details_table_for_selected_admins($nid, "details_table_for_selected_admins", $myconn);

        if(($emailresult->num_rows > 0) && ($nidresult->num_rows > 0))
        {
            $result = $mydb->adding_salary_to_selected_admins($email, $nid, $salary, "details_table_for_selected_admins", $myconn);
            if ($result == true)
            {
                $success['Salary-added'] = "Salary Added Sucessfully";
            }
        }
        else
        {
            $errors['email&nid-notexites'] = "Email or NID dosen't exists";
        }

    }
}

?>