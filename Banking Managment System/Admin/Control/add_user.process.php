<?php

$errors = array();
$success = array();

@include("../Model/db.php");

$uppercase = $lowercase = $number = $specialchars = "";

session_start();

if (isset($_POST["submit"]))
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $nid = $_POST["nid"];
    $phone = $_POST["phone"];
    $accountno = $_POST["accountno"];
    $pin = $_POST["pin"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialchars = preg_match('@[^\W]@', $password);

    if (empty($fname) && empty($lname) && empty($uname) && empty($email) && empty($nid) && empty($phone) && empty($password) && empty($cpassword) && empty($_FILES["picture"]["tmp_name"]) && empty($_FILES["cv"]["tmp_name"]))
    {
        $errors['empty-fields'] = "You did not fill all the fields! ";
    }
    else if(empty($fname))
    {
        $errors['empty-fname'] = "Please Enter Your Firstname.";
    }
    else if(empty($lname))
    {
        $errors['empty-lname'] = "Please Enter Your Lastname.";
    }
    else if(empty($uname))
    {
        $errors['empty-uname'] = "Please Enter Your Username.";
    }
    else if (!empty($uname) && strlen($uname) <= 5)
    {
        $errors['uname-char'] = "Username must be more than 5 characters! ";
    }
    else if(empty($email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if(!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if(empty($nid))
    {
        $errors['empty-nid'] = "Please Enter Valid National Identity Number. ";
    }
    else if(!empty($nid) && strlen($nid) != 8)
    {
        $errors['nid-digit'] = "NID should be 8 digits. ";
    }
    else if(!empty($nid) && !is_numeric(($nid)))
    {
        $errors['nid-err'] = "NID should be numeric value";
    }
    else if(empty($phone))
    {
        $errors['empty-phone'] = "Please Enter Valid Phone Number. ";
    }
    else if(!empty($phone) && !preg_match("/^\+?(88)?0?1[3456789][0-9]{8}\b/", $phone))
    {
        $errors['phone-invalidp'] = "Invalid Phone Number Pattern";
    }
    else if(empty($accountno))
    {
        $errors['acc-empty'] = "Enter the Account No.";
    }
    else if(!empty($accountno) && strlen($accountno) !=7)
    {
        $errors['acc-err'] = "Account No. must be equal to 7 digits";
    }
    else if(!empty($accountno) && !is_numeric($accountno))
    {
        $errors['acc-errr'] = "Account No. must be numeric value";
    }
    else if(empty($pin))
    {
        $errors['pin-empty'] = "Enter PIN";
    }
    else if(!empty($pin) && strlen($pin) !=4)
    {
        $errors['pin-err'] = "PIN must be equal to 4 digits";
    }
    else if(!empty($pin) && !is_numeric($pin))
    {
        $errors['pin-errr'] = "PIN must be numeric value";
    }
    else if(empty($password))
    {
        $errors['empty-pass'] = "Enter Password! ";
    }
    else if(empty($cpassword))
    {
        $errors['empty-cpass'] = "Confirm Your Password ";
    }
    else if(!empty($password) && !empty($cpassword))
    {
        if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) <= 8)
        {
            $errors['pass-notvalid'] = "Password should be more than or equal to 8 characters and should include at least one uppercase, onelower case, one number and one special character! ";
        }
        else if($password != $cpassword)
        {
            $errors['pass-notmatched'] = "Password didn't match. ";
        }
    }
    if ($fname != "" && $lname != "" && $uname != "" && $email != "" && $nid != "" && $phone != "" && $accountno != "" && $pin != "" && $password != "" && $cpassword != "")
    {
        if(true)
        {
            $mydb = new db();
            $myconn = $mydb->openConn();
            $result = $mydb ->add_usser($fname, $lname, $uname, $email, $nid, $phone, $accountno, $pin, $password, $cpassword, "new_user",  $myconn);

            if($result == true)
            {
                $success['user-added'] = "User Added Successfully";
            }
            else
            {
                $errors['err-er'] = "Error to add".$result->error;
            }
        }
    }
    else
    {
        $errors['useradding-failed'] = "Adding Process failed. Please try again. ";
    }
}

?>