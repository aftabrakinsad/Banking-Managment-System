$(document).ready(function()
{
    $(window).scroll(function()
    {
        if ($(window).scrollTop() > 90)
        {
            $("#theTopNav").addClass('navbar-fixed');
        }
        if ($(window).scrollTop() < 90)
        {
            $("#theTopNav").removeClass('navbar-fixed');
        }
    });
});
