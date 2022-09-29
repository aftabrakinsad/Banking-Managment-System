<?php

@include("../model/db.php");

$showotp = "";

session_start();


if(isset($_POST["enterotp"]))
{
    $_SESSION['info'] = "";
    $code = $_POST['otp'];

    if(empty($code))
    {
       echo "OTP is required";
    }
    else if(strlen($code) != 6)
    {
        echo "OTP must be 6 digits";
    }
    else if(!is_numeric($code))
    {
        echo "OTP must be numeric";
    }
    else
    {
        $mydb = new db();
        $mycon = $mydb->openConn();
        $result = $mydb -> otp_verification($code, "employeelogin", $mycon);

        if($result -> num_rows > 0)
        {
            $fetch_data = mysqli_fetch_assoc($result);
            $Email = $fetch_data['Email'];
            $_SESSION['Email'] = $Email;
            $info = "Please create a new password.";
            $_SESSION['info'] = $info;
            header("location: ../view/Change_Password.php");
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
        $Email = $_SESSION['Email'];
        $mydb = new db();
        $mycon = $mydb -> openConn();
        $result = $mydb -> otp_showing($Email, "employeelogin", $mycon);
        if($result -> num_rows > 0)
        {
            $myotp = $result->fetch_assoc();
            $showotp =  $myotp["code"]; 
        }
    }
}

?>