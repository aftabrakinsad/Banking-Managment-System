<?php
@include("../Control/updateuser.process.php");
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/adminmanage.css">
    <link rel="stylesheet" type="text/CSS" href="../CSS/adminrequest.css">
    <title>Admin Manage</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return accountno_addacc()">

        <div class="flex-container-form_header">
            <h1 id="form_header">Search User By account no . . .</h1>
        </div>
        <div>
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
        </div>
        <div class=container>
            <label>Account No. :</label><br>
            <p id="accountnoerr"></p>
            <input name="accountno" type="text" id="accountno" onkeyup="accountno_addacc()" placeholder="search here by account no">
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
                <p id="nameerr"></p>
                <input name="uname" id="uname" type="text" onkeyup="usernamecheck_admin()" value="<?php echo $uname; ?>">
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
                <a class="button" href="../View/usermanage.php">Go Back</a>
            </div>
        </div>

    </form>
    <script src="../JS/adduser.js"></script>
</body>

</html>