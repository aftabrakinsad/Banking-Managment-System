
<?php

session_start();
if(empty($_SESSION["username"])) 
{
{ header("Location: managerlogin.php"); exit; } // Redirecting To Home Page
}

if(empty($_SESSION["username"])) 
{
{ header("Location: managerlogin.php"); exit; } // Redirecting To Home Page
}

@include("../view/header.php");

?>

    <div class="flex-container">
        <div class="flex-item">
            <h1 id="customer">Welcome to the Dashboard<?php echo $name; ?> <br>Click to Hide</h1>
            <p id="customer">
                <?php @include("../control/viewnews.php"); ?>
                
            </p>
            
        </div>
    </div>
    <script src="../js/homepage.js"></script>
<?php @include("../view/footer.php"); ?>
