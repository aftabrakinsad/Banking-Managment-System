<?php

session_start();

if(empty($_SESSION["username"])) 
{
{ header("Location: managerlogin.php"); exit; } // Redirecting To Home Page
}
@include("../view/header.php");

?>

    <form action="" method="POST" enctype="multipart/form-data">

        <table>
       
            <thead>
                
                <tr>
                <center>
                <th scope="col">Sender Account</th>
                    <th scope="col">Recever Account</th>
                    <th scope="col">Transfered Balance</th>
                    <th scope="col">Date of Transaction</th>
                    </center>
                </tr>
               
            </thead>

            <tbody>
                <?php
                @include("../control/viewtransaction.php");
                ?>
            </tbody>
        </table>

    </form>
<?php @include("../view/footer.php"); ?>
