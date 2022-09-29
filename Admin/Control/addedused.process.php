<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb -> retrive_user_info_newuser_table("new_user", $myconn);

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
        <td>'.$row['phone']. '</td>
        <td>' . $row['accountno'] . '</td>
        <td>' . $row['pin'] . '</td>

        <td>
            <a class="reject" href="../Control/userdelete.php?deleteid='. $user_id.'">Delete User</a>
        </td>
        </tr>';
    }
}

?>