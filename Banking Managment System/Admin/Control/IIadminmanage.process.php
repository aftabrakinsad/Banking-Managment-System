<?php

@include("../Model/db.php");

    $mydb = new db();
    $myconn = $mydb->openConn();
    $resultXD = $mydb->retrive_from_details_table_for_selected_admins("details_table_for_selected_admins", $myconn);

    if ($resultXD == true)
    {
        foreach ($resultXD as $row)
        {
            echo '<tr>
                <td>' . $row['fname'] . '</td>
                <td>' . $row['lname'] . '</td>
                <td>' . $row['uname'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['nid'] . '</td>
                <td>' . $row['phone'] . '</td>
                <td>' . $row['salary'] . '</td>
                <td>' . $row['accountno'] . '</td>
            </tr>';
        }
    }
    else
    {

    }

?>