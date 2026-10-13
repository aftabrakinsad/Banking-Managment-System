<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    { header("location: ../View/adminlogin.php"); exit; }
}

@include("../View/header.php");

?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table>
            <caption>Selected Admins Details</caption>
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
                    <th scope="col"></th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                @include("../Control/admin_salary_accno.process.php");
                ?>
            </tbody>
        </table>
    </form>
<?php @include("../View/footer.php"); ?>
