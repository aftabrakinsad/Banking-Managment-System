<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

@include("../Control/add_user.process.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/addemp.css">
    <title>Add User</title>
</head>

<body class="bodycolor">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return adduser_formcheck()">
    <nav>
        <a class="inputrequestreturn" href="../View/Show_Added_User.php">Added User</a> <br> <br>
    </nav>

        <h2 class="h2" id="h2">Add User</h2>

        <?php
        if (count($errors) > 0)
        {
        ?>
            <div>
                <?php
                foreach ($errors as $showerror)
                {
                    echo "<p id='denger'> $showerror</p>";
                }
                ?>
            </div>
        <?php
        }
        else if (count($success) > 0)
        {
        ?>
            <div>
                <?php
                foreach ($success as $ok)
                {
                    echo "<p id='success'> $ok</p>";
                }
                ?>
            </div>
        <?php
        }
        ?>

        <table class="container">

            <tr>
                <td>
                    <input type="text" name="fname" id="fname" onkeyup="fnamecheck_adminregistration()" placeholder="Firstname">
                    <p id="fnameerr"></p>
                </td>

                <td>
                    <input type="text" name="lname" id="lname" onkeyup="lnamecheck_adminregistration()" placeholder="Lastname">
                    <p id="lnameerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="uname" id="uname" onkeyup="usernamecheck_admin()" placeholder="Username"> <br>
                    <p id="nameerr"></p>
                </td>

                <td>
                    <input type="text" name="email" id="email" onchange="registration_email_AJAX()" onkeyup="email_adminregistration()" placeholder="Email">
                    <p id="emailerr"></p>
                    <p id="emailajaxresponse"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="nid" id="nid" onchange="registration_nid_AJAX()" onkeyup="nid_adminregistration()" placeholder="Valid NID">
                    <p id="niderr"></p>
                    <p id="nidajaxresponse"></p>
                </td>

                <td>
                    <input type="text" name="phone" id="phone" onchange="registration_phone_AJAX()" onkeyup="phone_adminregistration()" placeholder="+880-1XXXXXXXXX">
                    <p id="phoneerr"></p>
                    <p id="phoneajaxresponse"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="accountno" id="accountno" onkeyup="accountno_addacc()" placeholder="Account No.">
                    <p id="accountnoerr"></p>
                </td>
                <td>
                    <input type="text" name="pin" id="pin" onkeyup="pin_xd()" placeholder="4 digit PIN">
                    <p id="pinerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="password" name="password" id="pass" onkeyup="password_adminregistration()" placeholder="Password">
                    <p id="passerr"></p>
                </td>

                <td>
                    <input type="password" name="cpassword" id="cpass" onkeyup="confirm_password_adminregistration()" placeholder="ConfirmPassword">
                    <p id="cpasserr"></p>
                </td>
            </tr>

        </table>

        <table class="container">

            <tr>
                <td>
                    <br>
                    <br>
                    <input class="inputrequestbutton" type="submit" name="submit" id="submit" value="ADD">
                    <a class="inputrequestreturn" href="../View/usermanage.php" name="return">Manage User</a>
                </td>
            </tr>

        </table>
    </form>

    <script src="../JS/user.js"></script>
</body>

</html