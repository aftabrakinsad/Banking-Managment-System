<?php

@include("../Model/db.php");

$error = array();
$success = array();

if(isset($_POST["submit"]))
{
    $headline = $_POST["headline"];
    $news_details = $_POST["news_details"];

    if(empty($headline) && empty($news_details))
    {
        $error['fields-empty'] = "Please Fill all the fields to post news";
    }
    else if(empty($headline))
    {
        $error['headline-empty'] = "Enter News Headline";
    }
    else if(empty($news_details))
    {
        $error['news_details'] = "Write something to post";
    }
    else
    {
        $headline = $_POST["headline"];
        $news_details = $_POST["news_details"];

        $mydb = new db();
        $myconn = $mydb->openConn();
        $result = $mydb-> post_news($headline, $news_details, "news", $myconn);

        if($result == true)
        {
            $success['news-added'] = "News Post Sucessfully";
        }
    }
}

?>