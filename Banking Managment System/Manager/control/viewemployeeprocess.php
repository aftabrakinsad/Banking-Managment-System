<?php

session_start(); 
if(!empty($_SESSION["username"])) 
{
$username =$_SESSION["username"];
}
$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb ->viewemployee($username,"employee",$myconn);

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
    { if($row["accountstatus"]==NULL)
        {$status ="Pending";}
        if($row["accountstatus"]==1)
        {$status = "Active";}
        if($row["accountstatus"]==2)
        {$status ="Not Active";}
        
        echo '<tr>
        <td>'.$row['fname'].'</td>
        <td>'.$row['lname'].'</td>
        <td>'.$row['Username'].'</td>
        <td>'.$row['Email'].'</td>
        <td>'.$row['NID'].'</td>
        <td>'.$row['Phone'].'</td>
        <td>'.$row['Password'].'</td>
        
        <td>'.$row['gender'].'</td>
        <td><img src="../uploads/'.$row['picture']. '" width="100px" height="100px"></td>
        <td><a id="info" href="../uploads/'.$row['cv']. '">View</a></td>
       <td>'.$row['Salary'].'</td>
       <td>'.$row['Manager'].'</td>
       <td>'.$status.'</td>
        </tr>';
       
        
    }
}
?>