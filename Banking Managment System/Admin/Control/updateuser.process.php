<?php

@include("../Model/db.php");

$fname = "";
$lname = "";
$uname = "";
$email = "";
$nid = "";
$phone = "";
$salary = "";
$accountno = "";
$picture = "";
$errors = array();
$success = array();

// Allow deep links from the user list: updateuser.php?accountno=1234567
if (isset($_GET["accountno"]) && !isset($_POST["search"]) && !isset($_POST["submit"]))
{
    $_POST["search"] = true;
    $_POST["accountno"] = $_GET["accountno"];
}

if (isset($_POST["search"]))
{
    $accountno = $_POST["accountno"];

    if (empty($accountno))
    {
        $errors['empty-username'] =  "Please enter account no";
    }
    else if (!empty($accountno) && !preg_match("/^[0-9]{7}$/", $accountno))
    {
        $errors['uname-char'] = "account no must be equal 7 digits!";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $result = $mydb->search_by_User_accountno($accountno, "user", $myconn);

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $fname = $row["fname"];
                $lname = $row["lname"];
                $uname = $row["uname"];
                $email = $row["email"];
                $nid = $row["nid"];
                $phone = $row["phone"];
                $accountno = $row["accountno"];
                $picture = $row["picture"];
            }
        }
        else
        {
            $errors['username-nofound'] = "Account No. not found";
        }
    }
}

if(isset($_POST["submit"]))
{  
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    if(empty($fname))
    {
        $errors['empty-firstname'] = "First name can' be empty";
    }
    else if(empty($lname))
    {
        $errors['empty-lastname'] = "Last name can' be empty";
    } 
    else if (empty($phone))
    {
        $errors['empty-phone'] = "Please Enter Valid Phone Number. ";
    }
    else if((!empty($phone)) && !preg_match("/^\+?(88)?0?1[3456789][0-9]{8}\b/", $phone))
    {
        $errors['phone-notvalid'] = "Phone number must contain country code. Ex. +880";
    } 
    else if (empty($email)) 
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if (!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else
    {
        $mydb = new db();
        $myconn = $mydb->openConn();

        // Optional new profile picture
        $newpic = "";
        if (!empty($_FILES["picture"]["name"]))
        {
            $f = $_FILES["picture"];
            $info = ($f["error"] === UPLOAD_ERR_OK) ? @getimagesize($f["tmp_name"]) : false;
            $allowed = array(IMAGETYPE_JPEG => "jpg", IMAGETYPE_PNG => "png", IMAGETYPE_WEBP => "webp");
            if ($f["error"] !== UPLOAD_ERR_OK || !$info || !isset($allowed[$info[2]]))
            {
                $errors['picture-invalid'] = "Picture must be a JPG, PNG or WEBP image.";
            }
            else if ($f["size"] > 2 * 1024 * 1024)
            {
                $errors['picture-size'] = "Picture must be 2 MB or smaller.";
            }
            else
            {
                $dir = __DIR__ . "/../uploads/user_picture";
                if (!is_dir($dir)) { mkdir($dir, 0775, true); }
                $newpic = "user_picture/" . bin2hex(random_bytes(8)) . "." . $allowed[$info[2]];
                if (!move_uploaded_file($f["tmp_name"], __DIR__ . "/../uploads/" . $newpic))
                {
                    $errors['picture-save'] = "Could not save the picture.";
                    $newpic = "";
                }
            }
        }
    }
    if (count($errors) == 0)
    {
        $mydb = new db();
        $myconn = $mydb->openConn();
        $resulta = $mydb->update_user($_POST["fname"], $_POST["lname"] , $_POST["uname"], $_POST["email"], $_POST["phone"], $_POST["accountno"], "user",$myconn);

        if($resulta == true)
        {
            if ($newpic !== "") { $mydb->update_user_picture($_POST["accountno"], $newpic, $myconn); }
            $again = $mydb->search_by_User_accountno($_POST["accountno"], "user", $myconn);
            if ($again && ($r2 = $again->fetch_assoc())) { $picture = $r2["picture"]; $accountno = $r2["accountno"]; $uname = $r2["uname"]; $nid = $r2["nid"]; }
            $success['ok']= "Sucessfully Updated";
        }
        else
        {
            $errors['update-failed'] = "Update Failed". $myconn->error;
        }
    }
}