<?php

session_start();

if (isset($_SESSION['username']))
{
    header("location: ../view/employelogin.php");
}

include('../control/Employeeregistration.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/registration.css">
    <title> Registration Form</title>
</head>

<body>
<div class= "header sticky"> </div>

    <header>
    <h2 class="h2" id="h2">Welcome to City Bank Limited</h2>

        <p><strong>Use correct information to apply </strong>
        </p>
    </header>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
   
    <h2 class="h3" id="h3">Registration Form</h2>
        
        <table>

            <tr>
                <td>
                    <input type="text" name="fname" placeholder="Firstname" id="fname"  onkeyup="checkfname()">
                    <p id="nameerror"></p>
                </td>

                <td>
                    <input type="text" name="lname" placeholder="Lastname"  id="lname" onkeyup="checklname()">
                    <p id="lnameerror"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="uname" placeholder="Username" id="Username" onchange="uname_AJAX()" onkeyup="checkuname()">
                    <p id="usernameerr">
                    <p id="unameajaxresponse"></p>
                </td>

                <td>
                    <input type="text" name="email" placeholder="Email:myname@example.com"" id ="Email" onchange="Email_AJAX()" onkeyup = "validateemail()">
                    <p id="emailvalue"></p>
                    <p id="Emailajaxresponse"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="nid" placeholder="Valid NID" id="NID" onchange="NID_Ajex()" onkeyup = "checknid()">
                    <p id="NIDerr"></p>
                    <p id="NIDajaxresponse"></p>
                </td>

                <td>
                    <input type="text" name="Phone" placeholder="+880-1XXXXXXXXX" id="Phone" onchange="Phone_AJAX()" onkeyup="checkphone()">
                    <p id="phoneerrjs"></p>
                    <p id="Phoneajaxresponse"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="password" name="password" placeholder="Password" id="Password" onkeyup="checkpassword()">
               <p id="passworderr"></p>
                </td>

                <td>
                    <input type="password" name="cpassword" placeholder="Confirm Password" id="CPassword" onkeyup="checkconfirmpassword()" >
                    <p id="Cpassworderr"></p>
                </td>
            </tr>
            <tr><td><label>Gender: </label></td>
                        <td>
                            <input type="radio" name="gender" value="male">Male
                            <input type="radio" name="gender" value="female">Female
                            <input type="radio" name="gender" value="others">Others
                    </td>
                    </tr>

            <tr>
                <td>
                    Please upload your picture
                    <input type="file" name="picture">
                    </p>
                </td>

                <td>
                    Please upload your cv
                    <input type="file" name="cv">
                </td>
            </tr>

        </table>

        <table>
                <td>
                    <?php

                    echo $fnameerr;
                    echo $lnameerr;
                    echo $UsernameErr;
                    echo $UsernameErr1;
                    echo $Emailerr;
                    echo $NIDErr;
                    echo $NIDErr1;
                    echo $Phoneerr;
                    echo $Passworderr;
                    echo $Passworderr1;
                    echo $Passworderr2;
                    echo $Passworderr3;
                    // echo $genderErr;
                    echo $fileerr;
                    echo $fileerr1;
                    echo $imageerr;
                    echo $imageerr1;
                    echo $signuperr;

                    ?>

                    <br>
                    <br>

                    <input class="login"type="submit" name="submit" value="Register">
                </td>

                <td>
                    <br><br>
                    <a class="gobacklogin" href="../view/employelogin.php" name="return">Login</a>
                </td>

                <!-- <td>
                    <input type="submit" name="Login" value="Login">
                </td> -->
            </tr>

        </table>
    </form>

    <script src="../JS/ragistration.js"></script>
</body>

</html>