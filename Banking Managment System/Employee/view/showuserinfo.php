<?php

session_start();
if(empty($_SESSION["username"]) && empty($_SESSIO["password"]))
{
    { header("location: ../view/employelogin.php"); exit; }
}

@include("../view/header.php");

?>

    <form action="" method="POST" enctype="multipart/form-data">

        <table>
            <caption>User Information</caption>
            <thead>
                <tr>
                    <th scope="col">Seial</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">UserName</th>
                    <th scope="col">Email</th>
                    <th scope="col">NID</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account_NO</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Operation</th>

                </tr>
            </thead>

            <tbody>
            <?php

                  @include("../control/userinfo.process.php");

            ?>
            </tbody>
        </table>

    </form>
<?php @include("../view/footer.php"); ?>
