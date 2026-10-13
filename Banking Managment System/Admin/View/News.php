<?php

@include("../View/public_top.php");

?>

    <form action="">
        <p id="customer">
            <?php
            @include("../Control/viewnews.process.php");
            ?>
        </p>
        <a id="btn" href="/Admin/View/Home.php">Back To Home</a>
    </form>
<?php @include("../View/footer.php"); ?>
