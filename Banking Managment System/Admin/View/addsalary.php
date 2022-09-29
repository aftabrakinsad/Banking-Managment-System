<?php

session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
    header("location: ../View/adminlogin.php");
}

@include("../View/header.php");
@include("../View/navbar.php");
@include("../View/adminsidebar.php");

@include("../Control/add_salary.process.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/CSS" href="../CSS/add_salary.css">
    <title>Add Salary</title>
</head>

<body>
    <form action="" method="POST" onsubmit="return addsalary_formcheck()">

        <table>
            <caption>Add Selected Admins Salary</caption>
            <?php
            if (count($errors) > 0) 
            {
            ?>
                <div>
                    <?php
                    foreach ($errors as $showerror) 
                    {
                        echo "<p id='denger'> $showerror</p>";
                    }
                    ?>
                </div>
            <?php
            } else if (count($success) > 0) 
            {
            ?>
                <div>
                    <?php
                    foreach ($success as $ok) 
                    {
                        echo "<p id='success'> $ok</p>";
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <tr>
                <td>
                    <input type="email" name="email" id="email" placeholder="Enter Email" onkeyup="email_addsalary()"
                    value="<?php echo $email; ?>">
                    <p id="emailerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="nid" id="nid" placeholder="Enter NID" onkeyup="nid_addsalary()"
                    value="<?php echo $nid; ?>">
                    <p id="niderr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="text" name="salary" id="salary" onkeyup="salary_addsalary()" placeholder="Enter Salary Amount">
                    <p id="salaryerr"></p>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="inputbutton" type="submit" name="submit" id="submit" value="Enter">
                </td>
            </tr>
        </table>
    </form>

    <script src="../JS/addsalary.js"></script>
</body>

</html>