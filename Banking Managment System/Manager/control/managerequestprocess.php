<?php

session_start(); 

$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb -> displayUser("applicationofmanager",$myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $applicant_serial = $row['id'];
        $email = $row['email'];
        echo '<tr>
        <td>'.$row['firstname'].'</td>
        <td>'.$row['lastname'].'</td>
        <td>'.$row['gender'].'</td>
        <td>'.$row['age'].'</td>
        <td>'.$row['fathersname'].'</td>
        <td>'.$row['mothersname'].'</td>
        <td>'.$row['username'].'</td>
        <td>'.$row['pass'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['presentaddress'].'</td>
        <td>'.$row['nid'].'</td>
        <td>'.$row['phone'].'</td>

        <td><img src="../uploads/'.$row['imgpath']. '" width="100px" height="100px"></td>
        <td><a id="info" href="../uploads/'.$row['cvpath']. '">View</a></td>
        <td>'.$row['doj'].'</td>
        <td>
            <a class="accept" href="../control/newmanager.php?email='.$email.'">Accept</a> <br><br><br>
            <a class="reject" href="../Control/applicantdelete.php?deleteid='.$applicant_serial.'">Reject</a>
        </td>
        </tr>';
    }
}

?>