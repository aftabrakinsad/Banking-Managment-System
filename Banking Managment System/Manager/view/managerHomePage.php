
<?php

session_start();
if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}

if(empty($_SESSION["username"])) 
{
header("Location: managerlogin.php"); // Redirecting To Home Page
}

@include("../view/header.php");
@include("../view/navbar.php");
@include("../view/sidebar.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/homepage.css">
    <title>Manager Dashboard</title>
</head>

<body>
    <div class="flex-container">
        <div class="flex-item">
            <h1 id="customer">Welcome to the Dashboard<?php echo $name; ?> <br>Click to Hide</h1>
            <p id="customer">
                <?php @include("../control/viewnews.php"); ?>
                
            </p>
            
        </div>
    </div>
    <script src="../js/homepage.js"></script>
</body>

</html>