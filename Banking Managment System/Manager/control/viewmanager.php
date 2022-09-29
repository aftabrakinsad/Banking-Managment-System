<?php

session_start(); 

$mydb = new db();
$myconn = $mydb -> openConn();
$result= $mydb -> displayUser("manager",$myconn);
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
    { if($row["activeStatus"]==NULL)
        {$status ="Pending";}
        if($row["activeStatus"]==1)
        {$status = "Active";}
        if($row["activeStatus"]==2)
        {$status ="Not Active";}


        if($row["accountno"]==NULL)
        {$astatus ="Not Given";}
        else
        {$astatus = $row['accountno'];}
        

        $applicant_serial = $row['id'];
        $email = $row['email'];
        echo '<tr>
        <td>'.$row['firstname'].'</td>
        <td>'.$row['lastname'].'</td>
        <td>'.$row['username'].'</td>
        <td>'.$row['gender'].'</td>
        <td>'.$row['age'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['presentaddress'].'</td>
        <td>'.$row['nid'].'</td>
        <td>'.$row['phone'].'</td>
        <td><img src="../uploads/'.$row['imgpath']. '" width="100px" height="100px"></td>
        <td><a id="info" href="../uploads/'.$row['cvpath']. '">View</a></td>
       <td>'.$row['doj'].'</td>
       <td>'.$row['salary'].'</td>
       <td>'.$status.'</td>
       <td>'.$astatus.'</td>
        </tr>';
       
        
    }
}
?>