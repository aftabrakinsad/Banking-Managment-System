<?php
// Public page: anyone can apply. The admin reviews every application.
session_start();
if (isset($_SESSION['username'])) { header("location: ../view/epage1.php"); exit; }

include('../control/Employeeregistration.php');
$pageTitle = 'Apply as an employee';
@include("../view/public_top.php");

$errors = array_filter([$fnameerr, $lnameerr, $UsernameErr, $UsernameErr1, $Emailerr, $NIDErr, $NIDErr1, $Phoneerr,
    $Passworderr, $Passworderr1, $Passworderr2, $Passworderr3, $fileerr, $fileerr1, $imageerr, $imageerr1, $signuperr],
    function ($e) { return trim((string)$e) !== ''; });
?>
<section class="card auth auth-wide wide">
    <h1>Apply for an employee account</h1>
    <p class="muted">Fill in your details below. The administrator reviews every application, and once approved you can sign in.</p>

    <?php if ($registered) { ?>
        <div class="alert alert-success" role="status">Application submitted. The administrator will review it; you can sign in after it is approved.</div>
    <?php } ?>
    <?php foreach ($errors as $e) { ?>
        <div class="alert alert-error" role="alert"><?php echo htmlspecialchars(trim($e), ENT_QUOTES, 'UTF-8'); ?></div>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <div class="form-grid">
            <h3 class="group">Personal details</h3>
            <div>
                <label>First name <input type="text" name="fname" placeholder="First name" id="fname" onkeyup="checkfname()"></label>
                <p id="nameerror"></p>
            </div>
            <div>
                <label>Last name <input type="text" name="lname" placeholder="Last name" id="lname" onkeyup="checklname()"></label>
                <p id="lnameerror"></p>
            </div>
            <div class="full">
                <label>Gender</label>
                <div class="radio-row">
                    <label><input type="radio" name="gender" value="male">Male</label>
                    <label><input type="radio" name="gender" value="female">Female</label>
                    <label><input type="radio" name="gender" value="others">Other</label>
                </div>
            </div>

            <h3 class="group">Account</h3>
            <div>
                <label>Username <input type="text" name="uname" placeholder="Choose a username" id="Username" onchange="uname_AJAX()" onkeyup="checkuname()" autocomplete="username"></label>
                <p id="usernameerr"></p><p id="unameajaxresponse"></p>
            </div>
            <div>
                <label>Email <input type="text" name="email" placeholder="name@example.com" id="Email" onchange="Email_AJAX()" onkeyup="validateemail()"></label>
                <p id="emailvalue"></p><p id="Emailajaxresponse"></p>
            </div>
            <div>
                <label>Password <input type="password" name="password" placeholder="Create a password" id="Password" onkeyup="checkpassword()" autocomplete="new-password"></label>
                <p id="passworderr"></p>
            </div>
            <div>
                <label>Confirm password <input type="password" name="cpassword" placeholder="Enter it again" id="CPassword" onkeyup="checkconfirmpassword()" autocomplete="new-password"></label>
                <p id="Cpassworderr"></p>
            </div>

            <h3 class="group">Identity and contact</h3>
            <div>
                <label>NID number <input type="text" name="nid" placeholder="Your national ID" id="NID" onchange="NID_Ajex()" onkeyup="checknid()"></label>
                <p id="NIDerr"></p><p id="NIDajaxresponse"></p>
            </div>
            <div>
                <label>Phone <input type="text" name="Phone" placeholder="+880-1XXXXXXXXX" id="Phone" onchange="Phone_AJAX()" onkeyup="checkphone()"></label>
                <p id="phoneerrjs"></p><p id="Phoneajaxresponse"></p>
            </div>

            <h3 class="group">Documents</h3>
            <div>
                <label>Photo (JPG, PNG or GIF) <input type="file" name="picture" accept="image/jpeg,image/png,image/gif"></label>
            </div>
            <div>
                <label>Curriculum vitae (PDF) <input type="file" name="cv" accept="application/pdf"></label>
            </div>
        </div>

        <div class="form-actions">
            <input class="login" type="submit" name="submit" value="Submit application">
        </div>
    </form>
    <p class="small">Already approved? <a href="../view/employelogin.php">Sign in</a></p>
    <script src="../JS/ragistration.js"></script>
</section>
<?php @include("../view/footer.php"); ?>
