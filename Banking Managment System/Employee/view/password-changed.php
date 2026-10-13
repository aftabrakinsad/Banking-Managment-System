<?php

@include("../control/changepassword.process.php");

?>

<?php

 if ($_SESSION['info'] == false)
  {
     header('location: ../view/employelogin.php');
 }

?>

    <header>
        <?php
        
            @include("../view/public_top.php");
    
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
<?php @include("../view/footer.php"); ?>
