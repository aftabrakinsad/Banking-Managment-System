<?php

@include('../Model/db.php');


session_start();

if (isset($_POST['submit']))
{
    $uname = $_POST['uname'];
    $password = $_POST['pass'];

    if ($uname != "" && $password != "")
    {
        $f = 0;
        $mydb = new db();
        $conobj = $mydb->openConn();
        $results = $mydb->loginadmin($conobj, "staticadmin", $_POST["uname"], $_POST["pass"]);

        if ($results->num_rows > 0)
        {
            foreach ($results as $user)
            {
                if ($user["uname"] == $_POST["uname"] && $user["pass"] == $_POST["pass"])
                {
                    $_SESSION['username'] = $user["uname"];
                    $_SESSION['password'] = $user["pass"];
                    if (!empty($_POST["remember"]))
                    {
                        setcookie("uname", $_SESSION['username'], time() + 86400);
                        setcookie("pass", $_SESSION['password'], time() + 86400);
                       
                        header("location: ../View/adminhomepage.php");
                    }
                    else
                    {
                        setcookie("uname", "");
                        setcookie("pass", "");
                        echo "";
                    }
                    header("location: ../View/adminhomepage.php");
                }
            }
        }
        else if ($f == 0)
        {
            header("location: ../view/adminlogin.php?login_info=incorrect");
            exit();
        }
    }
    if (empty($uname) && empty($password))
    {
        header("location: ../view/adminlogin.php?login=empty");
        exit();
    } 
    else if (empty($uname))
    {
        header("location: ../view/adminlogin.php?username=empty");
        exit();
    }
    else if (empty($password))
    {
        header("location: ../view/adminlogin.php?password=empty");
        exit();
    }
    else
    {
        header("location: ../view/adminlogin.php?login=success");
        exit();
    }
}

?>