<?php

session_start(); 

$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb -> displaytransaction("transaction",$myconn);
$status='';
// if () {
//     while($row = $result->fetch_assoc())
//     echo "id: ". $row["id"]."<br>"." First Name: ". $row["firstname"]."<br> "."Username : ".
//     $row["username"]."<br>"."Password : ". $row["pass"];
// }
//     else
//     echo "0 results";


    if($result->num_rows>0)
{
    foreach($result as $row)
    { 
        
        echo '<tr>
        <td>'.$row['senderaccount'].'</td>
        <td>'.$row['receveraccount'].'</td>
        <td>'.$row['balancetransfered'].'</td>
        <td>'.$row['Date'].'</td>
       
        </tr>';
       
        
    }
}
?>