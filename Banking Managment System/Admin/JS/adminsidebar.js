for (var i = 0; i < document.links.length; i++)
{
    if (document.URL.indexOf('?') > 0)
    {
        sanitizedURL = document.URL.substring(0, documentURL.indexOf('?'));
    }
    else
    {
        sanitizedURL = document.URL;
    }
    if (document.links[i].href == sanitizedURL)
    {
        document.links[i].className = 'active';
    }
}

function openNav()
{
    document.getElementById("theSideNav").style.width ="256px";
    var x = document.getElementById("theSideNav");
    if (x.className === "sidenav sidenav-fixed")
    {
        x.className += " responsive";
    }
}

function closeNav()
{
    if (document.documentElement.clientWidth < 856)
    {
        document.getElementById("theSideNav").style.width= "0";
    }
}

$(document).ready(function()
{
    $(window).resize(function()
    {
        if ($(window).width() > 855)
        {
            document.getElementById("theSideNav").stylewidth = "256px";
        }
        if (($(window).width()) < 856)
        {
            $('#closebtn').trigger('click');
        }
    });
});


$(document).ready(function()
{
    $(window).scroll(function()
    {
        var x1 = document.getElementById("theSideNav").style.width;
        if ($(window).scrollTop() > 120)
        {
            $("#theSideNav").addClass('sidenav-fixed');
            if (($(window).width()) < 856 && x1 =="256px")
            {
                $('#hamburger').trigger('click');
            }
        }
        if ($(window).scrollTop() < 121)
        {
            $("#theSideNav").removeClass('sidenav-fixed');
        }
    });
});