<?php
include("../control/managerprocess.php");
include("../control/homepageProcess.php");

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <div class="flex-container-header">
        <div class="flex-item-header">
            <img src="../Image/banklogo.png"  onclick="eEgg_func()" width="100" height="100">
        </div>

        <div>
            <h1>City BANK</h1>
        </div>

        <div id="flex-item-header">
            <img src=<?php echo $picture;?> onclick="eEgg_func()" width="100" height="100">
            
        </div>
    </div>

</body>

</html>