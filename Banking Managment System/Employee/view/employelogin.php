<?php

include('../control/emplogin.php');     #employ login r control

    if(isset($_SESSION['username']) )
{
    header("location: ../view/epage1.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/design.css">
    <title>Employe Login Form </title>
</head>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validlogin()" enctype="multipart/form-data">
    <center>
    <body>
    <div class= "header sticky">
    <h1>City Bank Limited</h1>
    </div>
        <header>

            <p><strong><font color="black">Login As An Employe</font></strong></p>
            <br><br><br><br>
        </header>

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">

                <table>
                    <tr>
                        <td>
                            <label>
                            </label>
                            <input type="text" id="username" name="username" onchange="uname_AJAX()" onkeyup="usernamecheck()" placeholder="Enter Username">
                            <p id="usererr"></p>
                            <p id="unameajaxresponse"></p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>
                            </label>
                            <input type="password" id="password" name="password" onkeyup="passwordcheck()" placeholder="Enter Password">
                            <p id="passworderr"></p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox" name="remember" id="remember" clicked>
                            <label for="remember">
                                <b>Remember Me</b>
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="login" type="submit" name="submit" value="Login">
                        </td>
                        <td>
                            <a class="regi" href="../view/employeregistration.php">Registration</a>
                        </td>
                    </tr>
                    <tr>

                    <th>
                    <a id="denger" href="../view/forgetpassword.php">Forget Password?</a><br><br>
                </th>
                    </tr>
                </table>
        </form>
    </center>
    <script src="../JS/loginjs.js"></script>
</body>

</html

 
