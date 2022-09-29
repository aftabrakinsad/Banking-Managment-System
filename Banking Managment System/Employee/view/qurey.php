<?php
@include("../control/query_news.php");

// @include("../view/header.php");
@include("../view/emp_navbar.php");
@include("../view/employeeinsidebar.php");

?>

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../CSS/qurey.css">
</head>

<body>
<form class="news_form" action="" method="POST" onsubmit="return postnews_formcheck()">
<div class="flex-container">
<div class=container>
<label>News Headline :</label><br>
<input name="headline" id="headline" size="50" type="text" onkeyup="postheadingcheck()"/>
<p id="headlineerr"></p>
</div>
</div>

<div class="flex-container">
<div class=container>
<label>Details :</label><br>
<textarea class="xd" name="news_details" id="news_details" onkeyup="news_details_check()"></textarea>
<p id="news_detailserr"></p>
</div>
</div>

<div class="flex-container">
<div class="container">
<input class="button" type="submit" name="submit" id="submit" value="Post">
</div>

<div class="container">
<button type="reset" class="reset">Reset</button>
</div>
</div>

</form>
<script src="../JS/postnews.js"></script>
</body>

</html>