<!DOCTYPE html>
<html lang="en">
<?php

include("../control/viewinformationemp.php");
?>

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" type="text/CSS" href="../css/registration.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Information Form</title>
</head>

<!-- <h2><a href=''>Back </a></h2> -->

<body bgcolor="skyblue">

<header>

<p><strong>Use correct information to Update </strong>
</p>
</header>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

<h2 class="h3" id="h3">Update ation Form </h2>

<table>


<tr>
<td>
<label>
Enter Username :
</label>
</td>
<td> <input type="text" name="username"  placeholder="Username" value=""></td>
</tr>
<tr>
<td>
<input type="submit" name="Search" value="Search">
</td>
</tr>

<tr>
<td>
<input type="text" name="fname" placeholder="Firstname" value="<?php echo $fname; ?>">
</td>

<td>
<input type="text" name="lname" placeholder="Lastname" value="<?php echo $lname; ?>">
</td>
</tr>

<tr>
<td>
<input type="text" name="uname" placeholder="Username" value="<?php echo $Username;?>"readonly>
</td>

<td>
<input type="text" name="email" placeholder="Email" value="<?php echo $Email; ?>">
</td>
</tr>

<tr>
<td>
<input type="text" name="nid" placeholder="Valid NID" value="<?php echo $NID; ?>" readonly>
</td>

<td>
<input type="text" name="phone" placeholder="+880-1XXXXXXXXX" value="<?php echo $Phone; ?>">
</td>
</tr>

<tr>
<td>
<input type="password" name="password" placeholder="Password" value="<?php echo $Password; ?>" readonly>
</td>

<td>
<input type="password" name="cpassword" placeholder="Confirm Password" value="<?php echo $cpassword; ?>" readonly>
</td>
</tr>

<!-- <tr>
<td>
Please upload your picture
<input type="file" name="picture" value="<?php echo $picture; ?>">
</p>
</td>

<td>
Please upload your cv
<input type="file" name="cv" value="<?php echo $cv; ?>">
</td>
</tr> -->

</table>

<table>

<tr>
<td>


<br>
<br>
<a class="goback" href="../view/employeregistration.php">Back</a>
<input class="login" type="submit" name="update" value="Update">
</td>
</tr>

</table>
</form>
</body>

</html>
