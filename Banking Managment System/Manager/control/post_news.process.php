<?php
if(!empty($_SESSION["username"])) 
{
$username =  $_SESSION["username"];// Redirecting To Home Page
}




if(isset($_POST["submit"]))
{
    $headline = $_POST["headline"];
    $news_details = $_POST["news_details"];

    if(empty($headline) && empty($news_details))
    {
    }
    else if(empty($headline))
    {
      
    }
    else if(empty($news_details))
    {
       
    }
    else
    {
        $headline = $_POST["headline"];
        $news_details = $_POST["news_details"];

        $mydb = new db();
        $myconn = $mydb->openConn();
        $result = $mydb-> post_news($headline, $news_details, "managernews", $myconn,$username);

        if($result == true)
        {
            
        }
    }
}

?>