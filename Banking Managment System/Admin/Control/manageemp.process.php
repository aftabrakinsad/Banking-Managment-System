<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb -> retrive_data_from_emp("addedemployee", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $id = $row['id'];
        $email = $row['email'];
        echo '<tr>
        <td>'.$row['id'].'</td>
        <td>'.$row['fname'].'</td>
        <td>'.$row['lname'].'</td>
        <td>'.$row['uname'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['nid'].'</td>
        <td>'.$row['phone'].'</td>

        <td><img src="../uploads/'.$row['picture']. '" width="100px" height="100px"></td>
        <td>
            <a class="reject" href="../Control/empdelete.php?deleteid='.$id.'">Delete Employee</a>
        </td>
        </tr>';
    }
}

?>