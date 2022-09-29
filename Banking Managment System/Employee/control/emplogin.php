<?php
@include("../model/db.php");

session_start();   #session suru user information store

if(isset($_POST['submit']))
{
   $username = $_POST['username'];
     $password = $_POST['password'];

   if($username != "" && $password != "")
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") # user input post r modde jabe then server r req korsi
        {
        $f = 0;    # 0 variable 
            $mydb = new db();
             $myconn = $mydb -> openConn();
             $result = $mydb-> employee_login($myconn, "employeelogin", $_POST['username'], $_POST['password']);

             if($result -> num_rows > 0)
             {
                 foreach($result as $employeuser)
                 {
                    if($employeuser["username"] = $_POST["username"] && $employeuser["password"] = $_POST["password"])
                     {



                        $_SESSION['username'] = $employeuser["username"];
                         $_SESSION['password'] = $employeuser["password"];

                         if (!empty($_POST["remember"]))
                         {

                            // $username = $_POST['username'];
                            // $password = $_POST['password'];

                            setcookie("username", $_POST['username'], time() + 86000);
                            setcookie("password", $_POST['password'], time() + 86000);
                            echo "";

                            // setcookie("username", $_SESSION['username'], time() + 86000);
                            //  setcookie("password", $_SESSION['password'], time() + 86000);
                            //  echo "";
                         }
                         else
                         {
                             setcookie("username", "");
                             setcookie("password", "");
                             echo "";
                         }
                         header("../view/epage1.php");
                   }
                }
            }
            else if ($f == 0) 
            {
                 echo  "Username and Password Doesn't Match";
            }
        }
     }
     else
     {
         echo " Username and Password Can't be Empty";
     }
 }
 if(isset($_POST['registration']))
 {
     header("location: ../view/employeregistration.php");
 } 
 ?>
