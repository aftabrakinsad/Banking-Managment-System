<?php

$errors = array();

@include('../Model/db.php');

session_start();

if(isset($_POST["Change"]))
{
    $email = $_POST['email'];

    if(!empty($email))
    {
        if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
        {
            $mydb = new db();
            $mycon = $mydb -> openConn();
            $result = $mydb -> user_searching_by_email($email, "staticadmin", $mycon);

            if($result -> num_rows > 0)
            {
                $code = rand(999999, 100000);
                $result = $mydb -> otp_code($email, $code, "staticadmin", $mycon);
        
                if($result == true)
                {
                    $subject = "Password Reset Code";
                    $massage = "Your password reset code is $code";
                    $sender = "From: rakinsadaftab@gmail.com";
            
                    if(mail($email, $subject, $message, $sender))
                    {
                        $info = "We've sent a passwrod reset otp to your email - $email";
                        $_SESSION['info'] = $info;
                        $_SESSION['email'] = $email;

                        header("location: ../View/otpsubmission.php");
                        exit();
                    }
                    else
                    {
                        $errors['otp-error'] = "Failed while sending code!";
                    }
                }
                else
                {
                    $errors['db-error'] = "Something went wrong!";
                }
            }
            else
            {
                $errors['notexits'] = "No user found with this email";
            }
        }
        else
        {
            $errors['email-error'] = "Invalid email";
        }
    }
    else
    {
        $errors['emptyemail'] = "Email is required";
    }
}
else
{

}

?>