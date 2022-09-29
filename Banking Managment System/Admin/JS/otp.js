function otp_forpasswordchange()
{
    var otp = document.getElementById("otp").value;

    if(!otp)
    {
        document.getElementById("otperr").style.color = "red";
        document.getElementById("otperr").innerHTML = "Enter your otp";
        return false;
    }
    else if(isNaN(otp))
    {
        document.getElementById("otperr").style.color = "red";
        document.getElementById("otperr").innerHTML = "Otp must be numeric value";
        return false;
    }
    else if(!isNaN(otp) && otp.length == 6)
    {
        document.getElementById("otperr").style.color = "green";
        document.getElementById("otperr").innerHTML = "OTP formet valid";
        return true;
    }
    else
    {
        document.getElementById("otperr").style.color = "red";
        document.getElementById("otperr").innerHTML = "OTP is not valid";
        return false;
    }
}

function otp_formcheck()
{
    if(otp_forpasswordchange() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function fade() 
{
    $(document).ready(function()
    {
        $('#otpp').delay(6000).fadeOut();
        $('#accno').delay(6000).fadeOut();
    });
}
fade();
