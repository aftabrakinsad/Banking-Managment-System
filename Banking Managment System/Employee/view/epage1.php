<?php
session_start();
if(empty($_SESSION["username"]) && empty($_SESSION["password"]))
{
    header("location: ../view/employelogin.php");
}

@include("../view/header.php");

?>

    <div class="flex-container">
        <div class="flex-item">
            <!-- <h1 id="customer">Welcome To The HomePage <?php include('../control/cookie.php'); ?></h1> -->
            <p id="customer"></p>
            <!-- <h3 class="gobacklogin"  >Do you want to <a href="../control/employelogout.php">Logout</a></h3> -->
            <a class="gobacklogin" href="../control/employelogout.php" >Logout</a>
            <!-- <a href="../view/viewinformation.php">Employee  Update </a> -->
        </div>
    </div>
<?php @include("../view/footer.php"); ?>
