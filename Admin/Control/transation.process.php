<?php

@include("../Model/db.php");

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb ->retriving_transation_history("passbook", $myconn);

if($result == true)
{
    foreach($result as $row)
    {
        echo '<tr>
        <td>'.$row['trans_date'].'</td>
        <td>'.$row['remarks'].'</td>
        <td>'.$row['debit'].'</td>
        <td>'.$row['credit'].'</td>
        <td>'.$row['balance']. '</td>
        <td>' . $row['accountno'] . '</td>
        </tr>';
    }
}

?>