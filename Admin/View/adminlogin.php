<?php

@include('../Control/adminlogincheck.php');

if (isset($_SESSION['username'])) 
{
    header("location: ../View/adminhomepage.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/adminlogin.css">
    <title>Admin Log in</title>
</head>

<body class="bodyimage">
    <header>
        <?php
        @include("../View/header.php");
        ?>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return form_check_admin()" enctype="multipart/form-data">

        <h2 class="h2">Admin Login</h2>
        <img class="adminimage" src="../Image/admin_pro.jpeg">
        <table class="container">

            <tr>
                <td>
                    <label for="uname"> <input type="text" name="uname" id="uname" placeholder="Username" onchange="uname_AJAX()" onkeyup="usernamecheck_admin()"><br></label>
                    <p id="nameerr"></p>
                    <p id="unameajaxresponse"></p>
                </td>

            </tr>

            <tr>
                <td>
                    <label for="pass"> <input type="password" name="pass" id="pass" onkeyup="passwordcheck_admin()" placeholder="Password"><br></label>
                    <p id="passerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <?php

                    $fullfill = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if (strpos($fullfill, "login=empty") == true) {
                        echo "<p id = 'denger'>You did not fill all the fields!</p>";
                    } else if (strpos($fullfill, "username=empty") == true) {
                        echo "<p id = 'denger'>Please enter Username!<p>";
                    } else if (strpos($fullfill, "password=empty") == true) {
                        echo "<p id = 'denger'>Please enter Password!<p>";
                    } else if (strpos($fullfill, "login_info=incorrect") == true) {
                        echo "<p id = 'denger'>Username or Password is incorrect!<p>";
                    } else if (strpos($fullfill, "login=success") == true) {
                        echo "<p id = 'success'>Login Successfull<p>";
                    } else {
                        echo "";
                    }

                    ?>

                    <br>
                    <input type="checkbox" name="remember" id="remember" checked>
                    <label id="success" for="remember"><b>Remember Me</b></label>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="inputbutton" type="submit" name="submit" value="Login">
                </td>
            </tr>

            <tr>
                <th id="uniqueuse">
                    <a id="denger" href="../View/forgetpassword.php">Forget Password?</a><br><br>
                    <a id="primary" href="../View/adminregistration.php">Apply Admin</a>
                </th>
            </tr>
        </table>
    </form>
    <script src="../JS/adminlogin.js"></script>
</body>

<footer>
    <?php
    @include("../View/footer.php");
    ?>
</footer>

</html>