<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb -> retrive_user_info("user", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $user_id = $row['user_id'];
        $email = $row['email'];
        echo '<tr>
        <td>'.$row['user_id'].'</td>
        <td>'.$row['fname'].'</td>
        <td>'.$row['lname'].'</td>
        <td>'.$row['uname'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['nid'].'</td>
        <td>'.$row['phone'].'</td>
        <td>'.$row['accountno'].'</td>


        <td><img src="../uploads/'.htmlspecialchars($row['picture']).'" width="100" height="100" alt="" onerror="this.style.display=\'none\'"></td>
        <td>
            <a class="accept" href="../View/updateuser.php?accountno='.urlencode($row['accountno']).'">Update</a> <br><br><br>
            <a class="reject" href="../Control/applicantdelete.php?deleteid='. $user_id.'">Remove</a>
        </td>
        </tr>';
    }
}

?>