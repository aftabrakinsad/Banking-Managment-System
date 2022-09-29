<?php

session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}
@include("../view/header.php");
@include("../view/navbar.php");
@include("../view/sidebar.php");
@include("../view/profileprocess.php")

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_profile.css">
    <title>Profile</title>
</head>

<body>
    <form class="add_customer_form" action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <div class="flex-container-form_header">
            <!-- <h1 id="form_header">____Account Details___</h1> -->
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Name : <label id="info_label"><?php echo $name; ?></label></label>
            </div>
            <!-- <div class=container>
                <label>Username : <label id="info_labe2"></label><?php echo $username; ?></</label>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Email: <label id="info_labe3"></label><?php echo $email; ?></</label>
            </div> -->
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Salary (TAKA) : <label id="info_labe4"></label><?php echo $salary; ?></</label>
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Fund (TAKA) : <label id="info_labe4"></label><?php echo $fund; ?></</label>
            </div>
        </div>
       
        <div class="flex-container">
            <div class=container>
                <label>Date of Join : <label id="info_labe5"></label><?php echo $dateofjoin; ?></</label>
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Phone Number: <label id="info_label"></label><?php echo $phone; ?></label>
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Account No: <label id="info_label"></label><?php echo $accountno; ?></label>
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Account Status: <label id="info_label"></label><?php echo $status; ?></label>
            </div>
        </div>
        
       
        <div class="flex-container">
            <div class=container>
                <label>Email-ID :</label><br>
                <input name="email" id="email" size="30" type="text" value="<?php echo $email; ?>" onkeyup="validateemail()" onchange="existemail()"/><p id="emailvalue" > </p><p id="ajaxemail"></p>
            </div>
            </div>
            <div class="flex-container">
            <div class=container>
                <label>Username :</label><br>
                <input name="username" id ="uname"size="30" type="text" value="<?php echo $username; ?>" onkeyup="checkusername()" onchange="existuser()"/><p id="unameerror" > </p> <p id="ajaxresponse"></p>
            </div>
        </div>

       

        
        <div class="flex-container">
            <div class="container">
                <a href="../view/managerHomePage.php" class="button">Back To Work</a>
            </div>
            <div class="container">
            <input type="submit" name="submit" value="Update" class="button">
            </div>
        </div>

    </form>
    <script src="../js/profile.js"></script>
</body>

</html>