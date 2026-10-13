<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    { header("location: ../View/adminlogin.php"); exit; }
}

@include("../View/header.php");

?>

    <form action="" method="POST" enctype="multipart/form-data">

        <table>
            <caption>Applicant Requests</caption>
            <thead>
                <tr>
                    <th scope="col">Serial</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">NID</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Picture</th>
                    <th scope="col">CV</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>

            <tbody>
                <?php
                @include("../Control/adminrequest.process.php");
                ?>
            </tbody>
        </table>

    </form>
<?php @include("../View/footer.php"); ?>
