<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}

?>
<?php

include("../control/managerprocess.php");

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/registrationdesign.css">
    <title>Document</title>
</head>
<form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
<body >

    <center><h1>Hello<?php include('../control/cookie.php');?></h1></center>
    <center>
    <div class= "header sticky">
        <h1>Welcome to XYZ Bank Limited.</h1>
        <p><strong>To do further work, please register.</strong></p>
        </div>
        <br><br><br><br>
        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
            <center>
                <table class="container">
                    <tr>
                        <td>
                            <label>
                                Firstname:
                            </label>
                        </td>
                        <td> <input type="text" name="fname" id="fname" placeholder="Enter your firstname" onkeyup= "checkfirstname()"></td><td><p id="ferror"></p></td><td> <?php echo $nameErr; ?></td>
                    </tr>
                    <tr>
                        <td>
                        <label>Lastname: </label> 
                        </td>
                        <td>
                        <input type="text" name="lname" id="lname"placeholder="Enter your lastname" onkeyup= "checklastname()"> <td><p id="lerror"></p> <?php echo $name2Err; ?></td>
                        </td>
                    </tr>
                    <tr><td><label>Gender: </label></td>
                        <td>
                            <input type="radio" name="gender" id="male" value="male" onclick= "getradiovalue()">Male
                            <input type="radio" name="gender" id="female" value="female" onclick= "getradiovalue()">Female
                            <input type="radio" name="gender" id="others" value="others"onclick= "getradiovalue()">Others <td><p id="radiovalue"></p><?php echo $genderErr;?> </td>
                    </td>
                    </tr>
                    <tr>
                        <td><label>Date of Birth:</label></td>
                        <td><input type="date" name="dateofbirth" id="dateofbirth" onchange= "agecheck()"></td><td><p id="ageerror"></p><?php echo $dobErr;?> </td>
                    </tr>
                    <tr>
                        <td><label>Father's Name: </label></td>
                        <td><input type="text" name="fathername" id="fathername" placeholder ="Enter your father's name" onkeyup= "checkfathername()"></td><td><p id="fathererror"></p><?php echo $fnameErr; ?></td>
                    </tr>
                    <tr>
                        <td><label>Mother's Name: </label></td>
                        <td><input type="text" name="mothername" id="mothername" placeholder ="Enter your mother's name" onkeyup= "checkmothername()"></td><td><p id="mothererror"></p><?php echo $mnameErr; ?></td>
                    </tr>
                    
                    <tr>
                        <td>
                        <label>Username: </label>
                        </td>
                        <td>
                        <input type="text" name="uname" id="uname" placeholder="Enter your username" onchange= "existuser()" onkeyup= "checkusername()">  <td><p id="unameerror"></p><p id="ajaxresponse"></p><?php echo $unameErr; ?></td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label>Password: </label> 
                        </td>
                        <td>
                        <input type="text" name="pass" id="pass" placeholder ="Enter New Password" onkeyup="passcheck()">  <td><p id="passvalue"></p> <?php echo $passErr; ?></td> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label>Confirm Password: </label> 
                        </td>
                        <td>
                        <input type="text" name="cpass" id="cpass" placeholder ="Enter The Password Again"onkeyup="confirmpasscheck()"> <td><p id="cpassvalue"></p> <?php echo $cpassErr; ?></td> 
                        </td>
                    </tr>
                    <tr>
                    <td> <label>Present Address: </label></td>
                    <td><input type="text" name="street" id="street" placeholder="Enter street no: " onkeyup="addresscheck()">
                 
                </td>
                <div class="custom-select" style="width:200px;">
                <td>
                    
                    <div class ="city">
                    
                    
                    <select name="city">
                    <option value="DHAKA">DHAKA</option>
                    <option value="CHATTOGRAM">CHATTOGRAM</option>
                    <option value="KHULNA">KHULNA</option>
                    <option value="SYLHET">SYLHET</option>
                    <option value="RAJSHAHI">RAJSHAHI</option>
                    <option value="NARAYANGANJ">NARAYANGANJ</option>
                    </select>
                    </div>
                    </td>
                    <td>
                   <div class ="postal">
                
                    <select name="postal" id="postal"class="postal">POSTAL FOR
                    <option value="1211">1211</option>
                    <option value="7899">7899</option>
                    <option value="2899">2899</option>
                    <option value="8002">8002</option>
                    <option value="1900">1900</option>
                    <option value="3399">3399</option>
                    </select>
</div><td><p id="adderror"></p><?php echo  $preaddressErr;?></td>
                    </tr>
                  
                   
                    
                    <tr>
                        <td> <label>Email: </label></td>
                        <td><input type="text" name="email" id ="email" placeholder="Enter your email" onchange="existemail()" onkeyup= "validateemail()"></td><td><p id="emailvalue"></p> <p id="ajaxemail"></p><?php echo $emailErr; ?> </td>
                    </tr>
                    <tr>
                        <td> <label>NID Number: </label></td>
                        <td><input type="text" name="nid" id="nid" placeholder="Enter your valid nid" onchange="existnid()" onkeyup= "nidcheck()"></td><td> <p id="niderr"></p><p id="ajaxnid"></p><?php echo $nidErr; ?> </td>
                    </tr>
                    <tr>
                        <td><label>Phone: </label></td>
                        <td><input type="text" name="phone" id="phone" placeholder="01xxx-xxxxxx" onkeyup= "phonecheck()"></td><td><p id="phoneerr"></p> <?php echo $phnErr; ?> </td>
                    </tr>
                    <tr>
                    <td><label>Curriculum Vitae: </label></td>
                    <td><input type="file"name="cv" id="cv" onchange="fileValidation()"></td> <td> <p id="fileerr"></p><?php echo $fileErr; ?> </td>

                    </tr>
                    <tr>
                        <td><label>Image: </label></td>
                        <td> <input type="file"  name="img" id="img" onchange="imgValidation()"></td>  <td><p id="imgerr"></p> <?php echo $imgErr; ?> </td>
                    </tr>
                    <tr>
                        <td><label>Date of Joining:</label></td>
                        <td><input type="date" name="doj" id="doj" onchange="joiningcheck()"></td><td><p id="joinerror"></p> <?php echo $dojErr; ?> </td>
                    </tr>
                    <tr>
                        <td><label>Salary:</label></td>
                        <td><input type="text" name="salary" id="salary" placeholder="Enter Salary" onkeyup ="checksalary()"></td><td><p id="salerror"></p><?php echo $salaryErr; ?> </td>
                    </tr>
                    <tr>
                    <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        </td>
                        <td>

                        <input type="submit" name="Submit" value="Register" class="button">
                        <input type="reset" value="Reset" class="button2">
                        
                        </td>
                        
                        <td>
                        
                        </td>
                        
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <?php echo $datasave; ?>
                        </td>
                    </tr>
               
                    <tr>
                        <td><a href="../view/managerHomepage.php" class="button3">Back</td>
                    </tr>
                    <tr>
                    <br>
                        <td><br><br><br><br><br><br><br></td>
                    </tr>
                </table>
            </center>
        </form>
    </center>
    <script src="../js/registration.js"></script>
</body>
</html>