<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb -> retrive_selected_admin_info("details_table_for_selected_admins", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        $nid = $row['nid'];
        $email = $row['email'];
        echo '<tr>
            <td>' . $row['fname'] . '</td>
            <td>' . $row['lname'] . '</td>
            <td>' . $row['uname'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['nid'] . ' </td>
            <td>' . $row['phone'] . '</td>
            <td>' . $row['salary'] . '</td>
            <td>' . $row['accountno'] . '</td>
            <td>' . $row['Operations'] . '</td>

            <td>
                <a class="accept" href="../View/add_accountno.php?email='.$email.'&&nid='.$nid.'">Add Account No</a> <br><br><br>
                <a class="accept" href="../View/addsalary.php?email='.$email.'&&nid='.$nid. '">Add Salary</a>
                <a class="accept" href="../View/addpin.php?email='.$email.'&&nid='.$nid.'">Add PIN</a>
            </td>
        </tr>';
    }
}

?>