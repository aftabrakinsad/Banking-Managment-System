<?php

@include("../Model/db.php");

session_start();

$mydb = new db();
$myconn = $mydb->openConn();
$result = $mydb->displaynews("news", $myconn);

if ($result->num_rows > 0) 
{
    foreach ($result as $row) 
    {

        echo '<tr>
        <td>Tittle: ' . $row['tittle'] . '</td><br>
        <td>Details: ' . $row['news_body'] . '</td> <br>
        <td> Posted by: Admin</td> <br>
        <td>Date & Time: ' . $row['created'] . '</td> <br> <br>
        </tr>';
    }
}

?>