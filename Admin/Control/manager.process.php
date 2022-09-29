<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb ->retrive_applicant_info_for_manager("manager", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $id = $row['id'];
        $email = $row['email'];
        echo '<tr>
        <td>'.$row['id'].'</td>
        <td>'.$row['firstname'].'</td>
        <td>'.$row['lastname'].'</td>
        <td>'.$row['gender'].'</td>
        <td>'.$row['username'].'</td>
        <td>'.$row['email']. '</td>
        <td>' . $row['presentaddress'] . '</td>
        <td>' . $row['nid'] . '</td>
        <td>' . $row['phone'] . '</td>
        <td>' . $row['doj'] . '</td>
        <td>' . $row['salary'] . '</td>

        <td>
            <a class="accept" href="../View/managermanage.php?email='.$email.'">Update</a> <br><br><br>
            <a class="reject" href="../Control/applicantdelete.php?deleteid='.$id.'">Remove</a>
        </td>
        </tr>';
    }
}

?>