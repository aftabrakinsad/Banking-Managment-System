<?php
class db
{

function openConn()
{
$servername="localhost";
$username = "root";
$password = "";
$dbname = "bankinmanagmentsystemm";
$conn = new mysqli($servername,$username,$password,$dbname);
if($conn -> connect_error)
{
echo "error connecting database";


}
return $conn;
}

//  1

function employee_login($conn, $employeelogin, $username, $password)
{
$sqlstr = "SELECT username, password FROM employeelogin WHERE username = '$username' AND password = '$password'";
return $conn->query($sqlstr);
}

//  2

function retrive_employee($registrationofemployee, $conn)
{
$sqlstr = "SELECT id, fname, lname, Username, Email, NID, Phone, Password, cpassword,gender, picture, cv FROM $registrationofemployee";
return $conn-> query($sqlstr);
}

//  3

function insertapplicant($fname, $lname, $Username, $Email, $NID, $Phone, $Password, $cpassword,$gender,$picture, $cv, $registrationofemployee, $conn)
{
$sqlstr = "INSERT INTO registrationofemployee (fname, lname, Username, Email, NID, Phone, Password, cpassword,gender,picture, cv)
VALUES ('$fname', '$lname', '$Username', '$Email', '$NID', '$Phone', '$Password', '$cpassword','$gender', '$picture', '$cv')";
return $conn->query($sqlstr);
}

//  4

function CheckUser($username,$password,$table,$conn)
{
$result = $conn->query("SELECT * FROM ". $table." WHERE Username='". $username."' AND Password ='". $password."'");
return $result;
}

//  5

function displayUser($table,$conn)
{
$result = $conn->query("SELECT * FROM $table");
if ($result->num_rows>0) {
while($row = $result->fetch_assoc())
echo "id: ". $row["id"]."<br>"." First Name: ". $row["firstname"]."<br> "."username : ".
$row["username"]."<br>"."Password : ". $row["pass"];
}
else
echo "0 results";
}

//  6

function searchUserbyUsername($username,$table,$conn)
{
$result = "SELECT* FROM $table WHERE Username = '$username'";
return $conn->query($result);
}

//  7

function updateProfile($fname,$Username,$lname, $Phone ,$registrationofemployee, $conn)
{
    $sqlstr = "UPDATE $registrationofemployee SET fname='$fname',lname='$lname',phone ='$Phone' WHERE Username ='$Username' ";
    return $conn->query($sqlstr);
}
//  8

function view_query($headline, $news_details, $query_user, $conn)
{
    $sqlstr = "INSERT INTO $query_user (query_title, query_body, created) VALUES ('$headline', '$news_details', NOW())";
    return $conn->query($sqlstr);
}

//  9

function retrive_news($query_user, $conn)
{
    $sqlstr = "SELECT * FROM $query_user";
    return $conn->query($sqlstr);
}
// 10

function otp_code($Email, $code, $employeelogin, $conn)
{
    $sqlstr = "UPDATE $employeelogin SET code = '$code' WHERE Email = '$Email'";
    return $conn -> query($sqlstr);
}

// 11

function user_searching_by_email($Email, $employeelogin, $conn)
{
    $sqlstr = "SELECT * FROM $employeelogin WHERE email = '$Email'";
    return $conn -> query($sqlstr);
}

// 12

function otp_verification($code, $employeelogin, $conn)
{
    $sqlstr = "SELECT * FROM $employeelogin WHERE code = '$code'";
    return $conn -> query($sqlstr);
}

// 13
function change_password($newpassword, $Email, $code, $employeelogin, $conn)
{
    $sqlstr = "UPDATE $employeelogin SET password = '$newpassword', code = '$code' WHERE Email = '$Email'";
    return $conn -> query($sqlstr);
}


// 14

function otp_showing($Email, $employeelogin, $conn)
{
    $sqlstr = "SELECT code FROM $employeelogin WHERE Email = '$Email'";
    return $conn -> query($sqlstr);
}


// 15

function retrive_user_info($user, $conn)
{
    $sqlstr = "SELECT user_id, fname, lname, uname, email, nid, phone, accountno, picture FROM $user";
    return $conn-> query($sqlstr);
}

// 16

function search_by_User_accountno($accountno, $user, $conn)
{
    $sqlstr = "SELECT fname, lname, uname, email, nid, phone, accountno FROM $user WHERE accountno = '$accountno'";
    return $conn->query($sqlstr);
}

    //17
    function update_user($fname, $user, $accountno, $conn)
    {
        $sqlstr = "UPDATE $user SET fname='$fname' WHERE accountno='$accountno'";
        return $conn->query($sqlstr);
    }

//18
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
function balance_from_passbook($prebookfunds, $conn)
{
    $sqlstr = "SELECT balance FROM $prebookfunds ORDER BY trans_id DESC LIMIT 1";
    return $conn->query($sqlstr);
}
function datatwo($prebookfunds, $conn)
{
    $sqlstr = "SELECT balance FROM $prebookfunds balance";
    return $conn->query($sqlstr);
}
function datathree($accountno,$row5, $atm, $updated_sender_balance, $prebookfunds, $conn)
{
    $sqlstr = "INSERT INTO $prebookfunds VALUES(NULL, NOW(), 'Sent to: ".$row5["fname"]." ".$row5["lname"].", AC/No: ".$row5["accountno"].
"', '$atm', '0', '$updated_sender_balance', '$accountno')";
    return $conn->query($sqlstr);
}
function datafour($accountno,$row0, $atm, $updated_receiver_balance, $prebookfunds, $conn)
{
    $sqlstr = "INSERT INTO $prebookfunds VALUES(NULL, NOW(), 'Received from: ".$row0["fname"]." ".$row0["lname"].", AC/No: ".$row0
["accountno"]. "', '0', '$atm', '$updated_receiver_balance', '$accountno')";
    return $conn->query($sqlstr);
}

function search_employee_by_username($username, $employeelogin, $conn)
{
    $sqlstr = "SELECT * FROM $employeelogin WHERE username = '$username'";
    return $conn -> query($sqlstr);
}

function usernamereg_Ajex($username, $registrationofemployee, $conn)
{
    $sqlstr = "SELECT * FROM $registrationofemployee WHERE username = '$username'";
    return $conn -> query($sqlstr);
}

function Emailreg_Ajex($Email, $registrationofemployee, $conn)
{
    $sqlstr = "SELECT * FROM $registrationofemployee WHERE Email = '$Email'";
    return $conn -> query($sqlstr);
}

function Phonereg_Ajex($Email, $registrationofemployee, $conn)
{
    $sqlstr = "SELECT * FROM $registrationofemployee WHERE Email = '$Email'";
    return $conn -> query($sqlstr);
}

function NIDreg_Ajex($NID, $registrationofemployee, $conn)
{
    $sqlstr = "SELECT * FROM $registrationofemployee WHERE NID = '$NID'";
    return $conn -> query($sqlstr);
}

}

?>
