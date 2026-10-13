<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    { header("location: ../View/adminlogin.php"); exit; }
}

@include("../View/header.php");

?>

    <nav>
        <a id="info2" href="../View/add_user.php">ADD User</a>
    </nav>
    <form action="" method="POST" enctype="multipart/form-data">

        <table>
            <caption>User Information</caption>
            <thead>
                <tr>
                    <th scope="col">Serial</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">NID</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account No.</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>

            <tbody>
                <?php
                @include("../Control/user.process.php");
                ?>
            </tbody>
        </table>

    </form>
<?php @include("../View/footer.php"); ?>
