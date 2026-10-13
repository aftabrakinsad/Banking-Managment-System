<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    { header("location: ../View/adminlogin.php"); exit; }
}

@include("../View/header.php");

?>

    <form action="" method="POST">
        <table>
            <caption>Information Of Selceted Admin</ caption>
            <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">NID</th>
                    <th scope="col">Phone</th>
                    <th scope="col">salary</th>
                    <th scope="col">accountno</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/IIadminmanage.process.php");
                ?>
            </tbody>
        </table>
    </form>
    <br><br>
    <a id="info2" href="../View/adminmanage.php">Go Back</a>
<?php @include("../View/footer.php"); ?>
