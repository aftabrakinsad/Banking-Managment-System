<?php

@include("../model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb -> retrive_employee("registrationofemployee", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $id = $row['id'];
        echo '<tr>

        <td>'.$row['id'].'</td>
        <td>'.$row['fname'].'</td>
        <td>'.$row['lname'].'</td>
        <td>'.$row['Username'].'</td>
        <td>'.$row['Email'].'</td>
        <td>'.$row['NID'].'</td>
        <td>'.$row['Phone'].'</td>
        <td>'.$row['Password'].'</td>
        <td>'.$row['cpassword'].'</td>
        <td><img src="../uploads/'.$row['picture']. '" width="100px" height="100px"></td>
        <td><a id="info" href="../uploads/'.$row['cv']. '">View</a></td>
        </tr>';
    }
}


?>