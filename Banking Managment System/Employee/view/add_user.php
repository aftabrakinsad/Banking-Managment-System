<?php
// @include("../view/header.php");
@include("../view/emp_navbar.php");
@include("../view/employeeinsidebar.php");
@include("../control/adduser.process.php");
?>


<!DOCTYPE html>
<html>
 
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/usermanage.css">
    <title> Manage</title>
</head>
 
<body>
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return checkusername()">
 
        <div class="flex-container-form_header">
            <h1 id="form_header">User Account </h1>
        </div>
        <div>
        </div>
        <div class=container>
            <label>Account No. :</label><br>
            <p id="usernameerr"></p>
            <input name="accountno" type="text" id="accountno" placeholder="search here by account no">
        </div>
 
        <div class="container">
            <div>
                <button type="submit" name="search">Search</button>
            </div>
        </div>
    </form>
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return form_check_admin_manage()">
        <div class="flex-container">
            <div class=container>
                <label>First Name :</label><br>
                <p id="fnameerr"></p>
                <input name="fname" id="fname" type="text" onkeyup="firstname_admin_manage()" value="<?php echo $fname; ?>">
            </div>
            <div class=container>
                <label>Last Name :</b></label><br>
                <p id="lnameerr"></p>
                <input name="lname" id="lname" type="text" onkeyup="lastname_admin_manage()" value="<?php echo $lname; ?>">
            </div>
            <div class=container>
                <label>Username :</label><br>
                <input name="uname" type="text" value="<?php echo $uname; ?>" readonly>
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Email-ID :</b></label><br>
                <p id="emailerr"></p>
                <input name="email" type="text" id="email" onkeyup="email_admin_manage()" value="<?php echo $email; ?>">
            </div>
            <div class=container>
                <label>NID :</label><br>
                <input name="nid" type="text" value="<?php echo $nid; ?>" readonly>
            </div>
            <div class=container>
                <label>Phone No. :</b></label><br>
                <p id="phoneerr"></p>
                <input name="phone" type="text" id="phone" onkeyup="phone_admin_manage()" value="<?php echo $phone; ?>">
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Account No. :</b></label><br>
                <input name="accountno" type="text" value="<?php echo $accountno; ?>" readonly>
            </div>
            <div>
                <input class="button" type="submit" name="submit" id="submit" value="update">
            </div>
        </div>
 
    </form>
    <script src="../JS/adminmanage.js"></script>
</body>
 
</html>