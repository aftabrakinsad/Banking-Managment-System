<?php

@include("../control/changepassword.process.php");

?>

<?php

 if ($_SESSION['info'] == false)
  {
     header('location: ../view/employelogin.php');
 }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/password-changed.css">
    <title>Back to Login</title>
</head>

<body class="body">
    <header>
        <?php
        
            @include("../view/header.php");
    
        ?>
    </header>
    <form action="../view/employelogin.php">
        <p>
            <?php
            if (isset($_SESSION['info'])) {
            ?>
                <?php echo $_SESSION['info']; ?>
            <?php
            }
            ?>
        </p>
        <input class="inputbutton" type="submit" name="returntologin" value="Login">
    </form>
</body>

</html>