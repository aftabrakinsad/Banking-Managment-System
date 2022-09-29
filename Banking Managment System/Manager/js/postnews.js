function postheadingcheck()
{
    var headline = document.getElementById('headline').value;
    if(!headline)
    {
        document.getElementById('headlineerr').style.color = "red";
        document.getElementById('headlineerr').innerHTML = "News headline required";
        return false;
    }
    else
    {
        return true;
    }
}

function news_details_check()
{
    var news_details = document.getElementById('news_details').value;
    if(!news_details)
    {
        document.getElementById('news_detailserr').style.color = "red";
        document.getElementById('news_detailserr').innerHTML = "Enter Some News to post";
        return false;
    }
    else
    {
        return true;
    }
}

function postnews_formcheck()
{
    if(postheadingcheck() == true && news_details_check() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}