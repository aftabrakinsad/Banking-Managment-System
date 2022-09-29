<?php

session_start(); 

$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb -> displaynews("managernews",$myconn);
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
        <td>'.$row['tittle']."|".'</td>
        <td>'.$row['created']."|".'</td>
        <td>'.$row['news_body'].'</td>
        <td>'.", Posted by".'</td>
        <td>'.$row['sender'].'</td>
       <br>
       <br>
       
        </tr>';
       
        
    }
}
?>