<?php

$errors = array();
$success = array();

@include("../Model/db.php");

$uppercase = $lowercase = $number = $specialchars = "";

session_start();

if(isset($_POST["submit"]))
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $nid = $_POST["nid"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $picture = $_FILES["picture"]["name"];
    $cv = $_FILES["cv"]["name"];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialchars = preg_match('@[^\W]@', $password);

    if (empty($fname) && empty($lname) && empty($uname) && empty($email) && empty($nid) && empty($phone) && empty($password) && empty($cpassword) && empty($_FILES["picture"]["tmp_name"]) && empty($_FILES["cv"]["tmp_name"]))
    {
        $errors['empty-fields'] = "You did not fill all the fields! ";
    }
    else if(empty($fname))
    {
        $errors['empty-fname'] = "Please Enter Your Firstname.";
    }
    else if(empty($lname))
    {
        $errors['empty-lname'] = "Please Enter Your Lastname.";
    }
    else if(empty($uname))
    {
        $errors['empty-uname'] = "Please Enter Your Username.";
    }
    else if (!empty($uname) && strlen($uname) <= 5)
    {
        $errors['uname-char'] = "Username must be more than 5 characters! ";
    }
    else if(empty($email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if(!empty($email) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        $errors['email-notvalid'] = "Please Enter Valid Email Address. ";
    }
    else if(empty($nid))
    {
        $errors['empty-nid'] = "Please Enter Valid National Identity Number. ";
    }
    else if(!empty($nid) && strlen($nid) != 8)
    {
        $errors['nid-digit'] = "NID should be 8 digits. ";
    }
    else if(empty($phone))
    {
        $errors['empty-phone'] = "Please Enter Valid Phone Number. ";
    }
    else if(!empty($phone) && !preg_match("/^\+?(88)?0?1[3456789][0-9]{8}\b/", $phone))
    {
        $errors['phone-invalidp'] = "Invalid Phone Number Pattern";
    }
    else if(empty($password))
    {
        $errors['empty-pass'] = "Enter Password! ";
    }
    else if(empty($cpassword))
    {
        $errors['empty-cpass'] = "Confirm Your Password ";
    }
    else if(!empty($password) && !empty($cpassword))
    {
        if(!$uppercase || !$lowercase || !$number || !$specialchars || strlen($password) <= 8)
        {
            $errors['pass-notvalid'] = "Password should be more than or equal to 8 characters and should include at least one uppercase, one lower case, one number and one special character! ";

        }
        else if($password != $cpassword)
        {
            $errors['pass-notmatched'] = "Password didn't match. ";
        }
    }

    if ($fname != "" && $lname != "" && $uname != "" && $email != "" && $nid != "" && $phone != "" && $password != "" && $cpassword != "") 
    {
        if(true)
        {
            $target_dir = "../uploads/profile_picture/";
            $target_dirr = "../uploads/applicant_cv/";

            $target_file = $target_dir . $_FILES["picture"]["name"];
            $target_filee = $target_dirr . $_FILES["cv"]["name"];

            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $FileType = strtolower(pathinfo($target_filee, PATHINFO_EXTENSION));

            if(empty($picture))
            {
                $errors['empty-img'] = "Please select your picture to upload. ";
                header("Location: ../View/adminregistration.php?Application_Submitted=Failed");
            }
            else if(empty($cv))
            {
                $errors['empty-cv'] = "Please select your cv to upload. ";
                header("Location: ../View/adminregistration.php?Application_Submitted=Failed");
            }
            else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
            {
                $errors['img-formrt'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                header("Location: ../View/adminregistration.php?Application_Submitted=Failed");
            }
            else if($FileType != "pdf")
            {
                $errors['img-formet'] = "Sorry, Only PDF files are allowed. ";
                header("Location: ../View/adminregistration.php?Application_Submitted=Failed");
            }
            else
            {
                if ((move_uploaded_file($_FILES["picture"]["tmp_name"], "../uploads/profile_picture/" . $_FILES["picture"]["name"])) 
                    && (move_uploaded_file($_FILES["cv"]["tmp_name"], "../uploads/applicant_cv/" . $_FILES["cv"]["name"])))
                {
                    $imgpath = "../uploads/profile_picture/" . $_FILES["picture"]["name"];
                    $filepath = "../uploads/applicant_cv/" . $_FILES["cv"]["name"];

                    $mydb = new db();
                    $myconn = $mydb->openConn();
                    $emailresult = $mydb -> searching_existing_email_registration($email, "applicantofadmin", $myconn);
                    $nidresult = $mydb -> seaching_exixting_nid_regisstration($nid, "applicantofadmin", $myconn);
                    $phoneresult = $mydb -> seaching_exixting_phone_regisstration($phone, "applicantofadmin", $myconn);

                    if($emailresult->num_rows > 0)
                    {
                        $errors['mail-exites'] = "This Email Already Existes";
                    }
                    else if($nidresult->num_rows > 0)
                    {
                        $errors['nid-exites'] = "This NID is Already Existes";
                    }
                    else if($phoneresult->num_rows > 0)
                    {
                        $errors['phone-exites'] = "This Phone Number is Already Existes";
                    }
                    else
                    {
                        $mydb = new db();
                        $myconn = $mydb->openConn();
                        $mydb->adding_emp_into_registrationofemployee($fname, $lname, $uname, $email, $nid, $phone, $password, $cpassword, $imgpath, $filepath, "addedemployee", $myconn);

                        $success['registration-done'] = "Successfully Added a employee";
                    }
                }
                else
                {
                    header("Location: ../View/add_emp.process.php?Employee_adding=Failed");
                }
            }

        }
    }
    else
    {
        $errors['registration-failed'] = "Adding Process failed. Please try again. ";
    }
}
