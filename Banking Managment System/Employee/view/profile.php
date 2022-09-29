
<!DOCTYPE html>
<html>
<body>
<head>
</head>

<?php
session_start(); 

include('../control/UpdateCheck.php');


if(empty($_SESSION["Email"])) // Destroying All Sessions
{
//header("location: ../control/emplogin.php"); // Redirecting To Home Page
}

?>

]
<h1 align ="Center">Employee Profile Information</h1>



<a href="#">Back </a> 
<a href="../control/employelogout.php"> logout</a>

<h4 align ='center'>Name:<?php echo $_SESSION["Name"];?></h4>
<h4 align ='center'>User Name:<?php echo $_SESSION["Username"];?></h4>
<h4 align ='center'>Email:<?php echo $_SESSION["Email"];?></h4>

<br>
<br>
<h1 align ="center">Update Profile Information</h1>


<br><br>






 
  <p>Edit Profile Information</p>

<form action='' method='post'>
<table> 
<tr>
<td>Email: <?php echo $Email; ?><br><br></td>
</tr>

<tr>
<td>Name: </td>
<td><input type='text' name='Name' value="<?php echo $Name; ?>" > <?php echo $ValidName; ?></td>
</tr>

<tr>
<td>Username: </td> 
<td><input type='text' name='Username' value="<?php echo $User; ?>" > <?php echo $ValidUserName; ?></td>
</tr>

<tr>
<td>Phone:</td> 
<td><input type='text' name='Phone' value="<?php echo $Phone; ?>" > <?php echo $ValidPhone;?></td>
</tr>

<tr>
<td>Address: </td> 
<td><textarea rows="4" cols="50" name="Address" value='$Address'> <?php echo $Address;?> </textarea> <?php echo $ValidAddress;?></td>
</tr>

<tr>
<td>Date of Birth: </td>
<td><input type="date" id="Date" name="Date" value="<?php echo $Date; ?>" ></td>
</tr>

<tr>
<td> Gender: 
     <input type='radio' name='gender' value='Female'<?php echo $radio1; ?>>Female
     <input type='radio' name='gender' value='Male' <?php echo $radio2; ?> >Male
     <input type='radio' name='gender' value='Other'<?php  $radio3; ?> > Other <?php echo $validateradio;?>
</td>
</tr>
<tr>
<td><input name='update' type='submit' value='Update'></td>
</tr>

<tr> 
<td><input name='delete' type='submit' value='Delete'></td>
</tr> 
</table>

</form>

</div>
</fieldset>

<!-- <div class= "footer"> -->
  <h1>Any Issues Cantact Us 24/7 We are Available</h1>
<!-- </div> -->
</body>
</html>