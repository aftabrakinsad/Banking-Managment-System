<?php
	$cookie_name="uname";
	if(!isset($_COOKIE["uname"]))
	{
		echo " ";
	}
	else
	{
		echo ", ".$_COOKIE[$cookie_name];
	}
?>
