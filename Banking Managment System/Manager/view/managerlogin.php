
    <!DOCTYPE html>
    <?php
    
include('../control/logincheck.php');


if(isset($_SESSION['username'])){
header("location: ../view/managerHomePage.php");
}

?>

<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../css/logindesign.css">
    <title>Log In</title>
</head>
<form action ="" method="POST" enctype="multipart/form-data" onsubmit="return formcheck()">
<body>

<center>
<div class= "header sticky">
        <h1>Welcome to the BANK <?php include('../control/cookie.php');?></h1><br>
        </div>
        <header>
        <p><strong><font color="black">Login As An Manager</font></strong></p>
            <br><br><br><br>
        </header>
                 
<table>
    <tr>
    <!-- <td>
        <lable><h3>Username :</h3></label>
       
    </td> -->
    <td> <input type="text"  name ="username" id="username" placeholder="Enter Username"  onchange= "myAJAX()"  onkeyup= "checkusername()"></td><td><p id="nameerror"></p><p id="ajaxresponse"></p></td>
</tr>
<tr>
    <!-- <td>
        <lable><h3>Password  :</h3></label>
        
    </td> -->
    <td>
    <input type="password" name="password" id="password"  placeholder="Enter Password" onkeyup= "loginpassCheck()">
    </td><td><p id="passvalue"></p> </td>
</tr>
<tr>
                        <td>
                        <input type="checkbox" name="remember" id="remember" checked>Remember Me
                        
                        </td>
                    </tr>
       <tr>
           <td>
                  
                    
                          <input class="login" type="submit" name="submit" value="Login"><?php echo $error; ?></td><td>
                          
                    </tr>
                  
                   
                    
</center>
</form>

</center>
<script src="../js/managerlogin.js"></script>
</body>

</html>