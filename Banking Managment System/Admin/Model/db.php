<?php

class db
{
    function openConn()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bankinmanagmentsystem";
        $conn =  new mysqli( $servername, $username, $password, $dbname);
        if ($conn->connect_error)
        {
            echo "error connecting database";
        }
        return $conn;
    }

    function loginadmin($conn, $staticadmin, $uname, $pass)
    {
        $sqlstr = "SELECT uname, pass FROM $staticadmin WHERE uname = '$uname' AND pass = '$pass'";
        return $conn -> query($sqlstr);
    }

    function insertapplicant($fname, $lname, $uname, $email, $nid, $phone, $password, $cpassword, $picture, $cv, $applicantofadmin, $conn)
    {
        $sqlstr = "INSERT INTO $applicantofadmin (fname, lname, uname, email, nid, phone, password, cpassword, picture, cv) VALUES ('$fname', '$lname', '$uname', '$email', '$nid', '$phone', '$password', '$cpassword', '$picture', '$cv')";
        return $conn->query($sqlstr);
    }

    function insertapplicant_for_backup($fname, $lname, $uname, $email, $nid, $phone, $password, $cpassword, $picture, $cv, $admin_back_up, $conn)
    {
        $sqlstr = "INSERT INTO $admin_back_up (fname, lname, uname, email, nid, phone, password, cpassword, picture, cv) VALUES ('$fname', '$lname', '$uname', '$email', '$nid', '$phone', '$password', '$cpassword', '$picture', '$cv')";
        return $conn->query($sqlstr);
    }

    function adding_emp_into_registrationofemployee($fname, $lname, $uname, $email, $nid, $phone, $password, $cpassword, $picture, $cv, $addedemployee, $conn)
     {
        $sqlstr = "INSERT INTO $addedemployee (fname, lname, uname, email, nid, phone, password, cpassword, picture, cv) VALUES ('$fname', '$lname', '$uname', '$email', '$nid', '$phone', '$password', '$cpassword', '$picture', '$cv')";
        return $conn->query($sqlstr);
    }

    function add_usser($fname, $lname, $uname, $email, $nid, $phone, $accountno, $pin, $password, $cpassword, $new_user, $conn)
    {
        $sqlstr = "INSERT INTO $new_user (fname, lname, uname, email, nid, phone, accountno, pin, password, cpassword) VALUES ('$fname', '$lname', '$uname', '$email', '$nid', '$phone', '$accountno', '$pin', '$password', '$cpassword')";
        return $conn->query($sqlstr);
    }

    function user_searching_by_email($email, $staticadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $staticadmin WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    function otp_code($email, $code, $staticadmin, $conn)
    {
        $sqlstr = "UPDATE $staticadmin SET code = '$code' WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    function otp_verification($code, $staticadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $staticadmin WHERE code = '$code'";
        return $conn -> query($sqlstr);
    }

    function otp_showing($email, $staticadmin, $conn)
    {
        $sqlstr = "SELECT code FROM $staticadmin WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    function accountno_showing($email, $admin_account_number, $conn)
    {
        $sqlstr = "SELECT accountno FROM $admin_account_number WHERE email = '$email'";
        return $conn->query($sqlstr);
    }

    function change_password($newpassword, $email, $code, $staticadmin, $conn)
    {
        $sqlstr = "UPDATE $staticadmin SET pass = '$newpassword', code = '$code' WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    #Used in Admin Request (Control)
    function retrive_applicant_info_for_admin($applicantofadmin, $conn)
    {
        $sqlstr = "SELECT applicant_serial, fname, lname, uname, email, nid, phone, password, picture, cv FROM $applicantofadmin";
        return $conn -> query($sqlstr);
    }

    function retrive_applicant_info_for_manager($manager, $conn)
    {
        $sqlstr = "SELECT id, firstname, lastname, gender, age, username, email, presentaddress, nid, phone, doj, salary, cvpath, imgpath FROM $manager";
        return $conn->query($sqlstr);
    }

    function retrive_user_info_newuser_table($new_user, $conn)
    {
        $sqlstr = "SELECT user_id, fname, lname, uname, email, nid, phone, accountno, pin FROM $new_user";
        return $conn->query($sqlstr);
    }

    function retrive_user_info($user, $conn)
    {
        $sqlstr = "SELECT user_id, fname, lname, uname, email, nid, phone, accountno, picture FROM $user";
        return $conn-> query($sqlstr);
    }

    function retrive_data_from_emp($addedemployee, $conn)
    {
        $sqlstr = "SELECT id, fname, lname, uname, email, nid, phone, picture FROM $addedemployee";
        return $conn->query($sqlstr);
    }

    function retriving_transation_history($passbook, $conn)
    {
        $sqlstr = "SELECT * FROM $passbook";
        return $conn->query($sqlstr);
    }

    #used in Add Salary & Account (Control)
    function retrive_selected_admin_info($details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT fname, lname, uname, email, nid, phone, salary, accountno FROM $details_table_for_selected_admins";
        return $conn -> query($sqlstr);
    }

    function display_admin_info_on_admin_manage_page($admin_id, $uname, $staticadmin, $conn)
    {
        $sqlstr = "SELECT admin_id, uname, FROM $staticadmin";
        return $conn -> query($sqlstr);
    }

    #Used in New Admin (Control)
    function email_checking($email, $staticadmin, $conn)
    {
        $sqlstr = "SELECT email FROM $staticadmin WHERE email = '$email'";
        return $conn -> query($sqlstr);
    }

    #Used in New Admin (Control)
    function adding_new_admin($email, $staticadmin, $applicantofadmin, $conn)
    {
        $sqlstr = "INSERT INTO $staticadmin (uname, pass, email) SELECT uname, password, email FROM $applicantofadmin WHERE email= '$email'";
        return $conn->query($sqlstr);
    }

    function adding_new_adminII($email, $details_table_for_selected_admins, $applicantofadmin, $conn)
    {
        $sqlstr = "INSERT INTO $details_table_for_selected_admins (fname, lname, uname, email, nid, phone) SELECT fname, lname, uname, email,nid, phone FROM $applicantofadmin WHERE email = '$email'";
        return $conn->query($sqlstr);
    }

    function adding_new_admin_accountno_info($email, $admin_account_number, $applicantofadmin, $conn)
    {
        $sqlstr = "INSERT INTO $admin_account_number (uname, email, nid) SELECT uname, email, nid FROM $applicantofadmin WHERE email = '$email'";
        return $conn->query($sqlstr);
    }

    function deleting_after_selecting($email,$applicantofadmin, $conn)
    {
        $sqlstr = "DELETE FROM $applicantofadmin WHERE email='$email'";
        return $conn->query($sqlstr);
    }

    #Used in Delete Admin (Control)
    function deleting_new_admin($applicant_serial, $applicantofadmin, $conn)
    {
        $sqlstr = "DELETE FROM $applicantofadmin WHERE applicant_serial = '$applicant_serial'";
        return $conn->query($sqlstr);
    }

    function deleting_new_emp($id, $registrationofemployee, $conn)
    {
        $sqlstr = "DELETE FROM $registrationofemployee WHERE id = '$id'";
        return $conn->query($sqlstr);
    }

    function deleting_added_user($user_id, $new_user, $conn)
    {
        $sqlstr = "DELETE FROM $new_user WHERE user_id = '$user_id'";
        return $conn->query($sqlstr);
    }

    #search Admin by email in Forget Password Page - (Control - AJAX)
    function searching_existing_email($email, $staticadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $staticadmin WHERE email ='$email'";
        return $conn -> query($sqlstr);
    }

    #search User by email in Admin Registration Page - (Control & AJAX)
    function searching_existing_email_registration($email, $applicantofadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $applicantofadmin WHERE email ='$email'";
        return $conn->query($sqlstr);
    }

    #search User by nid in Admin Registration Page - (Control & AJAX)
    function seaching_exixting_nid_regisstration($nid, $applicantofadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $applicantofadmin WHERE nid = '$nid'";
        return $conn -> query($sqlstr);
    }

    #search User by phone in Admin Registration Page - (Control & AJAX)
    function seaching_exixting_phone_regisstration($phone, $applicantofadmin, $conn)
    {
        $sqlstr = "SELECT * FROM $applicantofadmin WHERE phone = '$phone'";
        return $conn->query($sqlstr);
    }

    #Used in Add Salary (Control)
    function adding_salary_to_selected_admins($email, $nid, $salary, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "UPDATE $details_table_for_selected_admins SET salary = '$salary' WHERE email = '$email' AND nid='$nid'";
        return $conn->query($sqlstr);
    }

    function adding_pin_to_selected_admins($email, $nid, $pin, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "UPDATE $details_table_for_selected_admins SET pin ='$pin' WHERE email = '$email' AND nid='$nid'";
        return $conn->query($sqlstr);
    }

    #Used in Add Salary (Control)
    function searching_existing_email_in_details_table_for_selected_admins($email, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE email ='$email'";
        return $conn->query($sqlstr);
    }

    #Used in Add Salary (Control)
    function searching_existing_nid_in_details_table_for_selected_admins($nid, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE nid ='$nid'";
        return $conn->query($sqlstr);
    }

    function showing_data_from_admin_salary_control_to_add_salary($email, $nid, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT email, nid FROM $details_table_for_selected_admins WHERE email ='$email' AND nid = '$nid'";
        return $conn->query($sqlstr);
    }

    #Used in Add Account No (Control)
    function genetaring_account_number($email, $nid, $accountno, $admin_account_number, $conn)
    {
        $sqlstr = "UPDATE $admin_account_number SET accountno = '$accountno' WHERE email = '$email' AND nid='$nid'";
        return $conn -> query($sqlstr);
    }

    function adding_new_admin_accountno($email, $nid, $accountno, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "UPDATE $details_table_for_selected_admins SET accountno = '$accountno' WHERE email = '$email' AND nid='$nid'";
        return $conn->query($sqlstr);
    }

    function adding_new_admin_accountno_to_staticadmin($email, $accountno, $staticadmin, $conn)
    {
        $sqlstr = "UPDATE $staticadmin SET accountno = '$accountno' WHERE email = '$email'";
        return $conn->query($sqlstr);
    }

    #search Admin by Username in admin Login Page - (Control -AJAX)
    function search_admin_by_username($uname, $staticadmin, 
    $conn)
    {
        $sqlstr = "SELECT * FROM $staticadmin WHERE uname = '$uname'";
        return $conn -> query($sqlstr);
    }

    #Used in Admin Manage (Control)
    function search_by_User_name($username, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT fname, lname, uname, email, nid, phone,salary, accountno FROM $details_table_for_selected_admins WHERE uname = '$username'";
        return $conn->query($sqlstr);
    }

    function search_by_nid($nid, $manager, $conn)
    {
        $sqlstr = "SELECT firstname, lastname, username, email, nid,phone,salary, presentaddress FROM $manager WHERE nid = '$nid'";
        return $conn->query($sqlstr);
    }

    function search_by_User_accountno($accountno, $user, $conn)
    {
        $sqlstr = "SELECT fname, lname, uname, email, nid, phone, accountno FROM $user WHERE accountno = '$accountno'";
        return $conn->query($sqlstr);
    }

    function updateProfile($fname, $lname, $uname, $email, $nid, $phone, $salary, $accountno, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "UPDATE $details_table_for_selected_admins SET fname='$fname', lname='$lname', email='$email', nid='$nid', phone='$phone',salary='$salary', accountno='$accountno' WHERE uname ='$uname' ";
        return $conn->query($sqlstr);
    }

    function update_user($fname, $lname, $uname, $email, $phone ,$accountno, $user, $conn)
    {
        $sqlstr = "UPDATE $user SET fname='$fname', lname='$lname', uname='$uname', email='$email', phone='$phone' WHERE accountno ='$accountno' ";
        return $conn->query($sqlstr);
    }

    function updateProfilemanager($firstname, $lastname, $username, $email, $nid, $phone, $salary, $presentaddress, $manager, $conn)
    {
        $sqlstr = "UPDATE $manager SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', phone='$phone', salary='$salary', presentaddress='$presentaddress' WHERE nid ='$nid'";
        return $conn->query($sqlstr);
    }

    function updateProfileI($uname, $email,$admin_account_number, $conn)
    {
        $sqlstr = "UPDATE $admin_account_number SET email='$email' WHERE uname ='$uname' ";
        return $conn->query($sqlstr);
    }

    function updateProfileII($uname, $email, $staticadmin, $conn)
    {
        $sqlstr = "UPDATE $staticadmin SET email='$email' WHERE uname ='$uname' ";
        return $conn->query($sqlstr);
    }

    function retrive_from_details_table_for_selected_admins($details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins";
        return $conn->query($sqlstr);
    }

    function post_news($headline, $news_details, $news, $conn)
    {
        $sqlstr = "INSERT INTO $news (tittle, news_body, created) VALUES ('$headline', '$news_details', NOW())";
        return $conn->query($sqlstr);
    }

    function retrive_news($news, $conn)
    {
        $sqlstr = "SELECT * FROM $news";
        return $conn->query($sqlstr);
    }

    function username_exixts($uname, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE uname='$uname'";
        return $conn->query($sqlstr);
    }

    function retreving_balance_from_passbook($passbook, $conn)
    {
        $sqlstr = "SELECT balance FROM $passbook ORDER BY trans_id DESC LIMIT 1";
        return $conn->query($sqlstr);
    }

    function retriving_accountno_pin_from_details_table_for_selected_admins($accountno, $pin, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE accountno='$accountno' AND pin = '$pin'";
        return $conn->query($sqlstr);
    }

    function inserting_passbook_credit($accountno, $atm, $final_balance, $passbook, $conn)
    {
        $sqlstr = "INSERT INTO $passbook VALUES(NULL, NOW(), 'Cash Deposit', '0', '$atm', '$final_balance', '$accountno,')";
        return $conn->query($sqlstr);
    }

    function inserting_passbook_debit($accountno,$atm, $final_balance,$passbook, $conn)
    {
        $sqlstr = "INSERT INTO $passbook VALUES(NULL, NOW(), 'Cash to Self', '$atm', '0', '$final_balance','$accountno')";
        return $conn->query($sqlstr);
    }

    function retrive_data_from($pin, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE pin = '$pin'";
        return $conn->query($sqlstr);
    }

    function dataone($accountno, $details_table_for_selected_admins, $conn)
    {
        $sqlstr = "SELECT * FROM $details_table_for_selected_admins WHERE accountno= '$accountno'";
        return $conn->query($sqlstr);
    }

    function balance_from_passbook($passbook, $conn)
    {
        $sqlstr = "SELECT balance FROM $passbook ORDER BY trans_id DESC LIMIT 1";
        return $conn->query($sqlstr);
    }

    function datatwo($passbook, $conn)
    {
        $sqlstr = "SELECT balance FROM $passbook balance";
        return $conn->query($sqlstr);
    }

    function datathree($accountno,$row5, $atm, $updated_sender_balance, $passbook, $conn)
    {
        $sqlstr = "INSERT INTO $passbook VALUES(NULL, NOW(), 'Sent to: ".$row5["fname"]." ".$row5["lname"].", AC/No: ".$row5["accountno"]."', '$atm', '0', '$updated_sender_balance', '$accountno')";
        return $conn->query($sqlstr);
    }

    function datafour($accountno,$row0, $atm, $updated_receiver_balance, $passbook, $conn)
    {
        $sqlstr = "INSERT INTO $passbook VALUES(NULL, NOW(), 'Received from: ".$row0["fname"]." ".$row0["lname"].", AC/No: ".$row0["accountno"]. "', '0', '$atm', '$updated_receiver_balance', '$accountno')";
        return $conn->query($sqlstr);
    }

    function displaynews($table,$conn)
    {
        $sqlstr = "SELECT * FROM $table ";
        return $conn->query($sqlstr);
    }

}

#total 64 functions

?>