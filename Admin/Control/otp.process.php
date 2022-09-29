<?php

@include("../Model/db.php");

$showotp = "";

session_start();

$errors = array();

if(isset($_POST["enterotp"]))
{
    $_SESSION['info'] = "";
    $code = $_POST['otp'];

    if(empty($code))
    {
        $errors['emptyotp'] = "OTP is required";
    }
    else if(strlen($code) != 6)
    {
        $errors['digiterror'] = "OTP must be 6 digits";
    }
    else if(!is_numeric($code))
    {
        $errors['numericerror'] = "OTP must be numeric";
    }
    else
    {
        $mydb = new db();
        $mycon = $mydb->openConn();
        $result = $mydb -> otp_verification($code, "staticadmin", $mycon);

        if($result -> num_rows > 0)
        {
            $fetch_data = mysqli_fetch_assoc($result);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password.";
            $_SESSION['info'] = $info;
            header("location: ../View/changepassword.php");
            exit();
        }
        else
        {
            $errors['invalidotp'] = "Invalid OTP";
        }
    }
    
    
}

if(isset($_POST["otpshowing"]))
{
    if(true)
    {
        $email = $_SESSION['email'];
        $mydb = new db();
        $mycon = $mydb -> openConn();
        $result = $mydb -> otp_showing($email, "staticadmin", $mycon);
        if($result -> num_rows > 0)
        {
            $myotp = $result->fetch_assoc();
            $showotp =  $myotp["code"]; 
        }
    }
}

?>