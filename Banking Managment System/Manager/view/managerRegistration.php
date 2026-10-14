<?php
// Public page: anyone can apply. The admin reviews every application.
session_start();
if (!empty($_SESSION["username"])) { header("Location: managerHomePage.php"); exit; }

$pageTitle = 'Apply as a manager';
@include("../view/public_top.php");
include("../control/managerprocess.php");

// The legacy validators also echo friendly confirmations ("Your email is ..."); show errors only.
function srv_error($msg) {
    $msg = trim((string)$msg);
    if ($msg === '' || preg_match('/^(Your |You selected|You have selected|Address Stored|Salary Added|Image uploaded|File uploaded|Age )/i', $msg) && !preg_match('/less than|not/i', $msg)) { return ''; }
    return '<p class="field-error">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</p>';
}
?>
<section class="card auth auth-wide wide">
    <h1>Apply for a manager account</h1>
    <p class="muted">Fill in your details below. The administrator reviews every application, and once approved you can sign in.</p>

    <?php if ($datasave === 'saved') { ?>
        <div class="alert alert-success" role="status">Application submitted. The administrator will review it; you can sign in after it is approved.</div>
    <?php } elseif ($datasave === 'failed') { ?>
        <div class="alert alert-error" role="alert">Your application could not be saved. The username, email or NID may already be registered, or a required field is missing.</div>
    <?php } ?>

    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <div class="form-grid">
            <h3 class="group">Personal details</h3>
            <div>
                <label>First name <input type="text" name="fname" id="fname" placeholder="Enter your first name" onkeyup="checkfirstname()"></label>
                <p id="ferror"></p><?php echo srv_error($nameErr); ?>
            </div>
            <div>
                <label>Last name <input type="text" name="lname" id="lname" placeholder="Enter your last name" onkeyup="checklastname()"></label>
                <p id="lerror"></p><?php echo srv_error($name2Err); ?>
            </div>
            <div>
                <label>Gender</label>
                <div class="radio-row">
                    <label><input type="radio" name="gender" id="male" value="male" onclick="getradiovalue()">Male</label>
                    <label><input type="radio" name="gender" id="female" value="female" onclick="getradiovalue()">Female</label>
                    <label><input type="radio" name="gender" id="others" value="others" onclick="getradiovalue()">Other</label>
                </div>
                <p id="radiovalue"></p><?php echo srv_error($genderErr); ?>
            </div>
            <div>
                <label>Date of birth <input type="date" name="dateofbirth" id="dateofbirth" onchange="agecheck()"></label>
                <p id="ageerror"></p><?php echo srv_error($dobErr); ?>
            </div>
            <div>
                <label>Father's name <input type="text" name="fathername" id="fathername" placeholder="Father's name" onkeyup="checkfathername()"></label>
                <p id="fathererror"></p><?php echo srv_error($fnameErr); ?>
            </div>
            <div>
                <label>Mother's name <input type="text" name="mothername" id="mothername" placeholder="Mother's name" onkeyup="checkmothername()"></label>
                <p id="mothererror"></p><?php echo srv_error($mnameErr); ?>
            </div>

            <h3 class="group">Account</h3>
            <div class="full">
                <label>Username <input type="text" name="uname" id="uname" placeholder="Choose a username" onchange="existuser()" onkeyup="checkusername()" autocomplete="username"></label>
                <p id="unameerror"></p><p id="ajaxresponse"></p><?php echo srv_error($unameErr); ?>
            </div>
            <div>
                <label>Password <input type="password" name="pass" id="pass" placeholder="Create a password" onkeyup="passcheck()" autocomplete="new-password"></label>
                <p id="passvalue"></p><?php echo srv_error($passErr); ?>
            </div>
            <div>
                <label>Confirm password <input type="password" name="cpass" id="cpass" placeholder="Enter it again" onkeyup="confirmpasscheck()" autocomplete="new-password"></label>
                <p id="cpassvalue"></p><?php echo srv_error($cpassErr); ?>
            </div>

            <h3 class="group">Contact and address</h3>
            <div>
                <label>Email <input type="text" name="email" id="email" placeholder="name@example.com" onchange="existemail()" onkeyup="validateemail()"></label>
                <p id="emailvalue"></p><p id="ajaxemail"></p><?php echo srv_error($emailErr); ?>
            </div>
            <div>
                <label>Phone <input type="text" name="phone" id="phone" placeholder="01XXXXXXXXX" onkeyup="phonecheck()"></label>
                <p id="phoneerr"></p><?php echo srv_error($phnErr); ?>
            </div>
            <div>
                <label>NID number <input type="text" name="nid" id="nid" placeholder="Your national ID" onchange="existnid()" onkeyup="nidcheck()"></label>
                <p id="niderr"></p><p id="ajaxnid"></p><?php echo srv_error($nidErr); ?>
            </div>
            <div>
                <label>Street / house no. <input type="text" name="street" id="street" placeholder="e.g. House 12, Road 5" onkeyup="addresscheck()"></label>
                <p id="adderror"></p><?php echo srv_error($preaddressErr); ?>
            </div>
            <div>
                <label>City
                    <select name="city">
                        <option value="DHAKA">Dhaka</option><option value="CHATTOGRAM">Chattogram</option><option value="KHULNA">Khulna</option>
                        <option value="SYLHET">Sylhet</option><option value="RAJSHAHI">Rajshahi</option><option value="NARAYANGANJ">Narayanganj</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Postal code
                    <select name="postal" id="postal">
                        <option value="1211">1211</option><option value="7899">7899</option><option value="2899">2899</option>
                        <option value="8002">8002</option><option value="1900">1900</option><option value="3399">3399</option>
                    </select>
                </label>
            </div>

            <h3 class="group">Employment and documents</h3>
            <div>
                <label>Expected joining date <input type="date" name="doj" id="doj" onchange="joiningcheck()"></label>
                <p id="joinerror"></p><?php echo srv_error($dojErr); ?>
            </div>
            <div>
                <label>Expected salary (৳) <input type="text" name="salary" id="salary" placeholder="e.g. 30000" onkeyup="checksalary()"></label>
                <p id="salerror"></p><?php echo srv_error($salaryErr); ?>
            </div>
            <div>
                <label>Curriculum vitae (PDF) <input type="file" name="cv" id="cv" onchange="fileValidation()"></label>
                <p id="fileerr"></p><?php echo srv_error($fileErr); ?>
            </div>
            <div>
                <label>Photo (JPG/PNG, within 300×300) <input type="file" name="img" id="img" onchange="imgValidation()"></label>
                <p id="imgerr"></p><?php echo srv_error($imgErr); ?>
            </div>
        </div>

        <div class="form-actions">
            <input type="submit" name="Submit" value="Submit application" class="button">
            <input type="reset" value="Clear form" class="button2 btn-ghost">
        </div>
    </form>
    <p class="small">Already approved? <a href="../view/managerlogin.php">Sign in</a></p>
    <script src="../js/registration.js"></script>
</section>
<?php @include("../view/footer.php"); ?>
