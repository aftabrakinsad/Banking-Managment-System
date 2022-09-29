<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}
include("../control/updateProcess.php");
include("../control/deleteProcess.php");

?>
<head>
<link rel="stylesheet" type="text/CSS" href="../css/updatedesign.css">
    
</head>
<body>
    
<form action="" method="POST" enctype="multipart/form-data" >
            <center>
                <table>
                    <h1>Manage Manager Account</h1>
                    <br>
                <tr>
                        <td>
                            <label>
                                Enter Username :
                            </label>
                        </td>
                        <td> <input type="text" name="uname" id="uname" value="" onchange="existuser()" onkeyup="checkusername()"></td><td><p id="unameerror" ></p> <p id="ajaxresponse"></p></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="search" value= "Search" class="button">
                        </td>
                    </tr>
                    <br>
                    
                    
                    <tr>
                        <td>
                            <label>
                                Firstname:
                            </label>
                        </td>
                        <td> <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" onkeyup="checkfirstname()"></td><td><p id="ferror" ></p></td>
                    </tr>
                    <tr>
                        <td>
                        <label>Lastname: </label> 
                        </td>
                        <td>
                        <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>" onkeyup="checklastname()"> 
                        </td><td><p id="lerror" ></p></td>
                    </tr>
                    <tr><td><label>Gender: </label></td>
                        <td>
                        <input type="text" name="gender" id="gender"value="<?php echo $gender; ?>"  readonly> 
                    </td>
                    </tr>
                    <tr>
                        <td><label>Age :</label></td>
                        <td><input type="text" name="age" id="age" value="<?php echo $age; ?>" ></td>
                    </tr>
                    <tr>
                        <td><label>Father's Name: </label></td>
                        <td><input type="text" name="fathername" id="fathername" value="<?php echo $fathersname; ?>" onkeyup="checkfathername()"></td><td><p id="fathererror" ></p></td>
                    </tr>
                    <tr>
                        <td><label>Mother's Name: </label></td>
                        <td><input type="text" name="mothername" id="mothername" value="<?php echo $mothersname; ?>" onkeyup="checkmothername()"></td><td><p id="mothererror" ></p></td>
                    </tr>
                    
                    <tr>
                        <td>
                        <label>Username: </label>
                        </td>
                        <td>
                        <input type="text" name="username" name="uname"value="<?php echo $uname; ?>" onkeyup="checkusername()" readonly> 
                        </td><td><p id="unameerror" ></p></td>
                    </tr>
                    <tr>
                        <td>
                        <label>Password: </label> 
                        </td>
                        <td>
                        <input type="text" name="pass" id="pass"value="<?php echo $password; ?>" onkeyup="passcheck()">  
                        </td><td><p id="passvalue" ></p></td>
                    </tr>
                    <tr>
                        <td> <label>Email: </label></td>
                        <td><input type="text" name="email" id="email" value="<?php echo $email; ?>" onkeyup="validateemail()"></td><td><p id="emailvalue" ></p></td>
                    </tr>
                    <tr>
                    <td> <label>Present Address: </label></td>
                    <td>
                        <input type="text" name="address" value="<?php echo $presentaddress; ?>">  
                        </td>
                    </tr>
                   
                   
                    <tr>
                        <td> <label>NID Number: </label></td>
                        <td><input type="text" name="nid" id="nid" value="<?php echo $nid; ?>" onkeyup="nidcheck()" ></td><td><p id="niderr" ></p></td>
                    </tr>
                    <tr>
                        <td><label>Phone: </label></td>
                        <td><input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" onkeyup="phonecheck()"></td><td><p id="phoneerr" ></p></td>
                    </tr>
                    <!-- <tr>
                    <td><label>Curriculum Vitae: </label></td>
                    <td><input type="file"name="cv" accept="pdf/*"></td> 

                    </tr>
                    <tr>
                        <td><label>Image: </label></td>
                        <td> <input type="file"  name="img" accept="image/*"></td>  
                    </tr> -->
                    <tr>
                        <td><label>Date of Joining:</label></td>
                        <td><input type="text" name="doj" value="<?php echo $doj; ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label>Salary:</label></td>
                        <td><input type="text" name="salary" value="<?php echo $salary; ?>" onkeyup= "checksalary()"></td>
                    </tr>
                    <tr>
                    <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        </td>
                        <td>

                        <input type="submit" name="update" value="Update" class="button2">
                        </td>
                        
                       
                        
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="delete" value= "delete" class="button4">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                       
                    </tr>
                    
                    <tr>
                        <td> <a href="../view/managerHomePage.php" class="button3">Back</td>
                    </tr>
                    <tr>
                    <br>
                        <td><br><br><br><br><br><br><br></td>
                    </tr>
                </table>
            </center>
        </form>
    </center>
    <script src="../js/update.js"></script>
</body>
</html>