<?php
// Public page: anyone can apply. The admin reviews every application.
session_start();
if (!empty($_SESSION["username"])) { header("Location: managerHomePage.php"); exit; }

include("../control/apply.process.php");
$pageTitle = 'Apply as a manager';
@include("../view/public_top.php");
?>
<section class="card auth auth-wide wide">
    <h1>Apply for a manager account</h1>
    <p class="muted">Fill in your details below. The administrator reviews every application, and once approved you can sign in.</p>

    <?php if ($applied) { ?>
        <div class="alert alert-success" role="status">Application submitted. The administrator will review it; you can sign in after it is approved.</div>
    <?php } ?>
    <?php foreach ($appErrors as $e) { ?><div class="alert alert-error" role="alert"><?php echo h($e); ?></div><?php } ?>

    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
        <?php echo csrf_field(); ?>
        <div class="form-grid">
            <h3 class="group">Personal details</h3>
            <div>
                <label>First name <input type="text" name="fname" id="fname" value="<?php echo h($v['fname']); ?>" placeholder="Enter your first name" onkeyup="checkfirstname()"></label>
                <p id="ferror"></p>
            </div>
            <div>
                <label>Last name <input type="text" name="lname" id="lname" value="<?php echo h($v['lname']); ?>" placeholder="Enter your last name" onkeyup="checklastname()"></label>
                <p id="lerror"></p>
            </div>
            <div>
                <label>Gender</label>
                <div class="radio-row">
                    <?php foreach (['male' => 'Male', 'female' => 'Female', 'others' => 'Other'] as $k => $l) { ?>
                        <label><input type="radio" name="gender" id="<?php echo $k; ?>" value="<?php echo $k; ?>" onclick="getradiovalue()"<?php echo $v['gender'] === $k ? ' checked' : ''; ?>><?php echo $l; ?></label>
                    <?php } ?>
                </div>
                <p id="radiovalue"></p>
            </div>
            <div>
                <label>Date of birth <input type="date" name="dateofbirth" id="dateofbirth" value="<?php echo h($v['dob']); ?>" onchange="agecheck()"></label>
                <p id="ageerror"></p>
            </div>
            <div>
                <label>Father's name <input type="text" name="fathername" id="fathername" value="<?php echo h($v['fathername']); ?>" placeholder="Father's name" onkeyup="checkfathername()"></label>
                <p id="fathererror"></p>
            </div>
            <div>
                <label>Mother's name <input type="text" name="mothername" id="mothername" value="<?php echo h($v['mothername']); ?>" placeholder="Mother's name" onkeyup="checkmothername()"></label>
                <p id="mothererror"></p>
            </div>

            <h3 class="group">Account</h3>
            <div class="full">
                <label>Username <input type="text" name="uname" id="uname" value="<?php echo h($v['uname']); ?>" placeholder="Choose a username" onchange="existuser()" onkeyup="checkusername()" autocomplete="username"></label>
                <p id="unameerror"></p><p id="ajaxresponse"></p>
            </div>
            <div>
                <label>Password <input type="password" name="pass" id="pass" placeholder="Create a password" onkeyup="passcheck()" autocomplete="new-password"></label>
                <p id="passvalue"></p>
            </div>
            <div>
                <label>Confirm password <input type="password" name="cpass" id="cpass" placeholder="Enter it again" onkeyup="confirmpasscheck()" autocomplete="new-password"></label>
                <p id="cpassvalue"></p>
            </div>

            <h3 class="group">Contact and address</h3>
            <div>
                <label>Email <input type="text" name="email" id="email" value="<?php echo h($v['email']); ?>" placeholder="name@example.com" onchange="existemail()" onkeyup="validateemail()"></label>
                <p id="emailvalue"></p><p id="ajaxemail"></p>
            </div>
            <div>
                <label>Phone <input type="text" name="phone" id="phone" value="<?php echo h($v['phone']); ?>" placeholder="01XXXXXXXXX" onkeyup="phonecheck()"></label>
                <p id="phoneerr"></p>
            </div>
            <div>
                <label>NID number <input type="text" name="nid" id="nid" value="<?php echo h($v['nid']); ?>" placeholder="Your national ID" onchange="existnid()" onkeyup="nidcheck()"></label>
                <p id="niderr"></p><p id="ajaxnid"></p>
            </div>
            <div>
                <label>Street / house no. <input type="text" name="street" id="street" value="<?php echo h($v['street']); ?>" placeholder="e.g. House 12, Road 5" onkeyup="addresscheck()"></label>
                <p id="adderror"></p>
            </div>
            <div>
                <label>City
                    <select name="city">
                        <?php foreach ($cities as $c) { ?><option value="<?php echo h($c); ?>"<?php echo $v['city'] === $c ? ' selected' : ''; ?>><?php echo h(ucfirst(strtolower($c))); ?></option><?php } ?>
                    </select>
                </label>
            </div>
            <div>
                <label>Postal code
                    <select name="postal" id="postal">
                        <?php foreach ($postals as $p) { ?><option value="<?php echo h($p); ?>"<?php echo $v['postal'] === $p ? ' selected' : ''; ?>><?php echo h($p); ?></option><?php } ?>
                    </select>
                </label>
            </div>

            <h3 class="group">Employment and documents</h3>
            <div>
                <label>Expected joining date <input type="date" name="doj" id="doj" value="<?php echo h($v['doj']); ?>" onchange="joiningcheck()"></label>
                <p id="joinerror"></p>
            </div>
            <div>
                <label>Expected salary (৳) <input type="text" name="salary" id="salary" value="<?php echo h($v['salary']); ?>" placeholder="e.g. 30000" onkeyup="checksalary()"></label>
                <p id="salerror"></p>
            </div>
            <div>
                <label>Curriculum vitae (PDF, up to 5 MB) <input type="file" name="cv" id="cv" accept="application/pdf" onchange="fileValidation()"></label>
                <p id="fileerr"></p>
            </div>
            <div>
                <label>Photo (JPG, PNG or GIF, up to 2 MB) <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/gif" onchange="imgValidation()"></label>
                <p id="imgerr"></p>
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
