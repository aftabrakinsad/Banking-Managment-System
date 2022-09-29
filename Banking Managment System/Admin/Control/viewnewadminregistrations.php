<?php
include("../Control/adminregistrationcheck.php");
session_start();

$data = file_get_contents("../Data/adminregistrationdata.json");
$mydata = json_decode($data);
foreach ($mydata as $myobject) {
    foreach ($myobject as $key => $value) {
        echo $key . " => " . $value . "<br>";
    }
    echo "<br><br>";
}
