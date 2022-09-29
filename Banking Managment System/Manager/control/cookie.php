

<?php
$cookie_name="username";
if(!isset($_COOKIE["username"])) {
  echo "";
} else {
  echo", ".$_COOKIE[$cookie_name];
  
 
}
?>


