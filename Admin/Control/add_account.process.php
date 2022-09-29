<?php

    @include("../Model/db.php");

    $errors = array();
    $success = array();
    $showaccountno = "";

    $email = $_GET["email"];
    $nid = $_GET["nid"];

    if(isset($_POST["submit"]))
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $accountno = rand(9999999, 1000000);
        $resultd = $mydb->genetaring_account_number($email, $nid, $accountno, "admin_account_number", $myconn);
        if ($resultd == true)
        {
            $success['accno-added'] = "Account No Generated";
            header("../View/admin_salary_accno.php");
        }
        else
        {
            $errors['accno-decline'] = "Error! Adding Account No";
        }
        if(true)
        {
            $email = $_GET['email'];
            $result = $mydb ->accountno_showing($email, "admin_account_number", $myconn);
            if($result -> num_rows > 0)
            {
                $myaccountno = $result->fetch_assoc();
                $showaccountno =  $myaccountno["accountno"]; 
            }
        }
    }

    if(isset($_POST["enter"]))
    {
        $email = $_POST["email"];
        $nid = $_POST["nid"];
        $accountno = $_POST["accountno"];

        if (empty($email))
        {
            $errors['email-empty'] = "Enter email to add Salary";
        }
        else if (!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email))
        {
            $errors['email-notvalid'] = "Please Enter Valid Email Address.";
        }
        else if (empty($nid))
        {
            $errors['empty-nid'] = "Please Enter Valid National Identity Number.";
        }
        else if (!empty($nid) && !is_numeric($nid))
        {
            $errors['nid-notnumetic'] = "NID must be numeric  value";
        }
        else if (!empty($nid) && strlen($nid) != 8)
        {
            $errors['nid-digit'] = "NID should be 8 digits.";
        }
        else if(empty($accountno))
        {
            $errors['empty-accno'] = "Enter Account No";
        }
        else if (!is_numeric($accountno))
        {
        $errors['accountno-notnumeric'] = "Account No must be numeric value";
        }
        else if(!empty($accountno) && strlen($accountno) != 7)
        {
            $errors['accno-not'] = "Account No must contain 7 digit";
        }
        else
        {
            $mydb = new db();
            $myconn = $mydb->openConn();
            $mydb-> adding_new_admin_accountno($email, $nid, $accountno, "details_table_for_selected_admins",   $myconn);
            $mydb-> adding_new_admin_accountno_to_staticadmin($email, $accountno, "staticadmin", $myconn);
            $success['accno-added'] = "Successfully Added! Account  No.";
        }
    }

?>