<?php

// $errors = array();

@include('../model/db.php');

session_start();

if(isset($_POST["Change"]))
{
    $Email = $_POST['Email'];

    if(!empty($Email))
    {
        if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $Email))
        {
            $mydb = new db();
            $mycon = $mydb -> openConn();
            $result = $mydb -> user_searching_by_email($Email, "employeelogin", $mycon);

            if($result -> num_rows > 0)
            {
                $code = rand(999999, 100000);
                $result = $mydb -> otp_code($Email, $code, "employeelogin", $mycon);

                if($result == true)
                {
                        $_SESSION['info'] = $info;
                        $_SESSION['Email'] = $Email;

                        header("location: ../view/OTP.php");
                        exit();
                }
                else
                {
                    echo "Something went wrong!";
                }
            }
            else
            {
                echo "No user found with this email";
            }
        }
        else
        {
            echo "Invalid email";
        }
    }
    else
    {
        echo "Email is required";
    }
}
else
{

}

?>