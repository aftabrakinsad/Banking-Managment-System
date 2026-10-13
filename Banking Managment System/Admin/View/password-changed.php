<?php

@include("../Control/changepassword.process.php");

?>

<?php

if ($_SESSION['info'] == false) {
    { header('location: ../View/adminlogin.php'); exit; }
}

?>

    <header>
        <?php
        
            @include("../View/public_top.php");
    
        ?>
    </header>
    <form action="../View/adminlogin.php">
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
<?php @include("../View/footer.php"); ?>
