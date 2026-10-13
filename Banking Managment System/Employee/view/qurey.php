<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (empty($_SESSION["username"])) { header("location: ../view/employelogin.php"); exit; }
@include("../control/query_news.php");
$pageTitle = 'Customer queries';
@include("../view/header.php");
?>
<h1>Customer queries</h1>

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
<?php @include("../view/footer.php"); ?>
